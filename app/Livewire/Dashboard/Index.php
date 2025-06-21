<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $todaySales = 0;
    public $todayOrders = 0;
    public $pending = 0;
    public $processing = 0;
    public $completed = 0;
    public $cancelled = 0;
    public $topProducts = [];
    public $hourlyOrders = [];
    public $isLoading = false;

    public function mount()
    {
        $this->loadDashboard();
    }

    public function loadDashboard()
    {
        // Use Hong Kong timezone for date calculations
        $todayStart = Carbon::today('Asia/Hong_Kong')->startOfDay();
        $todayEnd = Carbon::today('Asia/Hong_Kong')->endOfDay();

        // Get today's orders
        $todayOrders = Order::whereBetween('created_at', [$todayStart, $todayEnd]);
        
        // Calculate total sales from order items for accuracy, excluding cancelled orders
        $this->todaySales = OrderItem::whereHas('order', function ($q) use ($todayStart, $todayEnd) {
            $q->whereBetween('created_at', [$todayStart, $todayEnd])
              ->where('status', '!=', 'cancelled');
        })->sum('subtotal');

        $this->todayOrders = $todayOrders->count();
        
        // Get today's status counts
        $this->pending = (clone $todayOrders)->where('status', 'pending')->count();
        $this->processing = (clone $todayOrders)->where('status', 'processing')->count();
        $this->completed = (clone $todayOrders)->where('status', 'completed')->count();
        $this->cancelled = (clone $todayOrders)->where('status', 'cancelled')->count();

        // Get hourly orders data for business hours (8AM to 10PM)
        $hourlyData = Order::whereBetween('created_at', [$todayStart, $todayEnd])
            ->select(DB::raw('strftime("%H", created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour')
            ->toArray();

        // Initialize business hours (8AM to 10PM) with 0 orders
        $this->hourlyOrders = [];
        for ($hour = 8; $hour <= 22; $hour++) {
            $hourKey = str_pad($hour, 2, '0', STR_PAD_LEFT); // Format as '08', '09', etc.
            $this->hourlyOrders[$hour] = $hourlyData[$hourKey] ?? 0;
        }

        // Optimize top products query
        $this->topProducts = OrderItem::select(
                'product_id',
                'products.name as product_name',
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereHas('order', function ($q) use ($todayStart, $todayEnd) {
                $q->whereBetween('created_at', [$todayStart, $todayEnd])
                  ->where('status', '!=', 'cancelled');
            })
            ->groupBy('product_id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(3)
            ->get();
    }

    public function refresh()
    {
        $this->isLoading = true;
        $this->loadDashboard();
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.dashboard.index')
            ->layout('components.layouts.app');
    }
}
