<div class="space-y-8 font-inter">

    {{-- Integrated Header with Date Range --}}
    <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl p-8 shadow-soft-xl border border-slate-700/50">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            {{-- Title Section --}}
            <div class="flex items-center space-x-6">
                <div class="bg-gradient-to-br from-primary to-primary-dark p-4 rounded-2xl shadow-soft-lg shadow-primary/25">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="space-y-2">
                    <h1 class="text-3xl font-black text-white tracking-tight">
                        Reports & Analytics
                    </h1>
                    <p class="text-slate-300 text-base font-medium">Track your business performance and insights</p>
                </div>
            </div>

            {{-- Date Range Controls --}}
            <div class="flex flex-col sm:flex-row gap-4 lg:min-w-[400px]">
                <div class="flex-1 space-y-2">
                    <label class="block text-slate-200 font-bold text-xs uppercase tracking-wide">Start Date</label>
                    <input type="date" wire:model.live="startDate" 
                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl px-3 py-2 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium text-sm">
                </div>
                <div class="flex-1 space-y-2">
                    <label class="block text-slate-200 font-bold text-xs uppercase tracking-wide">End Date</label>
                    <input type="date" wire:model.live="endDate" 
                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl px-3 py-2 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium text-sm">
                </div>
            </div>
        </div>
    </div>

    {{-- Fixed Tab Navigation --}}
    <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl p-2 shadow-soft-xl border border-slate-700/50">
        <div class="flex space-x-2">
            <button wire:click="$set('tab', 'sales')"
                class="flex-1 flex items-center justify-center space-x-3 py-4 px-6 rounded-2xl font-bold text-sm transition-all duration-300 {{ $tab === 'sales' 
                    ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-glow' 
                    : 'bg-transparent text-slate-300 hover:bg-slate-700/30 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="uppercase tracking-wide">Sales Summary</span>
            </button>
            <button wire:click="$set('tab', 'products')"
                class="flex-1 flex items-center justify-center space-x-3 py-4 px-6 rounded-2xl font-bold text-sm transition-all duration-300 {{ $tab === 'products' 
                    ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-glow' 
                    : 'bg-transparent text-slate-300 hover:bg-slate-700/30 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span class="uppercase tracking-wide">Product Sales</span>
            </button>
        </div>
    </div>

    {{-- Sales Summary Tab --}}
    @if ($tab === 'sales')
        <div class="space-y-8">
            {{-- Key Metrics Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-emerald-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Total Revenue</h3>
                    <p class="text-3xl font-black text-emerald-400 tracking-tight">
                        ${{ number_format($salesSummary['total_revenue'], 2) }}
                    </p>
                </div>

                <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Total Orders</h3>
                    <p class="text-3xl font-black text-blue-400 tracking-tight">
                        {{ number_format($salesSummary['total_orders']) }}
                    </p>
                </div>

                <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Average Order Value</h3>
                    <p class="text-3xl font-black text-purple-400 tracking-tight">
                        ${{ number_format($salesSummary['avg_order_value'], 2) }}
                    </p>
                </div>

                <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-rose-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Cancellation Rate</h3>
                    <p class="text-3xl font-black text-rose-400 tracking-tight">
                        {{ number_format($salesSummary['cancellation_rate'], 1) }}%
                    </p>
                </div>
            </div>

            {{-- Redesigned Business Insights with Minimalist Approach --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-8">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="bg-primary/20 p-3 rounded-2xl">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-white tracking-tight">Business Insights</h3>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Peak Hours - Minimalist Design --}}
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-primary rounded-full"></div>
                            <h4 class="text-lg font-black text-white tracking-tight">Peak Hours</h4>
                            <div class="flex-1 h-px bg-slate-600/30"></div>
                        </div>
                        
                        @if($salesSummary['peak_hours']->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($salesSummary['peak_hours'] as $hour => $count)
                                    <div class="group hover:bg-slate-700/20 rounded-2xl p-4 transition-all duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 bg-slate-700/50 rounded-xl flex items-center justify-center group-hover:bg-slate-600/50 transition-colors duration-200">
                                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-xl font-black text-white">{{ $hour }}</p>
                                                    <p class="text-sm text-slate-400 font-medium">Peak activity</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-2xl font-black text-primary">{{ $count }}</p>
                                                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Orders</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-700/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-semibold">No peak hours data</p>
                            </div>
                        @endif
                    </div>

                    {{-- Best Performing Days - Minimalist Design --}}
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-primary rounded-full"></div>
                            <h4 class="text-lg font-black text-white tracking-tight">Best Performing Days</h4>
                            <div class="flex-1 h-px bg-slate-600/30"></div>
                        </div>
                        
                        @if($salesSummary['best_days']->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($salesSummary['best_days'] as $day => $revenue)
                                    <div class="group hover:bg-slate-700/20 rounded-2xl p-4 transition-all duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 bg-slate-700/50 rounded-xl flex items-center justify-center group-hover:bg-slate-600/50 transition-colors duration-200">
                                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-xl font-black text-white">{{ $day }}</p>
                                                    <p class="text-sm text-slate-400 font-medium">Top performer</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-2xl font-black text-primary">${{ number_format($revenue, 2) }}</p>
                                                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Revenue</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-700/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-semibold">No performance data</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Redesigned Order Completion Stats with Data Visualization Approach --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-8">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="bg-primary/20 p-3 rounded-2xl">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-white tracking-tight">Order Completion Overview</h3>
                </div>
                
                {{-- Progress Bar Visualization --}}
                <div class="space-y-8">
                    @php
                        $totalOrders = $salesSummary['total_orders'];
                        $completedOrders = $salesSummary['completed'];
                        $cancelledOrders = $salesSummary['cancelled'];
                        $completedPercentage = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
                        $cancelledPercentage = $totalOrders > 0 ? ($cancelledOrders / $totalOrders) * 100 : 0;
                    @endphp
                    
                    {{-- Summary Stats --}}
                    <div class="grid grid-cols-3 gap-6">
                        <div class="text-center">
                            <p class="text-4xl font-black text-white mb-2">{{ $totalOrders }}</p>
                            <p class="text-sm text-slate-400 font-semibold uppercase tracking-wide">Total Orders</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-black text-primary mb-2">{{ $completedOrders }}</p>
                            <p class="text-sm text-slate-400 font-semibold uppercase tracking-wide">Completed</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-black text-slate-400 mb-2">{{ $cancelledOrders }}</p>
                            <p class="text-sm text-slate-400 font-semibold uppercase tracking-wide">Cancelled</p>
                        </div>
                    </div>
                    
                    {{-- Visual Progress Bar --}}
                    @if($totalOrders > 0)
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-300 font-semibold">Completion Rate</span>
                                <span class="text-primary font-black">{{ number_format($completedPercentage, 1) }}%</span>
                            </div>
                            
                            <div class="relative">
                                <div class="w-full h-3 bg-slate-700/50 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-primary to-primary-dark rounded-full transition-all duration-1000 ease-out" 
                                         style="width: {{ $completedPercentage }}%"></div>
                                </div>
                                <div class="absolute inset-0 h-3 bg-slate-600/30 rounded-full" 
                                     style="margin-left: {{ $completedPercentage }}%; width: {{ $cancelledPercentage }}%"></div>
                            </div>
                            
                            <div class="flex justify-between text-xs">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                                    <span class="text-slate-400 font-medium">{{ $completedOrders }} Completed</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-slate-600 rounded-full"></div>
                                    <span class="text-slate-400 font-medium">{{ $cancelledOrders }} Cancelled</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-700/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <p class="text-slate-400 font-semibold">No order data available</p>
                        </div>
                    @endif
                    
                    {{-- Performance Insight --}}
                    @if($totalOrders > 0)
                        <div class="bg-slate-700/20 rounded-2xl p-6 border border-slate-600/20">
                            <div class="flex items-start space-x-4">
                                <div class="bg-primary/20 p-2 rounded-xl flex-shrink-0">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold mb-2">Performance Insight</h4>
                                    @if($completedPercentage >= 80)
                                        <p class="text-sm text-slate-300 font-medium">Excellent completion rate! Your order fulfillment is performing very well.</p>
                                    @elseif($completedPercentage >= 60)
                                        <p class="text-sm text-slate-300 font-medium">Good completion rate. Consider analyzing cancelled orders to improve further.</p>
                                    @else
                                        <p class="text-sm text-slate-300 font-medium">Low completion rate detected. Review your order process to reduce cancellations.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Product Sales Tab --}}
    @if ($tab === 'products')
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 overflow-hidden">
            @if($productSummary->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-700/40 backdrop-blur-sm">
                            <tr>
                                <th class="px-8 py-6 text-left font-black text-slate-200 uppercase tracking-widest text-xs border-b border-slate-600/30">Product</th>
                                <th class="px-8 py-6 text-left font-black text-slate-200 uppercase tracking-widest text-xs border-b border-slate-600/30">Units Sold</th>
                                <th class="px-8 py-6 text-left font-black text-slate-200 uppercase tracking-widest text-xs border-b border-slate-600/30">Revenue</th>
                                <th class="px-8 py-6 text-left font-black text-slate-200 uppercase tracking-widest text-xs border-b border-slate-600/30">Avg. Price</th>
                                <th class="px-8 py-6 text-left font-black text-slate-200 uppercase tracking-widest text-xs border-b border-slate-600/30">Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productSummary as $item)
                                <tr class="border-b border-slate-700/30 hover:bg-slate-700/20 transition-all duration-200">
                                    <td class="px-8 py-6">
                                        <div class="text-base font-black text-white">
                                            {{ $item->product?->name ?? 'Deleted Product' }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-base font-bold text-slate-300">{{ number_format($item->total_quantity) }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-base font-black text-emerald-400">${{ number_format($item->total_revenue, 2) }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-base font-bold text-slate-300">${{ number_format($item->avg_price, 2) }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-base font-bold text-slate-300">{{ number_format($item->order_count) }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-slate-700/30 rounded-full p-8 w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-xl font-bold text-slate-300 mb-2">No product sales in this period</p>
                    <p class="text-sm font-medium text-slate-500">Try adjusting your date range to see more data</p>
                </div>
            @endif
        </div>
    @endif
</div>