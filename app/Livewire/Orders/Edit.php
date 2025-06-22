<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $order;
    public $table_number;
    public $product_id;
    public $quantity = 1;
    public $notes;
    public $payment_received = 0;
    public $change = 0;
    public $orderItems = [];
    public $products = [];
    public $confirmed = false;
    public $canSubmit = false;

    protected $rules = [
        'table_number' => 'required|integer|min:1',
        'orderItems' => 'required|array|min:1',
        'orderItems.*.quantity' => 'required|integer|min:1',
        'payment_received' => 'required|numeric|min:0',
        'notes' => 'nullable|string|max:500',
        'confirmed' => 'required|accepted'
    ];

    protected $messages = [
        'table_number.required' => 'Please enter a table number.',
        'table_number.integer' => 'Table number must be a whole number.',
        'table_number.min' => 'Table number must be at least 1.',
        'orderItems.required' => 'Please add at least one item to the order.',
        'orderItems.min' => 'Please add at least one item to the order.',
        'orderItems.*.quantity.required' => 'Quantity is required.',
        'orderItems.*.quantity.integer' => 'Quantity must be a whole number.',
        'orderItems.*.quantity.min' => 'Quantity must be at least 1.',
        'payment_received.required' => 'Please enter the payment amount.',
        'payment_received.numeric' => 'Payment amount must be a number.',
        'payment_received.min' => 'Payment amount cannot be negative.',
        'notes.max' => 'Notes cannot exceed 500 characters.',
        'confirmed.required' => 'Please confirm that you have reviewed the order.',
        'confirmed.accepted' => 'Please confirm that you have reviewed the order.'
    ];

    protected $listeners = ['paymentReceivedUpdated' => 'updatePayment'];

    public function mount(Order $order)
    {
        // Authorization check 
        if (Auth::user()->role->name !== 'Food Processor') {
            abort(403); // Forbidden
        }

        $this->order = $order;
        $this->table_number = $order->table_number;
        $this->notes = $order->notes;
        $this->payment_received = $order->payment_received;
        $this->change = $order->change;

        // Load existing order items
        foreach ($order->items as $item) {
            $this->orderItems[] = [
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->subtotal
            ];
        }

        $this->loadProducts();
        $this->updateCanSubmit();
        
    }

    public function loadProducts()
    {
        $this->products = Product::where('stock', '>', 0)
            ->orWhereIn('id', collect($this->orderItems)->pluck('product_id'))
            ->get()
            ->map(function ($product) {
                $product->image_url = $product->image 
                    ? (str_starts_with($product->image, 'http') 
                        ? $product->image 
                        : asset('storage/' . $product->image))
                    : asset('images/no-image.png');
                return $product;
            });
    }

    public function getSubtotalProperty()
    {
        return collect($this->orderItems)->sum('subtotal');
    }

    public function getTotalProperty()
    {
        return $this->subtotal;
    }

    public function getChangeProperty()
    {
        return max(0, $this->payment_received - $this->total);
    }

    public function updatedConfirmed($value)
    {
        if ($value) {
            if (empty($this->table_number)) {
                $this->confirmed = false;
                session()->flash('error', 'Table number is required. Please enter a table number.');
                $this->dispatch('checkbox-updated', false);
                return;
            }

            if (empty($this->orderItems)) {
                $this->confirmed = false;
                session()->flash('error', 'Please add at least one item to the order.');
                $this->dispatch('checkbox-updated', false);
                return;
            }

            $total = collect($this->orderItems)->sum('subtotal');
            if ($this->payment_received < $total) {
                $this->confirmed = false;
                $this->dispatch('checkbox-updated', false);
                return;
            }

            session()->flash('success', 'Order Reviewed');
            $this->dispatch('flash-message', 'success', 'Order Reviewed');
        } else {
            session()->forget('success');
        }
        $this->updateCanSubmit();
    }

    public function cancel()
    {
        $this->dispatch('closeModal');
    }

    public function updateCanSubmit()
    {
        $this->canSubmit = $this->confirmed && 
            !empty($this->table_number) && 
            !empty($this->orderItems) && 
            $this->payment_received >= collect($this->orderItems)->sum('subtotal');
    }

    public function updatedPaymentReceived($value)
    {
        $this->payment_received = is_numeric($value) ? max(0, (float) $value) : 0;
        $total = collect($this->orderItems)->sum('subtotal');
        $this->change = round($this->payment_received - $total, 2);
        $this->updateCanSubmit();
    }

    public function addItem($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            session()->flash('error', 'Product not found.');
            return;
        }

        $existingItemIndex = collect($this->orderItems)->search(function ($item) use ($productId) {
            return $item['product_id'] === $productId;
        });

        if ($existingItemIndex !== false) {
            if ($this->orderItems[$existingItemIndex]['quantity'] + 1 > $product->stock) {
                session()->flash('error', 'Cannot order more than available stock.');
                return;
            }
            $this->orderItems[$existingItemIndex]['quantity']++;
            $this->updateItemQuantity($existingItemIndex);
            session()->flash('success', 'Product quantity updated successfully.');
        } else {
            $this->orderItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price
            ];
            session()->flash('success', 'Product added to order successfully.');
        }

        $this->updatedPaymentReceived($this->payment_received);
        $this->updateCanSubmit();
    }

    public function updateItemQuantity($index)
    {
        if (!isset($this->orderItems[$index])) {
            return;
        }

        $product = Product::find($this->orderItems[$index]['product_id']);
        if (!$product) {
            session()->flash('error', 'Product not found.');
            return;
        }

        if ($this->orderItems[$index]['quantity'] > $product->stock) {
            session()->flash('error', 'Cannot order more than available stock.');
            $this->orderItems[$index]['quantity'] = $product->stock;
        }

        $this->orderItems[$index]['quantity'] = max(1, (int) $this->orderItems[$index]['quantity']);
        $this->orderItems[$index]['subtotal'] = round(
            $this->orderItems[$index]['price'] * $this->orderItems[$index]['quantity'],
            2
        );

        $this->updatedPaymentReceived($this->payment_received);
        $this->updateCanSubmit();
        session()->flash('success', 'Quantity updated successfully.');
    }

    public function removeItem($index)
    {
        if (isset($this->orderItems[$index])) {
            unset($this->orderItems[$index]);
            $this->orderItems = array_values($this->orderItems);
            $this->updatedPaymentReceived($this->payment_received);
            $this->updateCanSubmit();
            session()->flash('success', 'Item removed from order successfully.');
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Restrict changes for Food Processor role
            $role = Auth::user()->role->name;

            if ($role === 'Food Processor') {
                foreach ($this->orderItems as $item) {
                    $orderItem = $this->order->items()->where('product_id', $item['product_id'])->first();

                    if ($orderItem) {
                        $orderItem->quantity = $item['quantity'];
                        $orderItem->subtotal = $item['quantity'] * $orderItem->price;
                        $orderItem->save();
                    }
                }

                $this->order->notes = $this->notes;
                $this->order->save();

                DB::commit();

                session()->flash('success', 'Order quantities updated.');
                $this->dispatch('orderUpdated', $this->order->id);
                return;
            }

            // --- For other roles (e.g., Admin, Cashier) ---
            $total = collect($this->orderItems)->sum('subtotal');

            if ($this->payment_received < $total) {
                $this->addError('payment_received', 'Payment amount is insufficient.');
                session()->flash('error', 'Payment amount is insufficient. Please enter an amount equal to or greater than the total.');
                return;
            }

            $this->order->update([
                'table_number' => $this->table_number,
                'total_amount' => $total,
                'payment_received' => $this->payment_received,
                'change' => $this->change,
                'notes' => $this->notes
            ]);

            // Delete old and create new items
            $this->order->items()->delete();
            foreach ($this->orderItems as $item) {
                $this->order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);

                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();
            session()->flash('success', 'Order updated successfully!');
            $this->dispatch('orderUpdated', $this->order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order update failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update order. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.orders.edit', [
            'products' => $this->products
        ]);
    }
} 