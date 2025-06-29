<div class="space-y-8 font-inter">
    {{-- Loading Overlay --}}
    <div wire:loading class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-3xl p-8 shadow-soft-xl border border-gray-200">
            <div class="flex items-center space-x-4">
                <svg class="w-8 h-8 text-primary animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <div>
                    <p class="text-gray-800 font-bold text-lg">Refreshing Dashboard</p>
                    <p class="text-gray-600 text-sm">Updating real-time data...</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        {{-- Title Section --}}
        <div class="flex items-center space-x-4">
            <div>
                <h1 class="text-5xl font-black text-gray-800 tracking-tight">Dashboard</h1>
                <p class="text-gray-600 text-base font-medium">Welcome back! Here's what's happening today.</p>
            </div>
        </div>

        {{-- Refresh Button --}}
        <div class="flex items-center space-x-3">
            <button wire:click="refresh" wire:loading.attr="disabled" class="bg-primary/20 hover:bg-primary/30 disabled:opacity-50 p-3 rounded-2xl transition-all duration-300 group">
                <svg wire:loading.remove class="w-6 h-6 text-primary group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <svg wire:loading class="w-6 h-6 text-primary animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Clean Minimalist Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-6">
        {{-- Today's Sales --}}
        <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gray-100 p-3 rounded-xl group-hover:bg-gray-200 transition-colors duration-300">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wide">Today's Sales</h2>
            <p class="text-3xl font-black text-gray-800 tracking-tight">${{ number_format($todaySales, 2) }}</p>
        </div>

        {{-- Total Orders --}}
        <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gray-100 p-3 rounded-xl group-hover:bg-gray-200 transition-colors duration-300">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wide">Total Orders</h2>
            <p class="text-3xl font-black text-gray-800 tracking-tight">{{ $todayOrders }}</p>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gray-100 p-3 rounded-xl group-hover:bg-gray-200 transition-colors duration-300">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wide">Pending</h2>
            <p class="text-3xl font-black text-gray-800 tracking-tight">{{ $pending }}</p>
        </div>

        {{-- Processing --}}
        <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gray-100 p-3 rounded-xl group-hover:bg-gray-200 transition-colors duration-300">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wide">Processing</h2>
            <p class="text-3xl font-black text-gray-800 tracking-tight">{{ $processing }}</p>
        </div>

        {{-- Completed - Strategic Green Accent --}}
        <div class="bg-white rounded-2xl shadow-soft border border-green-200 p-6 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-50 p-3 rounded-xl group-hover:bg-green-100 transition-colors duration-300">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wide">Completed</h2>
            <p class="text-3xl font-black text-green-600 tracking-tight">{{ $completed }}</p>
        </div>

        {{-- Cancelled - Strategic Red Accent --}}
        <div class="bg-white rounded-2xl shadow-soft border border-red-200 p-6 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-red-50 p-3 rounded-xl group-hover:bg-red-100 transition-colors duration-300">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wide">Cancelled</h2>
            <p class="text-3xl font-black text-red-600 tracking-tight">{{ $cancelled }}</p>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Top Products Pie Chart --}}
        <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-gray-100 p-2 rounded-xl">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-gray-800 tracking-tight">Top 3 Dishes Today</h2>
            </div>
            
            @if($topProducts->isNotEmpty())
                @php
                    $totalQuantity = $topProducts->sum('total_quantity');
                    $colors = ['#F9A55F', '#6B7280', '#9CA3AF']; // Orange primary, then grays
                @endphp
                
                <div class="flex items-center justify-center">
                    {{-- Pie Chart SVG --}}
                    <div class="relative">
                        <svg width="200" height="200" viewBox="0 0 200 200" class="transform -rotate-90">
                            @php
                                $currentAngle = 0;
                                $centerX = 100;
                                $centerY = 100;
                                $radius = 70;
                            @endphp
                            
                            @foreach($topProducts as $index => $item)
                                @php
                                    $percentage = $totalQuantity > 0 ? ($item->total_quantity / $totalQuantity) * 100 : 0;
                                    $angle = ($percentage / 100) * 360;
                                    $endAngle = $currentAngle + $angle;
                                    
                                    $x1 = $centerX + $radius * cos(deg2rad($currentAngle));
                                    $y1 = $centerY + $radius * sin(deg2rad($currentAngle));
                                    $x2 = $centerX + $radius * cos(deg2rad($endAngle));
                                    $y2 = $centerY + $radius * sin(deg2rad($endAngle));
                                    
                                    $largeArcFlag = $angle > 180 ? 1 : 0;
                                    
                                    $pathData = "M $centerX $centerY L $x1 $y1 A $radius $radius 0 $largeArcFlag 1 $x2 $y2 Z";
                                @endphp
                                
                                <path d="{{ $pathData }}" 
                                      fill="{{ $colors[$index] }}" 
                                      stroke="#ffffff" 
                                      stroke-width="2"
                                      class="hover:opacity-80 transition-all duration-300 cursor-pointer">
                                </path>
                                
                                @php $currentAngle = $endAngle; @endphp
                            @endforeach
                            
                            {{-- Center circle for donut effect --}}
                            <circle cx="100" cy="100" r="30" fill="#ffffff" stroke="#e5e7eb" stroke-width="2"/>
                        </svg>
                        
                        {{-- Center text --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-gray-800 font-black text-lg">{{ $totalQuantity }}</p>
                                <p class="text-gray-600 text-xs font-medium">Total Units</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Legend --}}
                <div class="mt-6 space-y-3">
                    @foreach($topProducts as $index => $item)
                        @php
                            $percentage = $totalQuantity > 0 ? ($item->total_quantity / $totalQuantity) * 100 : 0;
                        @endphp
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $colors[$index] }}"></div>
                                <div>
                                    <p class="text-gray-800 font-bold text-sm">{{ $item->product_name }}</p>
                                    <p class="text-gray-600 text-xs">{{ $item->total_quantity }} units</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-800 font-black text-sm">{{ number_format($percentage, 1) }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 font-semibold">No sales data available today</p>
                </div>
            @endif
        </div>

        {{-- Today's Orders Timeline Column Chart --}}
        <div class="bg-white rounded-2xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-gray-100 p-2 rounded-xl">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-black text-gray-800 tracking-tight">Today's Order Timeline</h2>
                    <p class="text-gray-600 text-xs font-medium">Orders per hour during business hours (8AM - 10PM)</p>
                </div>
            </div>
            
            @php
                // Use dynamic data from Livewire component
                $businessHours = $hourlyOrders;
                
                $maxOrders = max($businessHours);
                $totalBusinessOrders = array_sum($businessHours);
                $peakHour = $maxOrders > 0 ? array_search($maxOrders, $businessHours) : null;
            @endphp
            
            @if($totalBusinessOrders > 0)
                {{-- Column Chart Container --}}
                <div class="relative h-48 mb-4">
                    <div class="flex items-end justify-between h-full px-2 pb-6 space-x-1">
                        @foreach($businessHours as $hour => $orders)
                            @php
                                $height = $maxOrders > 0 ? ($orders / $maxOrders) * 140 : 0; // Scale to max height of 140px
                                $isPeak = $orders === $maxOrders && $orders > 0;
                            @endphp
                            <div class="flex flex-col items-center space-y-1 flex-1">
                                {{-- Column --}}
                                <div class="relative group cursor-pointer w-full max-w-6">
                                    <div class="bg-gradient-to-t {{ $isPeak ? 'from-primary to-primary-dark shadow-lg' : 'from-gray-400 to-gray-500' }} rounded-t-lg transition-all duration-500 hover:from-primary hover:to-primary-dark hover:shadow-lg transform hover:scale-105" 
                                         style="height: {{ $height }}px;"
                                         data-hour="{{ $hour }}"
                                         data-orders="{{ $orders }}">
                                    </div>
                                    
                                    {{-- Value on hover --}}
                                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        {{ $orders }} orders
                                    </div>
                                </div>
                                
                                {{-- Hour label --}}
                                <div class="text-xs text-gray-600 font-medium">
                                    {{ $hour == 12 ? '12PM' : ($hour < 12 ? $hour.'AM' : ($hour-12).'PM') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Y-axis reference lines --}}
                    <div class="absolute left-0 top-0 h-full w-full pointer-events-none">
                        @for($i = 1; $i <= 3; $i++)
                            @php $yPos = (($i / 3) * 140) + 15; @endphp
                            <div class="absolute left-2 right-2 border-t border-gray-200" style="top: {{ 155 - $yPos }}px;"></div>
                            <div class="absolute left-0 text-xs text-gray-500 font-medium" style="top: {{ 150 - $yPos }}px;">
                                {{ intval(($i / 3) * $maxOrders) }}
                            </div>
                        @endfor
                    </div>
                </div>
                
                {{-- Chart Summary --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <p class="text-gray-600 text-xs font-medium">Peak Hour</p>
                        <p class="text-gray-800 font-black text-sm">
                            @if($peakHour !== null)
                                {{ $peakHour == 12 ? '12PM' : ($peakHour < 12 ? $peakHour.'AM' : ($peakHour-12).'PM') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <p class="text-gray-600 text-xs font-medium">Peak Orders</p>
                        <p class="text-primary font-black text-sm">{{ $maxOrders }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <p class="text-gray-600 text-xs font-medium">Business Hours</p>
                        <p class="text-gray-800 font-black text-sm">{{ $totalBusinessOrders }}</p>
                    </div>
                </div>
            @else
                {{-- No Data State --}}
                <div class="text-center py-8">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 font-semibold">No orders today</p>
                    <p class="text-gray-500 text-sm mt-1">Orders will appear here when they come in</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Inline Styles and Scripts --}}
    <style>
        @keyframes slideUp {
            from {
                height: 0;
                opacity: 0;
            }
            to {
                height: var(--final-height);
                opacity: 1;
            }
        }

        .animate-slide-up {
            animation: slideUp 1s ease-out forwards;
        }
    </style>

    <script>
        // Add entrance animation to columns
        document.addEventListener('DOMContentLoaded', function() {
            const columns = document.querySelectorAll('[data-hour]');
            columns.forEach((column, index) => {
                const finalHeight = column.style.height;
                column.style.setProperty('--final-height', finalHeight);
                column.style.height = '0px';
                column.style.opacity = '0';
                
                setTimeout(() => {
                    column.classList.add('animate-slide-up');
                }, index * 100);
            });
        });

        // Enhanced hover effects
        document.querySelectorAll('[data-hour]').forEach(column => {
            column.addEventListener('mouseenter', function() {
                const hour = this.dataset.hour;
                const orders = this.dataset.orders;
                const time = hour == 12 ? '12PM' : hour < 12 ? `${hour}AM` : `${hour-12}PM`;
                
                console.log(`${time}: ${orders} orders`);
            });
        });
    </script>
</div>