@extends('layouts.admin')

@section('title', 'Orders')
@section('subtitle', '')

@section('hideHeaderTitle', true)
@section('hideUserMenu', true)

@section('content')
<style>
    .order-filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .order-filter-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 6px;
        }

        .order-filter-tabs::-webkit-scrollbar {
            height: 0;
        }

        .order-filter-tabs .btn {
            flex: 0 0 auto;
            white-space: nowrap;
            padding: 10px 14px;
            border-radius: 999px;
        }
    }
</style>
<!-- Filter Tabs -->
<div class="order-filter-tabs">
    <a href="{{ route('admin.orders.index') }}"
        class="btn {{ !request('status') ? 'btn-primary' : 'btn-secondary' }}">
        All Orders
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
        class="btn {{ request('status') == 'pending' ? 'btn-primary' : 'btn-secondary' }}">
        Pending
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}"
        class="btn {{ request('status') == 'confirmed' ? 'btn-primary' : 'btn-secondary' }}">
        Confirmed
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'preparing']) }}"
        class="btn {{ request('status') == 'preparing' ? 'btn-primary' : 'btn-secondary' }}">
        Preparing
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'out_for_delivery']) }}"
        class="btn {{ request('status') == 'out_for_delivery' ? 'btn-primary' : 'btn-secondary' }}">
        Out for Delivery
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
        class="btn {{ request('status') == 'completed' ? 'btn-primary' : 'btn-secondary' }}">
        Completed
    </a>
</div>

<div class="card">
    <div class="table-container admin-desktop-only">
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                            #{{ $order->order_number }}
                        </a>
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $order->customer_name }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $order->customer_phone }}</div>
                    </td>
                    <td>{{ $order->items->sum('quantity') }} items</td>
                    <td style="font-weight: 700;">₱{{ number_format($order->total_amount, 0) }}</td>
                    <td>
                        <span class="status-badge {{ $order->status }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td style="font-size: 13px; color: var(--text-muted);">
                        {{ $order->created_at->format('M d, Y') }}<br>
                        {{ $order->created_at->format('h:i A') }}
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.orders.show', $order) }}" class="action-btn edit" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                        <i class="fas fa-shopping-bag" style="font-size: 48px; opacity: 0.3; margin-bottom: 15px; display: block;"></i>
                        No orders found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-mobile-only">
        @forelse($orders as $order)
        <div class="admin-order-card">
            <div class="admin-order-card-top">
                <a href="{{ route('admin.orders.show', $order) }}" class="admin-order-card-number">#{{ $order->order_number }}</a>
                <span class="status-badge {{ $order->status }}" id="orderStatusBadge{{ $order->id }}">{{ $order->status_label }}</span>
            </div>

            <div class="admin-order-card-mid">
                <div>
                    <div class="admin-order-card-customer">{{ $order->customer_name }}</div>
                    <div class="admin-order-card-sub">{{ $order->items->sum('quantity') }} items • {{ $order->created_at->format('M d, Y h:i A') }}</div>
                </div>
                <div class="admin-order-card-total">₱{{ number_format($order->total_amount, 0) }}</div>
            </div>

            <div class="admin-order-card-actions">
                <select class="form-control" style="flex: 1;" data-order-id="{{ $order->id }}" onchange="updateOrderStatus(this.dataset.orderId, this.value)">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Order Confirmed</option>
                    <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="completed" {{ in_array($order->status, ['completed','delivered']) ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">Details</a>
            </div>
        </div>
        @empty
        <div style="text-align: center; color: var(--text-muted); padding: 20px;">
            No orders found
        </div>
        @endforelse
    </div>

    @if($orders->hasPages())
    @include('admin.partials.pagination', ['paginator' => $orders])
    @endif
</div>
@endsection

@section('scripts')
<script>
    async function updateOrderStatus(orderId, status) {
        try {
            const response = await fetchWithCsrf(`/admin/orders/${orderId}/status`, {
                method: 'PATCH',
                body: JSON.stringify({
                    status
                }),
            });

            if (!response.ok) {
                throw new Error('Failed to update status');
            }

            const data = await response.json();
            const badge = document.getElementById(`orderStatusBadge${orderId}`);
            if (badge && data.status) {
                badge.className = `status-badge ${data.status}`;
                badge.textContent = data.status_label || data.status;
            }
        } catch (e) {
            alert('Could not update order status. Please try again.');
        }
    }
</script>
@endsection