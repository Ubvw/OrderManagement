<div class="space-y-6 font-inter mt-8">

    {{-- Clean Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        {{-- Title Section --}}
        <div class="flex items-center space-x-4">
            <div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tight">Orders</h1>
                <p class="text-gray-600 text-base font-medium">Manage and track restaurant orders</p>
            </div>
        </div>

        {{-- New Order Button --}}
        @php
            $role = auth()->user()->role->name ?? '';
        @endphp

        @if($role !== 'Food Processor')
            <button wire:click="openModal" class="px-8 py-4 bg-gradient-to-r from-primary to-primary-dark text-white rounded-2xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 font-bold tracking-wide uppercase text-sm shadow-soft">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Order
            </button>
        @endif
    </div>

    {{-- Clean Status Tabs + Search Section --}}
    <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-200">
        <div class="flex justify-between items-center gap-8">
            {{-- Status Tabs --}}
            <div class="flex space-x-3 overflow-x-auto overflow-y-hidden flex-1">
                @php
                    $statuses = [
                        ['key' => 'all', 'label' => 'All', 'color' => 'bg-gray-100 text-gray-700 border-gray-300', 'count' => $this->statusCounts['all']],
                        ['key' => 'pending', 'label' => 'Pending', 'color' => 'bg-yellow-100 text-yellow-700 border-yellow-300', 'count' => $this->statusCounts['pending']],
                        ['key' => 'processing', 'label' => 'Processing', 'color' => 'bg-blue-100 text-blue-700 border-blue-300', 'count' => $this->statusCounts['processing']],
                        ['key' => 'completed', 'label' => 'Completed', 'color' => 'bg-green-100 text-green-700 border-green-300', 'count' => $this->statusCounts['completed']],
                        ['key' => 'cancelled', 'label' => 'Cancelled', 'color' => 'bg-red-100 text-red-700 border-red-300', 'count' => $this->statusCounts['cancelled']],
                    ];
                @endphp
                @foreach ($statuses as $tab)
                    <button wire:click="filterByStatus('{{ $tab['key'] }}')"
                        class="group px-6 py-4 rounded-2xl font-bold focus:outline-none transition-all duration-300 whitespace-nowrap tracking-wide {{ $status === ($tab['key'] === 'all' ? '' : $tab['key']) ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-lg shadow-primary/25 scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800 border border-gray-200 hover:border-gray-300 hover:scale-102' }}">
                        <div class="flex items-center space-x-3">
                            <span class="uppercase text-sm font-black">{{ $tab['label'] }}</span>
                            <span class="px-2.5 py-1 rounded-full text-xs font-black {{ $tab['color'] }} transition-all duration-300 group-hover:scale-110">
                                {{ $tab['count'] }}
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>

            {{-- Search Bar --}}
            <div class="relative w-80 flex-shrink-0">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search orders, tables, notes..."
                    class="bg-gray-50 border border-gray-300 rounded-2xl px-4 py-4 w-full pl-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium text-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-300 hover:scale-110">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-soft animate-in slide-in-from-top-2 duration-300" role="alert">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-1 mr-3">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        </div>
    @endif
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

    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-soft animate-in slide-in-from-top-2 duration-300" role="alert">
            <div class="flex items-center">
                <div class="bg-red-100 rounded-full p-1 mr-3">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Clean Orders Table --}}
    <div class="bg-white rounded-2xl shadow-soft border border-gray-200 overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-200 border-b border-gray-200">
                <tr>
                    <th class="p-6 text-left font-black text-gray-600 uppercase tracking-widest text-xs">Order ID</th>
                    <th class="p-6 text-left font-black text-gray-600 uppercase tracking-widest text-xs">Table</th>
                    <th class="p-6 text-left font-black text-gray-600 uppercase tracking-widest text-xs">Notes</th>
                    <th class="p-6 text-left font-black text-gray-600 uppercase tracking-widest text-xs">Status</th>
                    <th class="p-6 text-left font-black text-gray-600 uppercase tracking-widest text-xs">Total</th>
                    <th class="p-6 text-left font-black text-gray-600 uppercase tracking-widest text-xs">Created</th>
                    <th class="p-6 text-left font-black text-gray-600 uppercase tracking-widest text-xs">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200 group">
                    <td class="p-6 text-gray-800 font-black text-base">#{{ $order->id }}</td>
                    <td class="p-6 text-gray-700 font-bold">Table {{ $order->table_number }}</td>
                    <td class="p-6 text-gray-600 font-medium">{{ $order->notes ?? '-' }}</td>
                    <td class="p-6">
                        <span class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wide transition-all duration-300
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-700 border border-yellow-300
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-700 border border-blue-300
                            @elseif($order->status === 'completed') bg-green-100 text-green-700 border border-green-300
                            @else bg-red-100 text-red-700 border border-red-300
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="p-6 text-gray-800 font-black text-lg tracking-wide">${{ number_format($order->total_amount, 2) }}</td>
                    <td class="p-6 text-gray-600 font-semibold">
                        <div class="text-sm">{{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                    </td>
                    <td class="p-6">
                        <div class="flex items-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity duration-200">
                            @if($role !== 'Cashier')
                                @if($order->status === 'pending')
                                    <button wire:click="updateStatus({{ $order->id }}, 'processing')" 
                                        class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs flex items-center transition-all duration-200 font-bold uppercase tracking-wide shadow-soft hover:shadow-soft-lg hover:scale-105">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                        </svg>
                                        Process
                                    </button>
                                @elseif($order->status === 'processing')
                                    <button wire:click="updateStatus({{ $order->id }}, 'completed')" 
                                        class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs flex items-center transition-all duration-200 font-bold uppercase tracking-wide shadow-soft hover:shadow-soft-lg hover:scale-105">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Complete
                                    </button>
                                @endif

                                @if($order->status === 'pending' || $order->status === 'processing')
                                    <button wire:click="cancelOrder({{ $order->id }})" 
                                        class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs flex items-center transition-all duration-200 font-bold uppercase tracking-wide shadow-soft hover:shadow-soft-lg hover:scale-105">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancel
                                    </button>
                                @endif

                                @if($order->status === 'pending')
                                    <button wire:click="editOrder({{ $order->id }})" 
                                        class="px-4 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl text-xs flex items-center transition-all duration-200 font-bold uppercase tracking-wide shadow-soft hover:shadow-soft-lg hover:scale-105">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                @endif
                            @endif
                            <button wire:click="viewOrder({{ $order->id }})" 
                                class="px-4 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl hover:shadow-lg hover:shadow-primary/25 text-xs flex items-center transition-all duration-200 font-bold uppercase tracking-wide shadow-soft hover:scale-105">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-16 text-center text-gray-500">
                        <div class="flex flex-col items-center space-y-4">
                            <div class="bg-gray-100 rounded-full p-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="space-y-2">
                                <p class="text-xl font-bold text-gray-600">No orders found</p>
                                <p class="text-sm font-medium text-gray-500">Create your first order to get started</p>
                            </div>
                            <button wire:click="openModal" class="mt-4 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-2xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 font-bold text-sm">
                                Create First Order
                            </button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Clean Pagination --}}
    @if($orders->hasPages())
    <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-200">
        {{ $orders->links() }}
    </div>
    @endif

    {{-- Create Order Modal --}}
    @if ($showCreateModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
            
            {{-- Modal Container --}}
            <div class="relative w-full max-w-7xl max-h-[95vh] bg-white rounded-2xl shadow-2xl overflow-hidden">
                {{-- Modal Header --}}
                <div class="bg-gray-50 border-b border-gray-200 p-8 flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-black text-gray-800 tracking-tight">New Order</h1>
                            <p class="text-sm text-gray-600 mt-2 font-semibold">Create and manage your restaurant order</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-primary/20 rounded-2xl p-4">
                                <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            </div>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-300 hover:scale-110 p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="flex-1 overflow-y-auto" style="max-height: calc(95vh - 120px);">
                    <livewire:orders.create wire:key="create-order" />
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Order Details Modal --}}
    @if ($showDetailsModal && $selectedOrder)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-soft-2xl w-[800px] p-8 relative border border-gray-200 max-h-[90vh] overflow-y-auto">
                <button wire:click="closeModal" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors duration-300 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <div class="mb-8">
                    <h2 class="text-3xl font-black text-gray-800 mb-2 tracking-tight">Order #{{ $selectedOrder->id }}</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-primary to-primary-dark rounded-full"></div>
                </div>
                
                {{-- Order Summary Section --}}
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <h3 class="text-lg font-black text-gray-800 mb-4 uppercase tracking-wide">Order Details</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-semibold">Table:</span> 
                                <span class="text-gray-800 font-bold">{{ $selectedOrder->table_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-semibold">Status:</span> 
                                <span class="px-3 py-1 rounded-full text-sm font-black uppercase tracking-wide
                                    @if($selectedOrder->status === 'pending') bg-yellow-100 text-yellow-700 border border-yellow-300
                                    @elseif($selectedOrder->status === 'processing') bg-blue-100 text-blue-700 border border-blue-300
                                    @elseif($selectedOrder->status === 'completed') bg-green-100 text-green-700 border border-green-300
                                    @else bg-red-100 text-red-700 border border-red-300
                                    @endif">
                                    {{ ucfirst($selectedOrder->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <h3 class="text-lg font-black text-gray-800 mb-4 uppercase tracking-wide">Additional Info</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-semibold">Date:</span> 
                                <span class="text-gray-800 font-bold">{{ $selectedOrder->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-semibold">Notes:</span> 
                                <span class="text-gray-800 font-medium">{{ $selectedOrder->notes ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Items Section --}}
                <div class="mb-8">
                    <h3 class="text-lg font-black text-gray-800 mb-4 uppercase tracking-wide">Order Items</h3>
                    <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
                        <table class="w-full text-sm">
                            <thead style="background-color: #F9A55F;">
                                <tr>
                                    <th class="p-4 text-left text-gray-800 font-black uppercase tracking-widest text-xs">Food</th>
                                    <th class="p-4 text-left text-gray-800 font-black uppercase tracking-widest text-xs">Qty</th>
                                    <th class="p-4 text-left text-gray-800 font-black uppercase tracking-widest text-xs">Price</th>
                                    <th class="p-4 text-left text-gray-800 font-black uppercase tracking-widest text-xs">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr class="border-t border-gray-200">
                                        <td class="p-4 text-gray-800 font-bold">{{ $item->product->name ?? '-' }}</td>
                                        <td class="p-4 text-gray-600 font-semibold">{{ $item->quantity }}</td>
                                        <td class="p-4 text-gray-600 font-semibold">${{ number_format($item->price, 2) }}</td>
                                        <td class="p-4 text-gray-800 font-black tracking-wide">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Payment Section --}}
                <div class="border-t border-gray-200 pt-6">
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <div class="text-3xl font-black text-gray-800 mb-3 tracking-wide">
                                    Total: ${{ number_format($selectedOrder->total_amount, 2) }}
                                </div>
                                @if($selectedOrder->payment_received)
                                    <div class="text-sm text-gray-600 space-y-1 font-semibold">
                                        <div>Payment Received: <span class="text-green-600 font-black">${{ number_format($selectedOrder->payment_received, 2) }}</span></div>
                                        <div>Change: <span class="text-blue-600 font-black">${{ number_format($selectedOrder->payment_received - $selectedOrder->total_amount, 2) }}</span></div>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center justify-end">
                                <div class="bg-primary/20 rounded-2xl p-4">
                                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Edit Order Modal --}}
    @if ($showEditModal && $selectedOrder)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
            
            {{-- Modal Container --}}
            <div class="relative w-full max-w-7xl max-h-[95vh] bg-white rounded-2xl shadow-2xl overflow-hidden">
                {{-- Modal Header --}}
                <div class="bg-gray-50 border-b border-gray-200 p-8 flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-black text-gray-800 tracking-tight">Edit Order #{{ $selectedOrder->id }}</h1>
                            <p class="text-sm text-gray-600 mt-2 font-semibold">Modify order details and items</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-primary/20 rounded-2xl p-4">
                                <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </div>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-300 hover:scale-110 p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="flex-1 overflow-y-auto" style="max-height: calc(95vh - 120px);">
                    <livewire:orders.edit :order="$selectedOrder" wire:key="edit-order-{{ $selectedOrder->id }}" />
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
