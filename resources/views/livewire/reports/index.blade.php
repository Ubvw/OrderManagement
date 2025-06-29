<div class="space-y-6 font-inter mt-8">

    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        {{-- Title Section --}}
        <div class="flex items-center space-x-4">
            <div>
                <h1 class="text-5xl font-black text-gray-800 tracking-tight">Reports & Analytics</h1>
                <p class="text-gray-600 text-base font-medium">Track your business performance and insights</p>
            </div>
        </div>

        {{-- Date Range Controls --}}
        <div class="flex flex-col sm:flex-row gap-3 lg:min-w-[350px]">
            <div class="flex-1 space-y-1">
                <label class="block text-gray-700 font-bold text-xs uppercase tracking-wide">Start Date</label>
                <input type="date" wire:model.live="startDate" 
                    class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-300 font-medium text-sm shadow-sm">
            </div>
            <div class="flex-1 space-y-1">
                <label class="block text-gray-700 font-bold text-xs uppercase tracking-wide">End Date</label>
                <input type="date" wire:model.live="endDate" 
                    class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-300 font-medium text-sm shadow-sm">
            </div>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="bg-white rounded-2xl p-2 shadow-soft border border-gray-200">
        <div class="flex space-x-2">
            <button wire:click="$set('tab', 'sales')"
                class="flex-1 flex items-center justify-center space-x-2 py-3 px-4 rounded-xl font-bold text-sm transition-all duration-300 {{ $tab === 'sales' 
                    ? 'text-gray-800 shadow-soft' 
                    : 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}"
                style="{{ $tab === 'sales' ? 'background: linear-gradient(135deg, #F9A55F 0%, #DF9455 100%);' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="uppercase tracking-wide">Sales Summary</span>
            </button>
            <button wire:click="$set('tab', 'products')"
                class="flex-1 flex items-center justify-center space-x-2 py-3 px-4 rounded-xl font-bold text-sm transition-all duration-300 {{ $tab === 'products' 
                    ? 'text-gray-800 shadow-soft' 
                    : 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}"
                style="{{ $tab === 'products' ? 'background: linear-gradient(135deg, #F9A55F 0%, #DF9455 100%);' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span class="uppercase tracking-wide">Dish Sales</span>
            </button>
        </div>
    </div>

    {{-- Sales Summary Tab --}}
    @if ($tab === 'sales')
        <div class="space-y-6">
            {{-- Key Metrics Grid - Clean Minimalist Design --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Total Revenue Card --}}
                <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gray-100 p-3 rounded-xl group-hover:bg-gray-200 transition-colors duration-300">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Total Revenue</h3>
                    <p class="text-2xl font-black text-gray-800 tracking-tight">
                        ${{ number_format($salesSummary['total_revenue'], 2) }}
                    </p>
                </div>

                {{-- Total Orders Card --}}
                <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gray-100 p-3 rounded-xl group-hover:bg-gray-200 transition-colors duration-300">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Total Orders</h3>
                    <p class="text-2xl font-black text-gray-800 tracking-tight">
                        {{ number_format($salesSummary['total_orders']) }}
                    </p>
                </div>

                {{-- Average Order Value Card --}}
                <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gray-100 p-3 rounded-xl group-hover:bg-gray-200 transition-colors duration-300">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Average Order Value</h3>
                    <p class="text-2xl font-black text-gray-800 tracking-tight">
                        ${{ number_format($salesSummary['avg_order_value'], 2) }}
                    </p>
                </div>

                {{-- Cancellation Rate Card - Subtle Red Accent --}}
                <div class="bg-white rounded-2xl shadow-soft border border-red-200 p-6 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-red-50 p-3 rounded-xl group-hover:bg-red-100 transition-colors duration-300">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Cancellation Rate</h3>
                    <p class="text-2xl font-black text-red-600 tracking-tight">
                        {{ number_format($salesSummary['cancellation_rate'], 1) }}%
                    </p>
                </div>
            </div>

            {{-- Business Insights - Clean Design --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                {{-- Peak Hours Data Card --}}
                <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-gray-100 p-3 rounded-xl">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-semibold mb-2 uppercase tracking-wide">Peak Hours Data</p>
                        @if($salesSummary['peak_hours']->isNotEmpty())
                            <p class="text-gray-800 text-3xl font-black tracking-tight">
                                {{ $salesSummary['peak_hours']->keys()->first() }}
                            </p>
                            <p class="text-gray-600 text-sm mt-1 font-medium">{{ $salesSummary['peak_hours']->first() }} orders</p>
                        @else
                            <p class="text-gray-800 text-3xl font-black tracking-tight">--</p>
                            <p class="text-gray-600 text-sm mt-1 font-medium">No data available</p>
                        @endif
                    </div>
                </div>

                {{-- Performance Data Card --}}
                <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-gray-100 p-3 rounded-xl">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-semibold mb-2 uppercase tracking-wide">Performance Data</p>
                        @if($salesSummary['best_days']->isNotEmpty())
                            <p class="text-gray-800 text-3xl font-black tracking-tight">
                                ${{ number_format($salesSummary['best_days']->first(), 0) }}
                            </p>
                            <p class="text-gray-600 text-sm mt-1 font-medium">Best day: {{ $salesSummary['best_days']->keys()->first() }}</p>
                        @else
                            <p class="text-gray-800 text-3xl font-black tracking-tight">$0</p>
                            <p class="text-gray-600 text-sm mt-1 font-medium">No data available</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Order Completion Overview - Clean Design with Strategic Color Use --}}
            <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-gray-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-800 tracking-tight">Order Completion Overview</h3>
                </div>
                
                <div class="space-y-6">
                    @php
                        $totalOrders = $salesSummary['total_orders'];
                        $completedOrders = $salesSummary['completed'];
                        $cancelledOrders = $salesSummary['cancelled'];
                        $completedPercentage = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
                        $cancelledPercentage = $totalOrders > 0 ? ($cancelledOrders / $totalOrders) * 100 : 0;
                    @endphp
                    
                    {{-- Summary Stats with Strategic Color Use --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-3xl font-black text-gray-800 mb-1">{{ $totalOrders }}</p>
                            <p class="text-xs text-gray-600 font-semibold uppercase tracking-wide">Total Orders</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-xl border border-green-200">
                            <p class="text-3xl font-black text-green-700 mb-1">{{ $completedOrders }}</p>
                            <p class="text-xs text-green-700 font-semibold uppercase tracking-wide">Completed</p>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-xl border border-red-200">
                            <p class="text-3xl font-black text-red-600 mb-1">{{ $cancelledOrders }}</p>
                            <p class="text-xs text-red-600 font-semibold uppercase tracking-wide">Cancelled</p>
                        </div>
                    </div>
                    
                    {{-- Visual Progress Bar --}}
                    @if($totalOrders > 0)
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-700 font-semibold">Completion Rate</span>
                                <span class="text-gray-800 font-black">{{ number_format($completedPercentage, 1) }}%</span>
                            </div>
                            
                            <div class="relative">
                                <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500 rounded-full transition-all duration-1000 ease-out" 
                                         style="width: {{ $completedPercentage }}%"></div>
                                </div>
                                <div class="absolute inset-0 h-3 bg-red-500 rounded-full" 
                                     style="margin-left: {{ $completedPercentage }}%; width: {{ $cancelledPercentage }}%"></div>
                            </div>
                            
                            <div class="flex justify-between text-xs">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-gray-700 font-medium">{{ $completedOrders }} Completed</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <span class="text-gray-700 font-medium">{{ $cancelledOrders }} Cancelled</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-semibold">No order data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Product Sales Tab - Clean Design --}}
    @if ($tab === 'products')
        <div class="bg-white rounded-2xl shadow-soft border border-gray-200 overflow-hidden">
            @if($productSummary->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead style="background-color:rgb(223, 223, 223);">
                            <tr>
                                <th class="px-6 py-4 text-left font-black text-gray-800 uppercase tracking-widest text-xs">Dish</th>
                                <th class="px-6 py-4 text-left font-black text-gray-800 uppercase tracking-widest text-xs">Units Sold</th>
                                <th class="px-6 py-4 text-left font-black text-gray-800 uppercase tracking-widest text-xs">Revenue</th>
                                <th class="px-6 py-4 text-left font-black text-gray-800 uppercase tracking-widest text-xs">Dish Price</th>
                                <th class="px-6 py-4 text-left font-black text-gray-800 uppercase tracking-widest text-xs">Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productSummary as $item)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <div class="text-base font-black text-gray-800">
                                            {{ $item->product?->name ?? 'Deleted Product' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-base font-bold text-gray-700">{{ number_format($item->total_quantity) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-base font-black text-green-600">${{ number_format($item->total_revenue, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-base font-bold text-gray-700">${{ number_format($item->avg_price, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-base font-bold text-gray-700">{{ number_format($item->order_count) }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="bg-gray-100 rounded-full p-6 w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-lg font-bold text-gray-700 mb-1">No Dish sales in this period</p>
                    <p class="text-sm font-medium text-gray-500">Try adjusting your date range to see more data</p>
                </div>
            @endif
        </div>
    @endif
</div>