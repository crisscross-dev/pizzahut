@extends('layouts.shop')

@section('title', 'Checkout - Pizzeria')

@section('content')
<style>
    .checkout-page {
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
        padding-bottom: 120px;
    }

    .checkout-header {
        margin-bottom: 30px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
        transition: var(--transition-smooth);
    }

    .back-btn:hover {
        color: var(--primary-orange);
    }

    .checkout-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
    }

    .checkout-section {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 24px;
        margin-bottom: 20px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .section-number {
        width: 32px;
        height: 32px;
        background: var(--gradient-warm);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
    }

    .section-label {
        font-size: 18px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-input {
        width: 100%;
        padding: 16px;
        background: var(--dark-surface);
        border: 2px solid transparent;
        border-radius: var(--border-radius-sm);
        color: var(--text-light);
        font-size: 15px;
        font-family: inherit;
        transition: var(--transition-smooth);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-orange);
    }

    .form-input::placeholder {
        color: var(--text-muted);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    /* Order Summary */
    .order-items {
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item-image {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
    }

    .order-item-info {
        flex: 1;
    }

    .order-item-name {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .order-item-details {
        font-size: 12px;
        color: var(--text-muted);
    }

    .order-item-price {
        font-weight: 600;
        color: var(--primary-orange);
    }

    .order-totals {
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .order-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .order-row.total {
        font-size: 20px;
        font-weight: 700;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Payment Options */
    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: var(--dark-surface);
        border: 2px solid transparent;
        border-radius: var(--border-radius-sm);
        cursor: pointer;
        transition: var(--transition-smooth);
    }

    .payment-option:hover {
        border-color: rgba(247, 127, 0, 0.3);
    }

    .payment-option.selected {
        border-color: var(--primary-orange);
        background: rgba(247, 127, 0, 0.1);
    }

    .payment-radio {
        width: 22px;
        height: 22px;
        border: 2px solid var(--text-muted);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-smooth);
    }

    .payment-option.selected .payment-radio {
        border-color: var(--primary-orange);
    }

    .payment-radio::after {
        content: '';
        width: 12px;
        height: 12px;
        background: var(--primary-orange);
        border-radius: 50%;
        opacity: 0;
        transform: scale(0);
        transition: var(--transition-smooth);
    }

    .payment-option.selected .payment-radio::after {
        opacity: 1;
        transform: scale(1);
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        background: var(--dark-card);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--primary-orange);
    }

    .payment-info h4 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .payment-info p {
        font-size: 12px;
        color: var(--text-muted);
    }

    /* Place Order Button */
    .place-order-btn {
        width: 100%;
        padding: 20px;
        background: var(--gradient-warm);
        border: none;
        border-radius: 16px;
        color: var(--text-light);
        font-size: 17px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-smooth);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-top: 20px;
    }

    .place-order-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(230, 57, 70, 0.4);
    }

    .place-order-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .place-order-btn.loading {
        pointer-events: none;
    }

    .place-order-btn .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        display: none;
    }

    .place-order-btn.loading .spinner {
        display: block;
    }

    .place-order-btn.loading .btn-text {
        display: none;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Success Modal */
    .success-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3000;
        opacity: 0;
        visibility: hidden;
        transition: var(--transition-smooth);
        padding: 20px;
    }

    .success-modal.show {
        opacity: 1;
        visibility: visible;
    }

    .success-content {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 40px;
        text-align: center;
        max-width: 400px;
        width: 100%;
        transform: scale(0.9);
        transition: var(--transition-smooth);
    }

    .success-modal.show .success-content {
        transform: scale(1);
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: var(--success-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin: 0 auto 24px;
        animation: successPop 0.5s ease;
    }

    @keyframes successPop {
        0% {
            transform: scale(0);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    .success-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        margin-bottom: 12px;
    }

    .success-message {
        color: var(--text-muted);
        margin-bottom: 8px;
    }

    .order-number {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-orange);
        margin-bottom: 24px;
    }

    .success-btn {
        width: 100%;
        padding: 16px;
        background: var(--gradient-warm);
        border: none;
        border-radius: 14px;
        color: var(--text-light);
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-smooth);
    }

    .success-btn:hover {
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-checkout {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-checkout i {
        font-size: 70px;
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    .empty-checkout h2 {
        margin-bottom: 12px;
    }

    .empty-checkout p {
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    .empty-checkout a {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 28px;
        background: var(--gradient-warm);
        border-radius: 14px;
        color: var(--text-light);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition-smooth);
    }

    .empty-checkout a:hover {
        transform: translateY(-2px);
    }

    @media (min-width: 1024px) {
        .checkout-page {
            max-width: 900px;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
        }

        .checkout-form-section {
            order: 1;
        }

        .order-summary-section {
            order: 2;
        }
    }
</style>

<div class="checkout-page">
    <div class="checkout-header">
        <a href="{{ route('shop.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Menu
        </a>
        <h1 class="checkout-title">Checkout</h1>
    </div>

    <div id="checkoutContent">
        <!-- Content will be rendered by JavaScript -->
    </div>
</div>

<!-- Success Modal -->
<div class="success-modal" id="successModal">
    <div class="success-content">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h2 class="success-title">Order Confirmed!</h2>
        <p class="success-message">Your delicious pizza is being prepared.</p>
        <p class="order-number">Order #<span id="orderNumber">PH-XXXXX</span></p>
        <a href="{{ route('shop.index') }}" class="success-btn">
            Continue Shopping
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cart = JSON.parse(localStorage.getItem('pizzaCart')) || [];
        const checkoutContent = document.getElementById('checkoutContent');
        const successModal = document.getElementById('successModal');

        if (cart.length === 0) {
            checkoutContent.innerHTML = `
            <div class="empty-checkout">
                <i class="fas fa-shopping-bag"></i>
                <h2>Your cart is empty</h2>
                <p>Add some pizzas before checking out!</p>
                <a href="{{ route('shop.index') }}">
                    <i class="fas fa-pizza-slice"></i>
                    Browse Menu
                </a>
            </div>
        `;
            return;
        }

        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const deliveryFee = 50.00;
        const tax = subtotal * 0.12;
        const total = subtotal + deliveryFee + tax;

        checkoutContent.innerHTML = `
        <div class="checkout-layout">
            <div class="checkout-form-section">
                <!-- Delivery Info -->
                <div class="checkout-section">
                    <div class="section-header">
                        <span class="section-number">1</span>
                        <span class="section-label">Delivery Details</span>
                    </div>
                    <form id="checkoutForm">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" name="name" placeholder="John Doe" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" name="email" placeholder="john@example.com" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-input" name="phone" placeholder="+1 234 567 890" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Delivery Address</label>
                            <input type="text" class="form-input" name="address" placeholder="123 Pizza Street, Apt 4B" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <input type="text" class="form-input" name="city" placeholder="New York" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" class="form-input" name="zip" placeholder="10001">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Special Instructions (Optional)</label>
                            <textarea class="form-input form-textarea" name="notes" placeholder="Ring doorbell twice, extra napkins, etc."></textarea>
                        </div>
                    </form>
                </div>

                <!-- Payment Method -->
                <div class="checkout-section">
                    <div class="section-header">
                        <span class="section-number">2</span>
                        <span class="section-label">Payment Method</span>
                    </div>
                    <div class="payment-options">
                        <div class="payment-option selected" data-method="cod">
                            <div class="payment-radio"></div>
                            <div class="payment-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="payment-info">
                                <h4>Cash on Delivery</h4>
                                <p>Pay when you receive your order</p>
                            </div>
                        </div>
                        <div class="payment-option" data-method="gcash">
                            <div class="payment-radio"></div>
                            <div class="payment-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="payment-info">
                                <h4>GCash</h4>
                                <p>Pay with GCash</p>
                            </div>
                        </div>
                        <div class="payment-option" data-method="maya">
                            <div class="payment-radio"></div>
                            <div class="payment-icon">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="payment-info">
                                <h4>Maya</h4>
                                <p>Pay with Maya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-summary-section">
                <!-- Order Summary -->
                <div class="checkout-section">
                    <div class="section-header">
                        <span class="section-number"><i class="fas fa-receipt"></i></span>
                        <span class="section-label">Order Summary</span>
                    </div>
                    <div class="order-items">
                        ${cart.map(item => `
                            <div class="order-item">
                                <img src="${item.image}" alt="${item.name}" class="order-item-image">
                                <div class="order-item-info">
                                    <div class="order-item-name">${item.name}</div>
                                    <div class="order-item-details">${item.size.charAt(0).toUpperCase() + item.size.slice(1)} × ${item.quantity}</div>
                                </div>
                                <div class="order-item-price">₱${(item.price * item.quantity).toFixed(2)}</div>
                            </div>
                        `).join('')}
                    </div>
                    <div class="order-totals">
                        <div class="order-row">
                            <span>Subtotal</span>
                            <span>₱${subtotal.toFixed(2)}</span>
                        </div>
                        <div class="order-row">
                            <span>Delivery Fee</span>
                            <span>₱${deliveryFee.toFixed(2)}</span>
                        </div>
                        <div class="order-row">
                            <span>Tax (12%)</span>
                            <span>₱${tax.toFixed(2)}</span>
                        </div>
                        <div class="order-row total">
                            <span>Total</span>
                            <span>₱${total.toFixed(2)}</span>
                        </div>
                    </div>
                    <button type="button" class="place-order-btn" id="placeOrderBtn">
                        <span class="spinner"></span>
                        <span class="btn-text">Place Order - ₱${total.toFixed(2)}</span>
                    </button>
                </div>
            </div>
        </div>
    `;

        // Payment option selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
            });
        });

        // Place order button
        document.getElementById('placeOrderBtn').addEventListener('click', async function() {
            const form = document.getElementById('checkoutForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const btn = this;
            btn.classList.add('loading');
            btn.disabled = true;

            try {
                const formData = new FormData(form);
                const selectedPayment = document.querySelector('.payment-option.selected');
                const paymentMethod = selectedPayment ? selectedPayment.dataset.method : 'cod';

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const response = await fetch("{{ route('api.checkout') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        ...(csrfToken ? {
                            'X-CSRF-TOKEN': csrfToken
                        } : {}),
                    },
                    body: JSON.stringify({
                        name: formData.get('name'),
                        email: formData.get('email'),
                        phone: formData.get('phone'),
                        address: formData.get('address'),
                        city: formData.get('city'),
                        notes: formData.get('notes'),
                        payment_method: paymentMethod,
                        cart,
                    }),
                });

                const contentType = response.headers.get('content-type') || '';
                if (!contentType.includes('application/json')) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                const data = await response.json();

                if (!response.ok || !data.success) {
                    if (data.requires_auth) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }

                    throw new Error(data.message || 'Unable to place order.');
                }

                document.getElementById('orderNumber').textContent = data.order_number || 'PH-XXXXX';

                localStorage.removeItem('pizzaCart');
                if (typeof updateCartBadge === 'function') updateCartBadge();

                successModal.classList.add('show');
            } catch (error) {
                alert(error.message || 'Something went wrong. Please try again.');
            } finally {
                btn.classList.remove('loading');
                btn.disabled = false;
            }
        });
    });
</script>
@endsection