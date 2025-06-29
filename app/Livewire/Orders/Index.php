<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $perPage = 10;
    public $showCreateModal = false;
    public $showDetailsModal = false;
    public $showEditModal = false;
    public $selectedOrder = null;
    public $orderItems = [];
    public $statusCounts = [];

    // Define valid status transitions
    protected $validTransitions = [
        'pending' => ['processing', 'cancelled'],
        'processing' => ['completed', 'cancelled'],
        'completed' => [], // No transitions allowed from completed
        'cancelled' => [], // No transitions allowed from cancelled
    ];

    protected $listeners = [
        'orderCreated' => 'handleOrderCreated',
        'orderUpdated' => 'handleOrderUpdated',
        'closeModal' => 'closeModal'
    ];
    protected $queryString = ['search', 'status', 'page'];

    public function mount()
    {
        $this->loadStatusCounts();
    }

    public function loadStatusCounts()
    {
        $this->statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
    }

    public function handleOrderCreated($orderId)
    {
        $this->closeModal();
        $this->loadStatusCounts();
        session()->flash('success', 'Order created successfully!');
    }

    public function handleOrderUpdated($orderId)
    {
        $this->closeModal();
        $this->loadStatusCounts();
        session()->flash('success', 'Order updated successfully!');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    protected function isValidTransition($currentStatus, $newStatus)
    {
        // Check if the transition is valid
        return in_array($newStatus, $this->validTransitions[$currentStatus] ?? []);
    }

    protected function getTransitionMessage($currentStatus, $newStatus)
    {
        $messages = [
            'pending' => [
                'processing' => 'Order is now being processed.',
                'cancelled' => 'Order has been cancelled.',
            ],
            'processing' => [
                'completed' => 'Order has been completed successfully.',
                'cancelled' => 'Order has been cancelled during processing.',
            ],
        ];

        return $messages[$currentStatus][$newStatus] ?? 'Status updated.';
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);
        
        if (!$order) {
            session()->flash('error', 'Order not found.');
            return;
        }

        if ($order->status === 'completed') {
            session()->flash('error', 'Cannot cancel a completed order.');
            return;
        }

        if ($order->status === 'cancelled') {
            session()->flash('error', 'Order is already cancelled.');
            return;
        }

        try {
            DB::beginTransaction();

            $order->status = 'cancelled';
            $order->save();

            // Restore stock for each item
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            DB::commit();
            $this->loadStatusCounts();
            session()->flash('message', 'Order cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order cancellation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to cancel order.');
        }
    }

    public function updateStatus($orderId, $newStatus)
    {
        $order = Order::find($orderId);
        
        if (!$order) {
            session()->flash('error', 'Order not found.');
            return;
        }

        if ($order->status === 'completed' || $order->status === 'cancelled') {
            session()->flash('error', 'Cannot update status of completed or cancelled orders.');
            return;
        }

        if ($newStatus === 'completed') {
            // Check stock before completing
            foreach ($order->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    session()->flash('error', "Insufficient stock for {$item->product->name}");
                    return;
                }
            }
        }

        try {
            DB::beginTransaction();

            $order->status = $newStatus;
            $order->save();

            if ($newStatus === 'completed') {
                foreach ($order->items as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            DB::commit();
            $this->loadStatusCounts();
            session()->flash('message', 'Order status updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order status update failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update order status.');
        }
    }

    public function openModal()
    {
        $this->showCreateModal = true;
    }

    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showDetailsModal = false;
        $this->showEditModal = false;
        $this->selectedOrder = null;
        $this->orderItems = [];
    }

    public function handleFlashMessage($type, $message)
    {
        session()->flash($type, $message);
    }

    public function getStatusCountsProperty()
    {
        return [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
    }

    public function filterByStatus($status)
    {
        $this->status = $status === 'all' ? '' : $status;
        $this->resetPage();
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::find($orderId);
        $this->orderItems = $this->selectedOrder->items;
        $this->showDetailsModal = true;
    }

    public function confirmOrder()
    {
        $this->dispatch('orderCreated');
        $this->closeModal();
    }

    public function editOrder($orderId)
    {
        $this->selectedOrder = Order::with('items.product')->find($orderId);
        
        if (!$this->selectedOrder) {
            session()->flash('error', 'Order not found.');
            return;
        }

        if ($this->selectedOrder->status === 'completed' || $this->selectedOrder->status === 'cancelled') {
            session()->flash('error', 'Cannot edit completed or cancelled orders.');
            return;
        }

        $this->showEditModal = true;
    }

    public function render()
    {
        $query = Order::query()
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('table_number', 'like', "%{$this->search}%")
                        ->orWhere('id', 'like', "%{$this->search}%")
                        ->orWhere('notes', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('created_at', 'desc');

        return view('livewire.orders.index', [
            'orders' => $query->paginate(10),
        ]);
    }
}