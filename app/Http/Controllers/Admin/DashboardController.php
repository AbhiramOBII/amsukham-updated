<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'today_revenue' => Order::where('payment_status', 'paid')->whereDate('created_at', $today)->sum('total'),
            'today_orders' => Order::whereDate('created_at', $today)->count(),
            'month_revenue' => Order::where('payment_status', 'paid')->where('created_at', '>=', $thisMonth)->sum('total'),
            'month_orders' => Order::where('created_at', '>=', $thisMonth)->count(),
            'last_month_revenue' => Order::where('payment_status', 'paid')->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->sum('total'),
            'avg_order_value' => Order::where('payment_status', 'paid')->count() > 0
                ? Order::where('payment_status', 'paid')->avg('total')
                : 0,
            'total_units_sold' => Order::where('payment_status', 'paid')
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->with('items')
                ->get()
                ->pluck('items')
                ->flatten()
                ->sum('quantity'),
        ];

        $recentOrders = Order::with('items')
            ->latest()
            ->take(10)
            ->get();

        $lowStockProducts = Product::with(['category', 'productColors'])
            ->where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->active()
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
