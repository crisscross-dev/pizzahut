@extends('layouts.admin')

@section('title', 'Sales Report')
@section('subtitle', '')

@section('hideHeaderTitle', true)
@section('hideUserMenu', true)

@section('content')
<!-- Date Filter -->
<div class="card" style="margin-bottom: 25px;">
    <form method="GET" action="{{ route('admin.reports.sales') }}" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
        <div class="form-group" style="margin: 0;">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" style="width: 180px;">
        </div>
        <div class="form-group" style="margin: 0;">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" style="width: 180px;">
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-filter"></i>
            Apply Filter
        </button>
        <a href="{{ route('admin.reports.sales') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<!-- Summary Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-peso-sign"></i>
        </div>
        <div class="stat-info">
            <h3>₱{{ number_format($totalSales, 0) }}</h3>
            <p>Total Sales</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalOrders }}</h3>
            <p>Total Orders</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-receipt"></i>
        </div>
        <div class="stat-info">
            <h3>₱{{ number_format($averageOrderValue, 0) }}</h3>
            <p>Average Order Value</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-pizza-slice"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalItemsSold }}</h3>
            <p>Items Sold</p>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Daily Sales Table -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Daily Sales</h2>
        </div>
        <div class="table-container" style="max-height: 400px; overflow-y: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Orders</th>
                        <th>Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailySales as $day)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                        <td>{{ $day->orders }}</td>
                        <td style="font-weight: 600;">₱{{ number_format($day->total, 0) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-muted);">No sales data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Top Selling Products</h2>
        </div>
        <div class="table-container" style="max-height: 400px; overflow-y: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty Sold</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $product)
                    <tr>
                        <td style="display: flex; align-items: center; gap: 10px;">
                            <img src="{{ $product->pizza->image_url ?? 'https://via.placeholder.com/40' }}"
                                alt="{{ $product->pizza->name ?? 'Pizza' }}"
                                style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                            <span>{{ $product->pizza->name ?? $product->pizza_name }}</span>
                        </td>
                        <td>{{ $product->total_quantity }}</td>
                        <td style="font-weight: 600;">₱{{ number_format($product->total_revenue, 0) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-muted);">No sales data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Status Breakdown -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Order Status Breakdown</h2>
    </div>
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        @foreach($statusBreakdown as $status)
        <div style="flex: 1; min-width: 150px; background: var(--dark-light); border-radius: 12px; padding: 20px; text-align: center;">
            <div style="font-size: 28px; font-weight: 700; margin-bottom: 5px;">{{ $status->count }}</div>
            <span class="status-badge {{ $status->status }}">{{ ucfirst(str_replace('_', ' ', $status->status)) }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection