<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #E63946 0%, #F77F00 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0 0 10px;
            font-size: 28px;
        }

        .brand-line {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            opacity: 0.95;
        }

        .header .order-number {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .status-badge {
            display: inline-block;
            background: #FFF3CD;
            color: #856404;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .order-items {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
        }

        .item-details {
            font-size: 13px;
            color: #666;
        }

        .totals {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .total-row.grand-total {
            font-size: 20px;
            font-weight: 700;
            color: #E63946;
            border-top: 2px solid #E63946;
            margin-top: 10px;
            padding-top: 15px;
        }

        .delivery-info {
            background: #e8f4fd;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .delivery-info h3 {
            margin: 0 0 15px;
            color: #0056b3;
        }

        .payment-badge {
            display: inline-block;
            background: #d4edda;
            color: #155724;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: 600;
        }

        .footer {
            background: #1A1A2E;
            color: #999;
            padding: 20px 30px;
            text-align: center;
            font-size: 13px;
        }

        .footer a {
            color: #F77F00;
            text-decoration: none;
        }

        .track-btn {
            display: inline-block;
            background: linear-gradient(135deg, #E63946 0%, #F77F00 100%);
            color: white;
            padding: 14px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="brand-line">Eliseo's Pizzeria</div>
            <h1>🍕 Order Confirmed!</h1>
            <div class="order-number">Order #{{ $order->order_number }}</div>
        </div>

        <div class="content">
            <div class="greeting">
                Hi {{ $order->customer_name }},
            </div>

            <p>Thank you for your order! We've received it and are getting it ready for you.</p>

            <div class="status-badge">
                {{ $order->status_label }}
            </div>

            <div class="order-items">
                <h3 style="margin: 0 0 15px;">Order Summary</h3>

                @foreach($order->items as $item)
                <div class="order-item">
                    <div>
                        <div class="item-name">{{ $item->pizza_name }}</div>
                        <div class="item-details">{{ ucfirst($item->size) }} × {{ $item->quantity }}</div>
                    </div>
                    <div style="font-weight: 600;">₱{{ number_format($item->total_price, 2) }}</div>
                </div>
                @endforeach

                <div class="totals">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>₱{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span>Delivery Fee</span>
                        <span>₱{{ number_format($order->delivery_fee, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span>VAT (12%)</span>
                        <span>₱{{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total</span>
                        <span>₱{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="delivery-info">
                <h3>📍 Delivery Details</h3>
                <p style="margin: 0;">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->delivery_address }}<br>
                    {{ $order->city }}<br>
                    📱 {{ $order->customer_phone }}
                </p>
                @if($order->notes)
                <p style="margin: 15px 0 0; font-style: italic;">
                    Note: {{ $order->notes }}
                </p>
                @endif
            </div>

            <div style="margin-top: 20px;">
                <strong>Payment Method:</strong>
                <span class="payment-badge">
                    @if($order->payment_method === 'cod')
                    💵 Cash on Delivery
                    @elseif($order->payment_method === 'gcash')
                    📱 GCash
                    @else
                    📱 Maya
                    @endif
                </span>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('orders.track', $order) }}" class="track-btn">
                    Track Your Order
                </a>
            </div>
        </div>

        <div class="footer">
            <p>Questions? Contact us at support@pizzahut.com</p>
            <p>&copy; {{ date('Y') }} Pizzeria. All rights reserved.</p>
        </div>
    </div>
</body>

</html>