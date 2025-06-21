<div class="space-y-8 font-inter">
    {{-- Loading Overlay --}}
    <div wire:loading class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-slate-800 rounded-3xl p-8 shadow-soft-xl border border-slate-700/50">
            <div class="flex items-center space-x-4">
                <svg class="w-8 h-8 text-primary animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <div>
                    <p class="text-white font-bold text-lg">Refreshing Dashboard</p>
                    <p class="text-slate-400 text-sm">Updating real-time data...</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Header --}}
    <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl p-8 shadow-soft-xl border border-slate-700/50">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <div class="bg-gradient-to-br from-primary to-primary-dark p-4 rounded-2xl shadow-soft-lg shadow-primary/25">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="space-y-2">
                    <h1 class="text-3xl font-black text-white tracking-tight">Dashboard</h1>
                    <p class="text-slate-300 text-base font-medium">Welcome back! Here's what's happening today.</p>
                </div>
            </div>
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
    </div>

    {{-- Enhanced Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-6">
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-primary/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Today's Sales</h2>
            <p class="text-3xl font-black text-primary tracking-tight">${{ number_format($todaySales, 2) }}</p>
        </div>

        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Total Orders</h2>
            <p class="text-3xl font-black text-blue-400 tracking-tight">{{ $todayOrders }}</p>
        </div>

        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-yellow-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Pending</h2>
            <p class="text-3xl font-black text-yellow-400 tracking-tight">{{ $pending }}</p>
        </div>

        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Processing</h2>
            <p class="text-3xl font-black text-blue-400 tracking-tight">{{ $processing }}</p>
        </div>

        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-emerald-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Completed</h2>
            <p class="text-3xl font-black text-emerald-400 tracking-tight">{{ $completed }}</p>
        </div>

        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-6 hover:scale-105 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-rose-500/20 p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-sm font-bold text-slate-400 mb-2 uppercase tracking-wide">Cancelled</h2>
            <p class="text-3xl font-black text-rose-400 tracking-tight">{{ $cancelled }}</p>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Top Products Pie Chart --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-8">
            <div class="flex items-center space-x-3 mb-8">
                <div class="bg-primary/20 p-3 rounded-2xl">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-white tracking-tight">Top 3 Products Today</h2>
            </div>
            
            @if($topProducts->isNotEmpty())
                @php
                    $totalQuantity = $topProducts->sum('total_quantity');
                    $colors = ['#FF6B35', '#3B82F6', '#10B981']; // Orange, Blue, Green
                @endphp
                
                <div class="flex items-center justify-center">
                    {{-- Pie Chart SVG --}}
                    <div class="relative">
                        <svg width="280" height="280" viewBox="0 0 280 280" class="transform -rotate-90">
                            @php
                                $currentAngle = 0;
                                $centerX = 140;
                                $centerY = 140;
                                $radius = 100;
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
                                      stroke="#1e293b" 
                                      stroke-width="3"
                                      class="hover:opacity-80 transition-all duration-300 cursor-pointer">
                                </path>
                                
                                @php $currentAngle = $endAngle; @endphp
                            @endforeach
                            
                            {{-- Center circle for donut effect --}}
                            <circle cx="140" cy="140" r="45" fill="#0f172a" stroke="#334155" stroke-width="2"/>
                        </svg>
                        
                        {{-- Center text --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-white font-black text-2xl">{{ $totalQuantity }}</p>
                                <p class="text-slate-400 text-sm font-medium">Total Units</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Legend --}}
                <div class="mt-8 space-y-4">
                    @foreach($topProducts as $index => $item)
                        @php
                            $percentage = $totalQuantity > 0 ? ($item->total_quantity / $totalQuantity) * 100 : 0;
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-2xl hover:bg-slate-700/50 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $colors[$index] }}"></div>
                                <div>
                                    <p class="text-white font-bold">{{ $item->product_name }}</p>
                                    <p class="text-slate-400 text-sm">{{ $item->total_quantity }} units</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-black text-lg">{{ number_format($percentage, 1) }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-700/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 font-semibold">No sales data available today</p>
                </div>
            @endif
        </div>

        {{-- Today's Orders Timeline Column Chart --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-3xl shadow-soft-xl border border-slate-700/50 p-8">
            <div class="flex items-center space-x-3 mb-8">
                <div class="bg-primary/20 p-3 rounded-2xl">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-black text-white tracking-tight">Today's Order Timeline</h2>
                    <p class="text-slate-400 text-sm font-medium">Orders per hour during business hours (8AM - 10PM)</p>
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
                <div class="relative h-64 mb-6">
                    <div class="flex items-end justify-between h-full px-4 pb-8 space-x-2">
                        @foreach($businessHours as $hour => $orders)
                            @php
                                $height = $maxOrders > 0 ? ($orders / $maxOrders) * 180 : 0; // Scale to max height of 180px
                                $isPeak = $orders === $maxOrders && $orders > 0;
                            @endphp
                            <div class="flex flex-col items-center space-y-2 flex-1">
                                {{-- Column --}}
                                <div class="relative group cursor-pointer w-full max-w-8">
                                    <div class="bg-gradient-to-t {{ $isPeak ? 'from-primary to-primary-dark shadow-glow' : 'from-primary/70 to-primary/90' }} rounded-t-lg transition-all duration-500 hover:from-primary hover:to-primary-dark hover:shadow-glow transform hover:scale-105" 
                                         style="height: {{ $height }}px;"
                                         data-hour="{{ $hour }}"
                                         data-orders="{{ $orders }}">
                                    </div>
                                    
                                    {{-- Value on hover --}}
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        {{ $orders }} orders
                                    </div>
                                </div>
                                
                                {{-- Hour label --}}
                                <div class="text-xs text-slate-400 font-medium">
                                    {{ $hour == 12 ? '12PM' : ($hour < 12 ? $hour.'AM' : ($hour-12).'PM') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Y-axis reference lines --}}
                    <div class="absolute left-0 top-0 h-full w-full pointer-events-none">
                        @for($i = 1; $i <= 4; $i++)
                            @php $yPos = (($i / 4) * 180) + 20; @endphp
                            <div class="absolute left-4 right-4 border-t border-slate-600/30" style="top: {{ 200 - $yPos }}px;"></div>
                            <div class="absolute left-0 text-xs text-slate-500 font-medium" style="top: {{ 195 - $yPos }}px;">
                                {{ intval(($i / 4) * $maxOrders) }}
                            </div>
                        @endfor
                    </div>
                </div>
                
                {{-- Chart Summary --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-slate-700/30 rounded-2xl">
                        <p class="text-slate-400 text-sm font-medium">Peak Hour</p>
                        <p class="text-white font-black text-lg">
                            @if($peakHour !== null)
                                {{ $peakHour == 12 ? '12PM' : ($peakHour < 12 ? $peakHour.'AM' : ($peakHour-12).'PM') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div class="text-center p-4 bg-slate-700/30 rounded-2xl">
                        <p class="text-slate-400 text-sm font-medium">Peak Orders</p>
                        <p class="text-primary font-black text-lg">{{ $maxOrders }}</p>
                    </div>
                    <div class="text-center p-4 bg-slate-700/30 rounded-2xl">
                        <p class="text-slate-400 text-sm font-medium">Business Hours</p>
                        <p class="text-white font-black text-lg">{{ $totalBusinessOrders }}</p>
                    </div>
                </div>
            @else
                {{-- No Data State --}}
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-700/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 font-semibold">No orders today</p>
                    <p class="text-slate-500 text-sm mt-1">Orders will appear here when they come in</p>
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