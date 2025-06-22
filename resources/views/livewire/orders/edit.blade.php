<div class="p-8 space-y-8 bg-slate-800 font-inter">
    <!-- Table Number -->
    <div>
        <label for="table_number" class="block text-sm font-bold text-slate-200 mb-3 tracking-wide uppercase">Table Number</label>
        <input type="number" id="table_number" wire:model="table_number" 
               class="w-full max-w-xs px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl focus:bg-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200 text-xl font-semibold text-white placeholder-slate-400 tracking-wide" 
               min="1" placeholder="Enter table number">
        @error('table_number') 
            <span class="flex items-center mt-2 text-red-400 text-sm font-medium">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </span> 
        @enderror
    </div>

    <!-- Product Selection -->
    <div>
        <h3 class="text-lg font-bold text-slate-200 mb-4 tracking-wide">Select Products</h3>
        <div class="bg-slate-700/30 rounded-xl border border-slate-600 p-6">
            <div class="h-80 overflow-y-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-4">
                    @foreach($products as $product)
                    <div class="bg-slate-800/50 rounded-lg border border-slate-600 overflow-hidden hover:shadow-lg hover:shadow-primary/10 hover:border-primary/50 transition-all duration-200 group backdrop-blur-sm">
                        <div class="aspect-square overflow-hidden">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                            @else
                                <div class="w-full h-full bg-slate-700/50 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 text-slate-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-slate-500 text-xs font-medium">No Image</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h4 class="font-bold text-white text-sm mb-1 line-clamp-1 leading-tight">{{ $product->name }}</h4>
                            <p class="text-xs text-slate-400 mb-2 font-medium">Stock: <span class="text-slate-300 font-semibold">{{ $product->stock }}</span></p>
                            <p class="text-base font-black text-primary mb-3 tracking-wide">${{ number_format($product->price, 2) }}</p>
                            <button wire:click="addItem({{ $product->id }})" 
                                    class="w-full px-3 py-2 text-xs font-bold rounded-md text-white bg-gradient-to-r from-primary to-primary-dark hover:shadow-lg hover:shadow-primary/25 transition-all duration-200 transform hover:scale-105 tracking-wide uppercase">
                                Add to Order
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items and Payment Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Order Items - Takes 2 columns -->
        <div class="lg:col-span-2">
            <h3 class="text-lg font-bold text-slate-200 mb-4 tracking-wide">Order Items</h3>
            <div class="bg-slate-700/30 rounded-xl border border-slate-600 overflow-hidden backdrop-blur-sm">
                <table class="min-w-full">
                    <thead class="bg-slate-600/50">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-black text-slate-200 uppercase tracking-widest">Product</th>
                            <th class="px-4 py-4 text-left text-xs font-black text-slate-200 uppercase tracking-widest">Quantity</th>
                            <th class="px-4 py-4 text-left text-xs font-black text-slate-200 uppercase tracking-widest">Price</th>
                            <th class="px-4 py-4 text-left text-xs font-black text-slate-200 uppercase tracking-widest">Subtotal</th>
                            <th class="px-4 py-4 text-left text-xs font-black text-slate-200 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-slate-800/30 divide-y divide-slate-600">
                        @foreach($orderItems as $index => $item)
                        <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                            <td class="px-4 py-4 text-sm font-bold text-white">{{ $item['name'] }}</td>
                            <td class="px-4 py-4">
                                <input type="number" wire:model="orderItems.{{ $index }}.quantity" 
                                       wire:change="updateItemQuantity({{ $index }})" 
                                       class="w-16 px-2 py-2 bg-slate-700/50 border border-slate-600 rounded-md focus:bg-slate-700 focus:border-primary focus:ring-1 focus:ring-primary/20 text-center text-sm text-white font-bold" 
                                       min="1">
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-300 font-semibold">${{ number_format($item['price'], 2) }}</td>
                            <td class="px-4 py-4 text-sm font-black text-primary tracking-wide">${{ number_format($item['subtotal'], 2) }}</td>
                            <td class="px-4 py-4">
                                <button wire:click="removeItem({{ $index }})" 
                                        class="text-xs font-bold text-red-400 hover:text-red-300 bg-red-900/30 hover:bg-red-900/50 px-3 py-2 rounded-md transition-all duration-200 border border-red-700/50 uppercase tracking-wide">
                                    Remove
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Order Total -->
                @if(count($orderItems) > 0)
                <div class="bg-slate-600/50 px-6 py-5 border-t border-slate-600">
                    <div class="flex justify-between items-center">
                        <span class="text-base font-bold text-slate-200 tracking-wide uppercase">Order Total:</span>
                        <span class="text-2xl font-black text-primary tracking-wide">${{ number_format(collect($orderItems)->sum('subtotal'), 2) }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Section - Takes 1 column -->
        <div>
            <h3 class="text-lg font-bold text-slate-200 mb-4 tracking-wide">Payment</h3>
            <div class="bg-slate-700/30 rounded-xl border border-slate-600 p-6 space-y-6 backdrop-blur-sm">
                <div>
                    <label for="payment_received" class="block text-sm font-bold text-slate-200 mb-3 tracking-wide uppercase">Amount Received</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 text-lg font-bold">$</span>
                        </div>
                        <input type="number" id="payment_received" wire:model.live="payment_received" 
                               class="w-full pl-8 pr-4 py-4 bg-slate-700/50 border border-slate-600 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200 text-white placeholder-slate-400 text-lg font-bold tracking-wide" 
                               step="0.01" min="0" placeholder="0.00">
                    </div>
                    @if($payment_received < collect($orderItems)->sum('subtotal'))
                        <span class="flex items-center mt-3 text-red-400 text-sm font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Payment amount is insufficient. Please enter an amount equal to or greater than the total.
                        </span>
                    @endif
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-200 mb-3 tracking-wide uppercase">Change</label>
                    <div class="bg-slate-800/50 border border-slate-600 rounded-lg p-5">
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black {{ $this->change >= 0 ? 'text-green-400' : 'text-red-400' }} tracking-wide">
                                ${{ number_format($this->change, 2) }}
                            </span>
                            <div class="w-10 h-10 rounded-full {{ $this->change >= 0 ? 'bg-green-900/50 text-green-400' : 'bg-red-900/50 text-red-400' }} flex items-center justify-center">
                                @if($this->change >= 0)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Notes -->
    <div>
        <label for="notes" class="block text-sm font-bold text-slate-200 mb-3 tracking-wide uppercase">Order Notes</label>
        <textarea id="notes" wire:model="notes" rows="3" 
                  class="w-full px-4 py-4 bg-slate-700/50 border border-slate-600 rounded-xl focus:bg-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200 resize-none text-white placeholder-slate-400 font-medium leading-relaxed" 
                  placeholder="Add any special instructions or notes for this order..."></textarea>
    </div>

    <!-- Confirmation and Submit -->
    <div class="border-t border-slate-600 pt-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" id="confirmed" wire:model.live="confirmed" 
                       x-data
                       x-on:livewire:checkbox-updated.window="if ($event.detail === false) $el.checked = false"
                       class="h-5 w-5 text-primary focus:ring-primary border-slate-500 rounded bg-slate-700">
                <label for="confirmed" class="ml-3 text-sm text-slate-300 font-semibold">
                    I have reviewed this order and confirm all details are correct
                </label>
            </div>
            
            <div class="flex space-x-4">
                <button type="button" wire:click="cancel"
                        class="px-8 py-3 text-sm font-bold text-slate-300 bg-slate-700/50 border border-slate-600 rounded-lg hover:bg-slate-600/50 hover:text-white transition-all duration-200 tracking-wide uppercase">
                    Cancel
                </button>
                
                <button wire:click="save" 
                        class="px-8 py-3 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-dark hover:shadow-lg hover:shadow-primary/25 rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 tracking-wide uppercase"
                        @if(!$this->canSubmit) disabled @endif>
                    Update Order
                </button>
            </div>
        </div>
        
        @error('confirmed') 
            <div class="flex items-center mt-4 text-red-400 text-sm font-semibold">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div> 
        @enderror
    </div>

    <!-- Flash Messages -->
    <div class="fixed bottom-4 right-4 space-y-2 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
        @if (session()->has('success'))
            <div class="p-4 bg-green-900/50 border border-green-700 rounded-lg shadow-lg backdrop-blur-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 bg-red-900/50 border border-red-700 rounded-lg shadow-lg backdrop-blur-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-red-400">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div> 

@php
    $isFoodProcessor = auth()->user()->role->name === 'Food Processor';
@endphp

{{-- Example: Allow editing quantity but not price/name --}}
@foreach ($orderItems as $index => $item)
    <div class="flex gap-4 mb-3">
        {{-- Product name (readonly) --}}
        <input type="text" value="{{ $item['name'] }}" class="bg-gray-100 text-gray-500" readonly>

        {{-- Quantity (editable) --}}
        <input type="number" wire:model="orderItems.{{ $index }}.quantity" min="1">

        {{-- Price (readonly for Food Processor) --}}
        @if (!$isFoodProcessor)
            <input type="number" wire:model="orderItems.{{ $index }}.price">
        @else
            <input type="number" value="{{ $item['price'] }}" readonly class="bg-gray-100 text-gray-500">
        @endif
    </div>
@endforeach