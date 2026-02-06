@extends('layouts.shop')

@section('title', 'My Orders - Pizzeria')

@section('content')
<style>
    .orders-page {
        padding: 40px 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    .orders-header {
        margin-bottom: 30px;
    }

    .orders-title {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        margin-bottom: 8px;
    }

    .orders-subtitle {
        color: var(--text-muted);
        font-size: 14px;
    }

    .order-card {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 24px;
        margin-bottom: 20px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-number {
        font-weight: 600;
        font-size: 18px;
    }

    .order-date {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .order-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .order-status.pending {
        background: rgba(255, 193, 7, 0.15);
        color: #FFC107;
    }

    .order-status.confirmed {
        background: rgba(23, 162, 184, 0.15);
        color: #17A2B8;
    }

    .order-status.preparing {
        background: rgba(156, 39, 176, 0.15);
        color: #9C27B0;
    }

    .order-status.out_for_delivery {
        background: rgba(0, 188, 212, 0.15);
        color: #00BCD4;
    }

    .order-status.delivered {
        background: rgba(76, 175, 80, 0.15);
        color: #4CAF50;
    }

    .order-status.completed {
        background: rgba(76, 175, 80, 0.15);
        color: #4CAF50;
    }

    .order-status.cancelled {
        background: rgba(220, 53, 69, 0.15);
        color: #DC3545;
    }

    .order-items {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .order-item-thumb {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .order-total {
        font-size: 20px;
        font-weight: 600;
        color: var(--primary-orange);
    }

    .order-actions {
        display: flex;
        gap: 10px;
    }

    .order-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: var(--transition-smooth);
    }

    .order-btn-primary {
        background: var(--gradient-warm);
        color: white;
    }

    .order-btn-secondary {
        background: var(--dark-surface);
        color: var(--text-light);
    }

    .empty-orders {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-orders i {
        font-size: 64px;
        color: var(--text-muted);
        opacity: 0.3;
        margin-bottom: 20px;
    }

    .empty-orders h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .empty-orders p {
        color: var(--text-muted);
        margin-bottom: 25px;
    }

    .empty-orders a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--gradient-warm);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 500;
    }

    /* Track Order Search */
    .track-search {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 24px;
        margin-bottom: 30px;
    }

    .track-search h3 {
        margin-bottom: 15px;
        font-size: 16px;
    }

    .track-form {
        display: flex;
        gap: 12px;
        align-items: stretch;
    }

    .track-input {
        flex: 1;
        padding: 12px 16px;
        background: var(--dark-surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        color: var(--text-light);
        font-size: 14px;
    }

    .track-input:focus {
        outline: none;
        border-color: var(--primary-orange);
    }

    .track-btn {
        padding: 12px 24px;
        background: var(--gradient-warm);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 500;
        cursor: pointer;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .orders-page {
            padding: 24px 14px;
        }

        .orders-title {
            font-size: 26px;
        }

        .track-search {
            padding: 18px;
        }

        .track-form {
            flex-direction: column;
        }

        .track-input,
        .track-btn {
            width: 100%;
        }

        .order-card {
            padding: 18px;
        }

        .order-footer {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .order-actions,
        .order-actions .order-btn {
            width: 100%;
        }

        .order-actions .order-btn {
            justify-content: center;
            display: inline-flex;
            align-items: center;
        }
    }
</style>

<div class="orders-page">
    <div class="orders-header">
        <h1 class="orders-title">My Orders</h1>
        <p class="orders-subtitle">View and track your pizza orders</p>
    </div>

    <!-- Track Order by Number -->
    <div class="track-search">
        <h3><i class="fas fa-search"></i> Track an Order</h3>
        <form action="{{ route('orders.track-public') }}" method="GET" class="track-form">
            <input type="text" name="order_number" placeholder="Enter order number (e.g., PH123456)" class="track-input" required>
            <button type="submit" class="track-btn">Track</button>
        </form>
    </div>

    @if($orders->count() > 0)
    @foreach($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <div>
                <div class="order-number">#{{ $order->order_number }}</div>
                <div class="order-date">{{ $order->created_at->format('F d, Y h:i A') }}</div>
            </div>
            <span class="order-status {{ $order->status }}">{{ $order->status_label }}</span>
        </div>

        <div class="order-items">
            @foreach($order->items->take(4) as $item)
            <img src="{{ $item->pizza->image_url ?? 'https://via.placeholder.com/60' }}" alt="{{ $item->pizza_name }}" class="order-item-thumb" title="{{ $item->pizza_name }}">
            @endforeach
            @if($order->items->count() > 4)
            <div style="width: 60px; height: 60px; background: var(--dark-surface); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 14px;">
                +{{ $order->items->count() - 4 }}
            </div>
            @endif
        </div>

        <div class="order-footer">
            <div class="order-total">₱{{ number_format($order->total_amount, 2) }}</div>
            <div class="order-actions">
                <a href="{{ route('orders.track', $order) }}" class="order-btn order-btn-primary">
                    <i class="fas fa-map-marker-alt"></i> Track Order
                </a>
            </div>
        </div>
    </div>
    @endforeach

    {{ $orders->links() }}
    @else
    <div class="empty-orders">
        <i class="fas fa-receipt"></i>
        <h3>No orders yet</h3>
        <p>Start ordering delicious pizzas and they'll appear here!</p>
        <a href="{{ route('shop.index') }}">
            <i class="fas fa-pizza-slice"></i>
            Browse Menu
        </a>
    </div>
    @endif
</div>
@endsection