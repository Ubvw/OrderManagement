<div class="space-y-8 font-inter mt-8">

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-soft animate-in slide-in-from-top-2 duration-300" role="alert">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-1 mr-3">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-bold">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    {{-- Clean Header Section --}}
    <div class="flex justify-between items-center">
        <div class="space-y-3">
            <h1 class="text-3xl font-black text-gray-800 tracking-tight">
                {{ $showArchived ? 'Archived Foods' : 'Menu' }}
            </h1>
            <p class="text-gray-600 text-base font-medium">
                {{ $showArchived ? 'Manage archived foods and restore them' : 'Manage your restaurant menu and inventory' }}
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <button wire:click="toggleArchived" 
                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 hover:text-gray-800 transition-all duration-300 font-bold tracking-wide border border-gray-200 hover:border-gray-300">
                {{ $showArchived ? 'Show Active' : 'Show Archived' }}
            </button>
            @if (!$showArchived)
                <button wire:click="create" 
                    class="px-8 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-2xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 font-bold tracking-wide uppercase text-sm shadow-soft">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Foods
                </button>
            @endif
        </div>
    </div>

    {{-- Clean Form Modal --}}
    @if ($showForm)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-soft-2xl w-[800px] max-h-[90vh] overflow-y-auto border border-gray-200">
                {{-- Modal Header --}}
                <div class="bg-gray-50 rounded-t-2xl border-b border-gray-200 p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-black text-gray-800 tracking-tight">
                                {{ $productId ? 'Edit Food' : 'Add Food' }}
                            </h2>
                            <p class="text-sm text-gray-600 mt-2 font-semibold">
                                {{ $productId ? 'Update food information' : 'Create a new menu item' }}
                            </p>
                        </div>
                        <button wire:click="resetForm" class="text-gray-400 hover:text-gray-600 transition-colors duration-300 hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="p-8 bg-white">
                    <form wire:submit.prevent="save" class="space-y-6">
                        {{-- Image Upload --}}
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Food Image</label>
                            <div class="relative">
                                <input type="file" wire:model="image" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium">
                                @error('image') <span class="text-red-500 text-sm font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Image Preview --}}
                            @if ($image)
                                <div class="mt-4">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-2xl border-2 border-gray-200 shadow-soft">
                                </div>
                            @elseif ($imagePath)
                                <div class="mt-4">
                                    <img src="{{ asset('storage/' . $imagePath) }}" class="w-32 h-32 object-cover rounded-2xl border-2 border-gray-200 shadow-soft">
                                </div>
                            @endif
                        </div>

                        {{-- Name --}}
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Name</label>
                            <input type="text" wire:model.defer="name" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium" placeholder="Enter food name">
                            @error('name') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Description</label>
                            <textarea wire:model.defer="description" rows="3" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium resize-none" placeholder="Enter food description"></textarea>
                            @error('description') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Category --}}
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Category</label>
                            <select wire:model.defer="category" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium">
                                <option value="" class="bg-white">Select Category</option>
                                <option value="Hot Dishes" class="bg-white">Hot Dishes</option>
                                <option value="Cold Dishes" class="bg-white">Cold Dishes</option>
                                <option value="Soup" class="bg-white">Soup</option>
                                <option value="Grill" class="bg-white">Grill</option>
                                <option value="Appetizer" class="bg-white">Appetizer</option>
                                <option value="Dessert" class="bg-white">Dessert</option>
                            </select>
                            @error('category') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Price and Stock --}}
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Price</label>
                                <input type="number" wire:model.defer="price" step="0.01" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium" placeholder="0.00">
                                @error('price') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-3">
                                <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Stock</label>
                                <input type="number" wire:model.defer="stock" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium" placeholder="0">
                                @error('stock') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <button type="button" wire:click="resetForm" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 hover:text-gray-800 transition-all duration-300 font-bold tracking-wide">
                                Cancel
                            </button>
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-2xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 font-bold tracking-wide uppercase">
                                {{ $productId ? 'Update Food' : 'Save Food' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    @endif

    {{-- Clean Category Tabs --}}
    <div class="bg-white rounded-2xl p-4 shadow-soft border border-gray-200">
        <div class="flex space-x-3 overflow-x-auto overflow-y-hidden">
            @foreach ($categories as $cat)
                <button 
                    wire:click="$set('selectedCategory', '{{ $cat }}')"
                    class="px-4 py-2 rounded-xl font-bold focus:outline-none transition-all duration-300 whitespace-nowrap tracking-wide {{ $selectedCategory === $cat 
                        ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-lg shadow-primary/25 scale-105' 
                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:text-gray-800 border border-gray-200 hover:border-gray-300 hover:scale-102' }}"
                >
                    <span class="uppercase text-xs font-black">{{ $cat }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Clean Products Grid --}}
    <div class="space-y-6">
        <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-200">
            <h2 class="text-xl font-black text-gray-800 mb-4 tracking-tight">{{ $selectedCategory }}</h2>
            
            @php
                $catProducts = $products->where('category', $selectedCategory);
            @endphp
            
            @if ($catProducts->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($catProducts as $product)
                        <div class="bg-gray-50 rounded-2xl shadow-soft overflow-hidden flex flex-col border border-gray-200 hover:border-gray-300 transition-all duration-300 group hover:shadow-md">
                            {{-- Product Image --}}
                            <div class="h-48 bg-gray-100 flex items-center justify-center relative overflow-hidden">
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="flex flex-col items-center text-gray-400">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm font-semibold">No Image</span>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Product Info --}}
                            <div class="p-4 flex-1 flex flex-col justify-between bg-white">
                                <div class="space-y-3">
                                    <h3 class="font-black text-gray-800 text-lg tracking-tight">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm font-medium line-clamp-2">{{ $product->description }}</p>
                                </div>
                                
                                <div class="space-y-4 mt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-black text-primary tracking-wide">${{ number_format($product->price, 2) }}</span>
                                        <span class="text-sm text-gray-600 font-semibold bg-gray-100 px-3 py-1 rounded-full">
                                            Stock: {{ $product->stock }}
                                        </span>
                                    </div>
                                    
                                    {{-- Action Buttons --}}
                                    <div class="flex space-x-2">
                                        @if (!$showArchived)
                                            <button wire:click="edit({{ $product->id }})"
                                                class="flex-1 bg-gradient-to-r from-primary to-primary-dark text-white py-3 px-4 rounded-xl text-sm font-bold uppercase tracking-wide hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 hover:scale-105">
                                                Edit
                                            </button>
                                            <button wire:click="deleteProduct({{ $product->id }})"
                                                class="flex-1 bg-red-500 hover:bg-red-600 text-white py-3 px-4 rounded-xl text-sm font-bold uppercase tracking-wide transition-all duration-300 hover:scale-105">
                                                Delete
                                            </button>
                                        @else
                                            <button wire:click="restoreProduct({{ $product->id }})"
                                                class="w-full bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-xl text-sm font-bold uppercase tracking-wide transition-all duration-300 hover:scale-105">
                                                Restore
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-gray-100 rounded-full p-8 w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <p class="text-xl font-bold text-gray-700 mb-2">No foods in this category</p>
                    <p class="text-sm font-medium text-gray-500">Add your first food to get started</p>
                    @if (!$showArchived)
                        <button wire:click="create" class="mt-6 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-2xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 font-bold text-sm">
                            Add First Food
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>