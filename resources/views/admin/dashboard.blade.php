@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', '')

@section('hideHeaderTitle', true)
@section('hideUserMenu', true)
@section('hideHeaderDesktop', true)

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card stat-emphasis">
        <div class="stat-icon green">
            <i class="fas fa-peso-sign"></i>
        </div>
        <div class="stat-info">
            <h3>₱{{ number_format($todaySales, 0) }}</h3>
            <p>Today's Sales</p>
        </div>
    </div>

    <div class="stat-card stat-emphasis">
        <div class="stat-icon blue">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $todayOrders }}</h3>
            <p>Today's Orders</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $pendingOrders }}</h3>
            <p>Pending Orders</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-pizza-slice"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalProducts }}</h3>
            <p>Total Products</p>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>

        <div class="table-container dashboard-desktop-only">
            <table>
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" style="color: var(--primary); text-decoration: none;">
                                #{{ $order->order_number }}
                            </a>
                        </td>
                        <td>{{ $order->customer_name }}</td>
                        <td>₱{{ number_format($order->total, 0) }}</td>
                        <td>
                            <span class="status-badge {{ $order->status }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted);">
                            No orders yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="dashboard-mobile-only">
            @forelse($recentOrders as $order)
            <a href="{{ route('admin.orders.show', $order) }}" class="dashboard-order-card">
                <div class="dashboard-order-top">
                    <div class="dashboard-order-number">#{{ $order->order_number }}</div>
                    <span class="status-badge {{ $order->status }}">{{ $order->status_label }}</span>
                </div>
                <div class="dashboard-order-meta">
                    <div class="dashboard-order-customer">{{ $order->customer_name }}</div>
                    <div class="dashboard-order-total">₱{{ number_format($order->total, 0) }}</div>
                </div>
                <div class="dashboard-order-time">{{ $order->created_at->format('M d, Y • h:i A') }}</div>
            </a>
            @empty
            <div style="text-align: center; color: var(--text-muted); padding: 18px;">
                No orders yet
            </div>
            @endforelse
        </div>
    </div>

    <!-- Top Selling Pizzas -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Top Selling Pizzas</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>

        @php
        $maxSold = (int) ($topProducts->max('total_sold') ?? 0);
        if ($maxSold < 1) $maxSold=1;
            @endphp

            <div class="dashboard-top-list">
            @forelse($topProducts as $item)
            @php
            $sold = (int) $item->total_sold;
            $pct = (int) round(($sold / $maxSold) * 100);
            @endphp
            <div class="dashboard-top-item">
                <div class="dashboard-top-row">
                    <div class="dashboard-top-left">
                        <img src="{{ $item->pizza->image_url }}" alt="{{ $item->pizza->name }}" class="product-image">
                        <div>
                            <div class="dashboard-top-name">{{ $item->pizza->name }}</div>
                            <div class="dashboard-top-sub">₱{{ number_format($item->total_revenue, 0) }} revenue</div>
                        </div>
                    </div>
                    <div class="dashboard-top-badge">{{ $sold }} sold</div>
                </div>
                <div class="dashboard-top-bar">
                    <div class="dashboard-top-bar-fill" style="--pct: {{ $pct }};"></div>
                </div>
            </div>
            @empty
            <div style="text-align: center; color: var(--text-muted); padding: 18px;">
                No sales data yet
            </div>
            @endforelse
    </div>
</div>
</div>

<!-- Monthly Sales Chart Placeholder -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Monthly Sales (Last 7 Days)</h2>
    </div>
    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        @foreach($dailySales as $day)
        <div style="flex: 1; min-width: 120px; text-align: center; padding: 20px; background: var(--dark-light); border-radius: 12px;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">
                {{ \Carbon\Carbon::parse($day->date)->format('D, M d') }}
            </div>
            <div style="font-size: 20px; font-weight: 600;">
                ₱{{ number_format($day->total, 0) }}
            </div>
            <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                {{ $day->orders }} orders
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection