<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pizza;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Today's statistics
        $todaySales = Order::whereDate('created_at', $today)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $todayOrders = Order::whereDate('created_at', $today)->count();

        $pendingOrders = Order::whereIn('status', ['pending', 'confirmed', 'preparing'])->count();

        $totalProducts = Pizza::count();

        // Recent orders
        $recentOrders = Order::with('items')
            ->latest()
            ->take(5)
            ->get();

        // Top selling products (last 30 days)
        $topProducts = OrderItem::select('pizza_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->whereHas('order', function ($query) {
                $query->where('status', '!=', 'cancelled')
                    ->where('created_at', '>=', Carbon::now()->subDays(30));
            })
            ->with('pizza')
            ->groupBy('pizza_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Daily sales for last 7 days
        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total'),
            DB::raw('COUNT(*) as orders')
        )
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'todaySales',
            'todayOrders',
            'pendingOrders',
            'totalProducts',
            'recentOrders',
            'topProducts',
            'dailySales'
        ));
    }
}
