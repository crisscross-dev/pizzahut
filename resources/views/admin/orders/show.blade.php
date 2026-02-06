@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)
@section('subtitle', 'View order details and update status')

@section('hideHeaderTitle', true)
@section('hideUserMenu', true)

@section('content')
<style>
    .payment-status.paid {
        color: var(--success);
    }

    .payment-status.pending {
        color: var(--warning);
    }

    .order-item-row {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 0;
    }

    .order-item-row.bordered {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .timeline-entry {
        position: relative;
        padding-bottom: 20px;
    }

    .timeline-entry.with-line {
        border-left: 2px solid rgba(255, 255, 255, 0.1);
    }

    .timeline-entry.with-line.completed {
        border-left-color: var(--success);
    }

    .timeline-dot {
        position: absolute;
        left: -31px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        background: var(--dark-light);
        color: var(--text-muted);
    }

    .timeline-dot.completed {
        background: var(--success);
        color: white;
    }

    .timeline-label {
        font-weight: 400;
        color: var(--text-muted);
    }

    .timeline-label.completed {
        color: var(--text);
    }

    .timeline-label.current {
        font-weight: 600;
    }
</style>

<div class="grid-2">
    <!-- Order Details -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Order Details</h2>
            <span class="status-badge {{ $order->status }}">{{ $order->status_label }}</span>
        </div>

        <div style="margin-bottom: 25px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Order Number</p>
                    <p style="font-weight: 600;">#{{ $order->order_number }}</p>
                </div>
                <div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Order Date</p>
                    <p style="font-weight: 600;">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Payment Method</p>
                    <p style="font-weight: 600;">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Payment Status</p>
                    <p class="payment-status {{ $order->is_paid ? 'paid' : 'pending' }}" style="font-weight: 600;">
                        {{ $order->is_paid ? 'Paid' : 'Pending' }}
                    </p>
                </div>
            </div>
        </div>

        <h3 style="font-size: 14px; color: var(--text-muted); margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.5px;">Order Items</h3>

        <div style="background: var(--dark-light); border-radius: 12px; padding: 15px;">
            @foreach($order->items as $item)
            <div class="order-item-row {{ !$loop->last ? 'bordered' : '' }}">
                <img src="{{ $item->pizza->image_url ?? 'https://via.placeholder.com/60' }}" alt="{{ $item->pizza_name }}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                <div style="flex: 1;">
                    <div style="font-weight: 500;">{{ $item->pizza_name }}</div>
                    <div style="font-size: 13px; color: var(--text-muted);">
                        {{ $item->size }} × {{ $item->quantity }}
                    </div>
                </div>
                <div style="font-weight: 700;">₱{{ number_format($item->subtotal, 0) }}</div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.05);">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: var(--text-muted);">Subtotal</span>
                <span>₱{{ number_format($order->subtotal, 0) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: var(--text-muted);">Tax (12%)</span>
                <span>₱{{ number_format($order->tax_amount, 0) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: var(--text-muted);">Delivery Fee</span>
                <span>₱{{ number_format($order->delivery_fee, 0) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 18px; font-weight: 600;">
                <span>Total</span>
                <span style="color: var(--primary);">₱{{ number_format($order->total_amount, 0) }}</span>
            </div>
        </div>
    </div>

    <!-- Customer & Status -->
    <div>
        <!-- Customer Info -->
        <div class="card">
            <h2 class="card-title" style="margin-bottom: 20px;">Customer Information</h2>

            <div style="margin-bottom: 15px;">
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Name</p>
                <p style="font-weight: 500;">{{ $order->customer_name }}</p>
            </div>

            <div style="margin-bottom: 15px;">
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Email</p>
                <p>{{ $order->customer_email }}</p>
            </div>

            <div style="margin-bottom: 15px;">
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Phone</p>
                <p>{{ $order->customer_phone }}</p>
            </div>

            <div>
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Delivery Address</p>
                <p>{{ $order->delivery_address }}</p>
                <p>{{ $order->delivery_city }}</p>
            </div>

            @if($order->notes)
            <div style="margin-top: 15px; padding: 12px; background: rgba(247, 127, 0, 0.1); border-radius: 8px;">
                <p style="font-size: 12px; color: var(--secondary); margin-bottom: 4px;">
                    <i class="fas fa-sticky-note"></i> Customer Notes
                </p>
                <p style="font-size: 14px;">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Update Status -->
        <div class="card">
            <h2 class="card-title" style="margin-bottom: 20px;">Update Order Status</h2>

            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label class="form-label">Order Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="completed" {{ in_array($order->status, ['completed','delivered']) ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-save"></i>
                    Update Status
                </button>
            </form>
        </div>

        <!-- Order Timeline -->
        <div class="card">
            <h2 class="card-title" style="margin-bottom: 20px;">Order Timeline</h2>

            <div style="position: relative; padding-left: 25px;">
                @php
                $statuses = [
                'pending' => ['icon' => 'clock', 'label' => 'Order Placed'],
                'confirmed' => ['icon' => 'check', 'label' => 'Order Confirmed'],
                'preparing' => ['icon' => 'fire', 'label' => 'Preparing'],
                'out_for_delivery' => ['icon' => 'motorcycle', 'label' => 'Out for Delivery'],
                'completed' => ['icon' => 'check-circle', 'label' => 'Completed'],
                ];
                $statusOrder = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'completed'];
                $normalizedStatus = in_array($order->status, ['completed','delivered']) ? 'completed' : $order->status;
                $currentIndex = array_search($normalizedStatus, $statusOrder);
                if ($currentIndex === false) $currentIndex = -1;
                @endphp

                @foreach($statuses as $status => $info)
                @php
                $statusIdx = array_search($status, $statusOrder);
                $isCompleted = $statusIdx <= $currentIndex && $order->status !== 'cancelled';
                    $isCurrent = $status === $normalizedStatus;
                    @endphp
                    <div class="timeline-entry {{ !$loop->last ? 'with-line' : '' }} {{ $isCompleted && !$loop->last ? 'completed' : '' }}">
                        <div class="timeline-dot {{ $isCompleted ? 'completed' : '' }}">
                            <i class="fas fa-{{ $info['icon'] }}"></i>
                        </div>
                        <div style="padding-left: 10px;">
                            <div class="timeline-label {{ $isCompleted ? 'completed' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                {{ $info['label'] }}
                            </div>
                            @if($isCurrent)
                            <div style="font-size: 12px; color: var(--success);">Current Status</div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    @if($order->status === 'cancelled')
                    <div style="position: relative; padding-bottom: 0;">
                        <div style="position: absolute; left: -31px; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; background: var(--danger); color: white;">
                            <i class="fas fa-times"></i>
                        </div>
                        <div style="padding-left: 10px;">
                            <div style="font-weight: 600; color: var(--danger);">Cancelled</div>
                        </div>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back to Orders
    </a>
</div>
@endsection