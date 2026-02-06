@extends('layouts.shop')

@section('title', 'Track Order #' . $order->order_number . ' - Pizzeria')

@section('content')
<style>
    .track-page {
        padding: 40px 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .back-link:hover {
        color: var(--text-light);
    }

    .order-card {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 30px;
        margin-bottom: 24px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .order-number {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        margin-bottom: 4px;
    }

    .order-date {
        color: var(--text-muted);
        font-size: 14px;
    }

    .order-status {
        padding: 8px 18px;
        border-radius: 25px;
        font-size: 14px;
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

    .order-status.cancelled {
        background: rgba(220, 53, 69, 0.15);
        color: #DC3545;
    }

    /* Progress Timeline */
    .progress-timeline {
        position: relative;
        display: flex;
        justify-content: space-between;
        margin: 40px 0;
    }

    .progress-line {
        position: absolute;
        top: 20px;
        left: 30px;
        right: 30px;
        height: 4px;
        background: var(--dark-surface);
        z-index: 1;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-warm);
        transition: width 0.5s ease;
    }

    .progress-fill.progress-0 {
        width: 0%;
    }

    .progress-fill.progress-25 {
        width: 25%;
    }

    .progress-fill.progress-50 {
        width: 50%;
    }

    .progress-fill.progress-75 {
        width: 75%;
    }

    .progress-fill.progress-100 {
        width: 100%;
    }

    .progress-step {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .step-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--dark-surface);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: var(--text-muted);
        transition: all 0.3s ease;
    }

    .step-icon.active {
        background: var(--gradient-warm);
        color: white;
        box-shadow: 0 0 20px rgba(230, 57, 70, 0.4);
    }

    .step-icon.completed {
        background: var(--success-green);
        color: white;
    }

    .step-label {
        font-size: 12px;
        color: var(--text-muted);
        text-align: center;
        max-width: 80px;
    }

    .step-label.active {
        color: var(--text-light);
        font-weight: 500;
    }

    /* Order Details */
    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary-orange);
    }

    .order-items {
        margin-bottom: 30px;
    }

    .order-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item-image {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
    }

    .order-item-info {
        flex: 1;
    }

    .order-item-name {
        font-weight: 500;
        margin-bottom: 4px;
    }

    .order-item-details {
        font-size: 13px;
        color: var(--text-muted);
    }

    .order-item-price {
        font-weight: 600;
        color: var(--primary-orange);
    }

    /* Summary */
    .order-summary {
        background: var(--dark-surface);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
    }

    .summary-row.total {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 10px;
        padding-top: 16px;
        font-size: 18px;
        font-weight: 600;
    }

    .summary-row.total span:last-child {
        color: var(--primary-orange);
    }

    /* Delivery Info */
    .delivery-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .info-item label {
        display: block;
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    .info-item p {
        font-weight: 500;
    }

    /* Status Message */
    .status-message {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 24px;
        text-align: center;
    }

    .status-message i {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .status-message h3 {
        margin-bottom: 8px;
    }

    .status-message p {
        color: var(--text-muted);
    }

    .status-message.preparing i {
        color: #9C27B0;
    }

    .status-message.out_for_delivery i {
        color: #00BCD4;
    }

    .status-message.delivered i {
        color: #4CAF50;
    }

    @media (max-width: 600px) {
        .progress-step .step-label {
            font-size: 10px;
            max-width: 60px;
        }

        .step-icon {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }

        .progress-line {
            left: 20px;
            right: 20px;
        }
    }
</style>

<div class="track-page">
    @auth
    <a href="{{ route('orders.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to My Orders
    </a>
    @else
    <a href="{{ route('shop.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Menu
    </a>
    @endauth

    <div class="order-card">
        <div class="order-header">
            <div>
                <div class="order-number">#{{ $order->order_number }}</div>
                <div class="order-date">Ordered on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</div>
            </div>
            <span class="order-status {{ $order->status }}">{{ $order->status_label }}</span>
        </div>

        @if($order->status !== 'cancelled')
        <!-- Progress Timeline -->
        @php
        $statuses = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'];
        $currentIndex = array_search($order->status, $statuses);
        if ($currentIndex === false) $currentIndex = -1;
        $progressWidth = $currentIndex >= 0 ? (int) round(($currentIndex / (count($statuses) - 1)) * 100) : 0;
        $progressClass = 'progress-' . $progressWidth;
        @endphp

        <div class="progress-timeline">
            <div class="progress-line">
                <div class="progress-fill {{ $progressClass }}"></div>
            </div>

            @foreach([
            ['icon' => 'clock', 'label' => 'Order Placed'],
            ['icon' => 'check', 'label' => 'Confirmed'],
            ['icon' => 'fire', 'label' => 'Preparing'],
            ['icon' => 'motorcycle', 'label' => 'On the Way'],
            ['icon' => 'check-circle', 'label' => 'Delivered']
            ] as $index => $step)
            <div class="progress-step">
                <div class="step-icon {{ $index < $currentIndex ? 'completed' : ($index == $currentIndex ? 'active' : '') }}">
                    <i class="fas fa-{{ $index <= $currentIndex ? ($index == $currentIndex ? $step['icon'] : 'check') : $step['icon'] }}"></i>
                </div>
                <span class="step-label {{ $index <= $currentIndex ? 'active' : '' }}">{{ $step['label'] }}</span>
            </div>
            @endforeach
        </div>

        <!-- Status Message -->
        <div class="status-message {{ $order->status }}">
            @switch($order->status)
            @case('pending')
            <i class="fas fa-hourglass-half" style="color: #FFC107;"></i>
            <h3>Order Received!</h3>
            <p>We've received your order and are reviewing it. You'll be notified once it's confirmed.</p>
            @break
            @case('confirmed')
            <i class="fas fa-thumbs-up" style="color: #17A2B8;"></i>
            <h3>Order Confirmed!</h3>
            <p>Your order has been confirmed and will be prepared shortly.</p>
            @break
            @case('preparing')
            <i class="fas fa-fire-flame-curved"></i>
            <h3>Your Pizza is Being Made!</h3>
            <p>Our chefs are crafting your delicious pizza with love and care.</p>
            @break
            @case('out_for_delivery')
            <i class="fas fa-motorcycle"></i>
            <h3>On the Way!</h3>
            <p>Your pizza is out for delivery. It will arrive soon!</p>
            @break
            @case('delivered')
            <i class="fas fa-circle-check"></i>
            <h3>Delivered!</h3>
            <p>Your order has been delivered. Enjoy your pizza!</p>
            @break
            @endswitch
        </div>
        @else
        <div class="status-message" style="background: rgba(220, 53, 69, 0.1);">
            <i class="fas fa-times-circle" style="color: #DC3545;"></i>
            <h3>Order Cancelled</h3>
            <p>This order has been cancelled. If you have questions, please contact us.</p>
        </div>
        @endif
    </div>

    <!-- Order Items -->
    <div class="order-card">
        <h2 class="section-title"><i class="fas fa-pizza-slice"></i> Order Items</h2>
        <div class="order-items">
            @foreach($order->items as $item)
            <div class="order-item">
                <img src="{{ $item->pizza->image_url ?? 'https://via.placeholder.com/70' }}" alt="{{ $item->pizza_name }}" class="order-item-image">
                <div class="order-item-info">
                    <div class="order-item-name">{{ $item->pizza_name }}</div>
                    <div class="order-item-details">{{ ucfirst($item->size) }} × {{ $item->quantity }}</div>
                </div>
                <div class="order-item-price">₱{{ number_format($item->subtotal, 2) }}</div>
            </div>
            @endforeach
        </div>

        <div class="order-summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>₱{{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Tax (12%)</span>
                <span>₱{{ number_format($order->tax_amount, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Delivery Fee</span>
                <span>₱{{ number_format($order->delivery_fee, 2) }}</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>₱{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Delivery Information -->
    <div class="order-card">
        <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Delivery Information</h2>
        <div class="delivery-info">
            <div class="info-item">
                <label>Recipient</label>
                <p>{{ $order->customer_name }}</p>
            </div>
            <div class="info-item">
                <label>Phone</label>
                <p>{{ $order->customer_phone }}</p>
            </div>
            <div class="info-item">
                <label>Delivery Address</label>
                <p>{{ $order->delivery_address }}</p>
            </div>
            <div class="info-item">
                <label>City</label>
                <p>{{ $order->delivery_city }}</p>
            </div>
        </div>
        @if($order->notes)
        <div class="info-item" style="margin-top: 20px;">
            <label>Special Instructions</label>
            <p>{{ $order->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection