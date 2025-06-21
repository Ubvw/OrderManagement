<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    public $tab = 'sales';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::today()->toDateString();
        $this->endDate = Carbon::today()->toDateString();
    }

    public function render()
    {
        return view('livewire.reports.index', [
            'salesSummary' => $this->getSalesSummary(),
            'productSummary' => $this->getProductSummary(),
        ])->layout('components.layouts.app');
    }

    protected function getSalesSummary()
    {
        $baseQuery = Order::whereBetween('created_at', [
            Carbon::parse($this->startDate)->startOfDay(),
            Carbon::parse($this->endDate)->endOfDay()
        ]);

        // Debug: Log the date range being used
        Log::info('Report date range:', [
            'start' => Carbon::parse($this->startDate)->startOfDay(),
            'end' => Carbon::parse($this->endDate)->endOfDay()
        ]);

        // Debug: Log all orders in the date range with their statuses
        $allOrders = $baseQuery->get(['id', 'status', 'created_at', 'total_amount']);
        Log::info('All orders in date range:', [
            'orders' => $allOrders->map(function($order) {
                return [
                    'id' => $order->id,
                    'status' => $order->status,
                    'created_at' => $order->created_at,
                    'total_amount' => $order->total_amount
                ];
            })
        ]);

        // Get total orders (including cancelled)
        $totalOrders = $baseQuery->count();
        Log::info('Total orders in date range:', ['count' => $totalOrders]);

        // Get revenue only from non-cancelled orders using direct SQL
        $totalRevenue = DB::table('orders')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->whereRaw("status != 'cancelled'")
            ->sum('total_amount') ?? 0;
        Log::info('Total revenue (excluding cancelled):', ['amount' => $totalRevenue]);

        // Calculate average order value excluding cancelled orders
        $completedOrders = DB::table('orders')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->whereRaw("status != 'cancelled'")
            ->count();
        $avgOrderValue = $completedOrders > 0 ? $totalRevenue / $completedOrders : 0;
        Log::info('Completed orders count:', ['count' => $completedOrders]);

        // Get peak hours (excluding cancelled orders)
        $peakHours = DB::table('orders')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->whereRaw("status != 'cancelled'")
            ->select(DB::raw('strftime("%H", created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::createFromTime($item->hour)->format('g A') => $item->count];
            });

        // Get best performing days (excluding cancelled orders)
        $bestDays = DB::table('orders')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->whereRaw("status != 'cancelled'")
            ->select(DB::raw('date(created_at) as date'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy('date')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->date)->format('D, M j') => $item->revenue ?? 0];
            });

        // Get completed and cancelled orders count with explicit status checks
        $completedOrders = DB::table('orders')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->whereRaw("status = 'completed'")
            ->count();

        $cancelledOrders = DB::table('orders')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->whereRaw("status = 'cancelled'")
            ->count();
        
        // Debug: Log raw counts for each status using direct SQL
        $statusCounts = DB::table('orders')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->status => $item->count];
            });
        Log::info('Raw status counts:', ['counts' => $statusCounts]);
        
        // Debug: Log the counts for each status
        Log::info('Order status counts:', [
            'completed' => $completedOrders,
            'cancelled' => $cancelledOrders,
            'total' => $totalOrders,
            'pending' => DB::table('orders')
                ->whereBetween('created_at', [
                    Carbon::parse($this->startDate)->startOfDay(),
                    Carbon::parse($this->endDate)->endOfDay()
                ])
                ->whereRaw("status = 'pending'")
                ->count(),
            'processing' => DB::table('orders')
                ->whereBetween('created_at', [
                    Carbon::parse($this->startDate)->startOfDay(),
                    Carbon::parse($this->endDate)->endOfDay()
                ])
                ->whereRaw("status = 'processing'")
                ->count()
        ]);
        
        // Calculate cancellation rate
        $cancellationRate = $totalOrders > 0 ? ($cancelledOrders / $totalOrders) * 100 : 0;
        Log::info('Cancellation rate:', ['rate' => $cancellationRate]);

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'avg_order_value' => $avgOrderValue,
            'completed' => $completedOrders,
            'cancelled' => $cancelledOrders,
            'cancellation_rate' => $cancellationRate,
            'peak_hours' => $peakHours,
            'best_days' => $bestDays,
        ];
    }

    protected function getProductSummary()
    {
        $summary = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_id) as order_count')
            )
            ->whereHas('order', function ($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse($this->startDate)->startOfDay(),
                    Carbon::parse($this->endDate)->endOfDay()
                ])
                ->where('status', '!=', 'cancelled');
            })
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_revenue')
            ->get();

        return $summary->map(function ($item) {
            $item->total_quantity = $item->total_quantity ?? 0;
            $item->total_revenue = $item->total_revenue ?? 0;
            $item->order_count = $item->order_count ?? 0;
            $item->avg_price = $item->total_quantity > 0 ? 
                $item->total_revenue / $item->total_quantity : 0;
            return $item;
        });
    }
}
