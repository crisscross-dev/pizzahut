<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->whereIn('status', ['completed', 'delivered']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.pizza']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,out_for_delivery,completed,delivered,cancelled',
        ]);

        // Backwards compatibility: treat delivered as completed going forward
        $newStatus = $validated['status'] === 'delivered' ? 'completed' : $validated['status'];

        $order->update(['status' => $newStatus]);

        // Set estimated delivery when status changes to out_for_delivery
        if ($newStatus === 'out_for_delivery' && !$order->estimated_delivery) {
            $order->update(['estimated_delivery' => now()->addMinutes(30)]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $order->status,
                'status_label' => $order->status_label,
                'status_color' => $order->status_color,
            ]);
        }

        return back()->with('success', 'Order status updated successfully!');
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Main stats
        $ordersQuery = Order::where('status', '!=', 'cancelled')
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);

        $totalSales = (clone $ordersQuery)->sum('total');
        $totalOrders = (clone $ordersQuery)->count();
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        $totalItemsSold = OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
            $query->where('status', '!=', 'cancelled')
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        })->sum('quantity');

        // Daily sales
        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total'),
            DB::raw('COUNT(*) as orders')
        )
            ->where('status', '!=', 'cancelled')
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc('date')
            ->get();

        // Top products
        $topProducts = OrderItem::select(
            'pizza_id',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(total_price) as total_revenue')
        )
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', '!=', 'cancelled')
                    ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            })
            ->with('pizza')
            ->groupBy('pizza_id')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

        // Status breakdown
        $statusBreakdown = Order::select('status', DB::raw('COUNT(*) as count'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->groupBy('status')
            ->get();

        return view('admin.reports.sales', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalOrders',
            'averageOrderValue',
            'totalItemsSold',
            'dailySales',
            'topProducts',
            'statusBreakdown'
        ));
    }
}
