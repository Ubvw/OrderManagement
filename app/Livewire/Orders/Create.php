<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    public $table_number;
    public $product_id;
    public $quantity = 1;
    public $notes;
    public $payment_received = 0;
    public $change = 0;
    public $orderItems = [];
    public $products = [];
    public $confirmed = false;

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

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::where('stock', '>', 0)->get()->map(function ($product) {
            // Get the full URL for the image
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
            // Check if table number is empty
            if (empty($this->table_number)) {
                $this->confirmed = false;
                session()->flash('error', 'Table number is required. Please enter a table number.');
                $this->dispatch('checkbox-updated', false);
                return;
            }

            // Check if there are any items in the order
            if (empty($this->orderItems)) {
                $this->confirmed = false;
                session()->flash('error', 'Please add at least one item to the order.');
                $this->dispatch('checkbox-updated', false);
                return;
            }

            // Check if payment is sufficient
            $total = collect($this->orderItems)->sum('subtotal');
            if ($this->payment_received < $total) {
                $this->confirmed = false;
                // Don't flash error here as it's handled in the payment section
                $this->dispatch('checkbox-updated', false);
                return;
            }

            // If all validations pass
            session()->flash('success', 'Order Reviewed');
            $this->dispatch('flash-message', 'success', 'Order Reviewed');
        } else {
            // Clear any success messages when unchecking
            session()->forget('success');
        }
    }

    public function cancel()
    {
        // Reset all form fields to their default state
        $this->reset([
            'table_number',
            'orderItems',
            'payment_received',
            'change',
            'notes',
            'confirmed'
        ]);

        // Clear any flash messages
        session()->forget(['success', 'error']);

        // Dispatch event to close the modal
        $this->dispatch('closeModal');
    }

    public function getCanSubmitProperty()
    {
        return $this->confirmed && 
               !empty($this->table_number) && 
               !empty($this->orderItems) && 
               $this->payment_received >= collect($this->orderItems)->sum('subtotal');
    }

    public function updatedPaymentReceived($value)
    {
        // Ensure the value is numeric and non-negative
        $this->payment_received = is_numeric($value) ? max(0, (float) $value) : 0;
        
        // Calculate change
        $total = collect($this->orderItems)->sum('subtotal');
        $this->change = round($this->payment_received - $total, 2);
    }

    public function addItem($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            session()->flash('error', 'Product not found.');
            return;
        }

        // Check if product already exists in order
        $existingItemIndex = collect($this->orderItems)->search(function ($item) use ($productId) {
            return $item['product_id'] === $productId;
        });

        if ($existingItemIndex !== false) {
            // Check if incrementing would exceed stock
            if ($this->orderItems[$existingItemIndex]['quantity'] + 1 > $product->stock) {
                session()->flash('error', 'Cannot order more than available stock.');
                return;
            }
            // Increment quantity if product exists
            $this->orderItems[$existingItemIndex]['quantity']++;
            $this->updateItemQuantity($existingItemIndex);
            session()->flash('success', 'Product quantity updated successfully.');
        } else {
            // Add new item
            $this->orderItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price
            ];
            session()->flash('success', 'Product added to order successfully.');
        }

        // Recalculate change after adding item
        $this->updatedPaymentReceived($this->payment_received);
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

        // Check if new quantity would exceed stock
        if ($this->orderItems[$index]['quantity'] > $product->stock) {
            session()->flash('error', 'Cannot order more than available stock.');
            $this->orderItems[$index]['quantity'] = $product->stock;
        }

        // Ensure quantity is at least 1
        $this->orderItems[$index]['quantity'] = max(1, (int) $this->orderItems[$index]['quantity']);
        
        // Update subtotal
        $this->orderItems[$index]['subtotal'] = round(
            $this->orderItems[$index]['price'] * $this->orderItems[$index]['quantity'],
            2
        );

        // Recalculate change after updating quantity
        $this->updatedPaymentReceived($this->payment_received);
        session()->flash('success', 'Quantity updated successfully.');
    }

    public function removeItem($index)
    {
        if (isset($this->orderItems[$index])) {
            unset($this->orderItems[$index]);
            $this->orderItems = array_values($this->orderItems); // Reindex array
            
            // Recalculate change after removing item
            $this->updatedPaymentReceived($this->payment_received);
            session()->flash('success', 'Item removed from order successfully.');
        }
    }

    public function save()
    {
        $this->validate();

        // Additional validation for payment
        $total = collect($this->orderItems)->sum('subtotal');
        if ($this->payment_received < $total) {
            $this->addError('payment_received', 'Payment amount is insufficient.');
            session()->flash('error', 'Payment amount is insufficient. Please enter an amount equal to or greater than the total.');
            return;
        }

        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'table_number' => $this->table_number,
                'total_amount' => $total,
                'payment_received' => $this->payment_received,
                'change' => $this->change,
                'notes' => $this->notes,
                'status' => 'pending'
            ]);

            // Create order items
            foreach ($this->orderItems as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();

            // Reset form
            $this->reset(['table_number', 'orderItems', 'payment_received', 'change', 'notes', 'confirmed']);
            
            // Emit event for parent component
            $this->dispatch('orderCreated', $order->id);
            
            session()->flash('success', 'Order created successfully!');

            // Close the modal by dispatching the event to the parent
            $this->dispatch('closeModal');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create order. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.orders.create', [
            'products' => $this->products
        ]);
    }
}
