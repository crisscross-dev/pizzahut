@extends('layouts.shop')

@section('title', 'Your Cart - Pizzeria')

@section('content')
<style>
    .cart-page {
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
        padding-bottom: 120px;
    }

    .cart-page-header {
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

    .cart-page-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
    }

    .cart-page-items {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .cart-page-item {
        display: flex;
        gap: 16px;
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .cart-page-item:last-child {
        border-bottom: none;
    }

    .cart-page-item-image {
        width: 100px;
        height: 100px;
        border-radius: 14px;
        object-fit: cover;
    }

    .cart-page-item-info {
        flex: 1;
    }

    .cart-page-item-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .cart-page-item-size {
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 10px;
    }

    .cart-page-item-price {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-orange);
    }

    .cart-page-item-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
    }

    .cart-page-item-remove {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 8px;
        font-size: 16px;
        transition: var(--transition-smooth);
    }

    .cart-page-item-remove:hover {
        color: var(--primary-red);
    }

    .cart-page-quantity {
        display: flex;
        align-items: center;
        gap: 14px;
        background: var(--dark-surface);
        border-radius: 12px;
        padding: 8px;
    }

    .cart-page-qty-btn {
        width: 36px;
        height: 36px;
        background: var(--dark-card);
        border: none;
        border-radius: 10px;
        color: var(--text-light);
        font-size: 16px;
        cursor: pointer;
        transition: var(--transition-smooth);
    }

    .cart-page-qty-btn:hover {
        background: var(--primary-orange);
    }

    .cart-page-qty-value {
        font-weight: 600;
        min-width: 24px;
        text-align: center;
        font-size: 16px;
    }

    .cart-page-summary {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 24px;
    }

    .cart-page-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 14px;
        font-size: 15px;
    }

    .cart-page-summary-row.total {
        font-size: 22px;
        font-weight: 700;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cart-page-checkout-btn {
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
        margin-top: 24px;
        text-decoration: none;
    }

    .cart-page-checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(230, 57, 70, 0.4);
    }

    .cart-page-empty {
        text-align: center;
        padding: 80px 20px;
    }

    .cart-page-empty i {
        font-size: 80px;
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    .cart-page-empty h2 {
        margin-bottom: 12px;
        font-family: 'Playfair Display', serif;
    }

    .cart-page-empty p {
        color: var(--text-muted);
        margin-bottom: 32px;
    }

    .cart-page-empty a {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 32px;
        background: var(--gradient-warm);
        border-radius: 14px;
        color: var(--text-light);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition-smooth);
    }

    .cart-page-empty a:hover {
        transform: translateY(-2px);
    }

    @media (min-width: 768px) {
        .cart-page-item-image {
            width: 120px;
            height: 120px;
        }

        .cart-page-item-name {
            font-size: 20px;
        }
    }
</style>

<div class="cart-page">
    <div class="cart-page-header">
        <a href="{{ route('shop.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Menu
        </a>
        <h1 class="cart-page-title">Your Cart</h1>
    </div>

    <div id="cartPageContent">
        <!-- Cart content will be rendered by JavaScript -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    function renderCartPage() {
        const cart = JSON.parse(localStorage.getItem('pizzaCart')) || [];
        const cartPageContent = document.getElementById('cartPageContent');

        if (cart.length === 0) {
            cartPageContent.innerHTML = `
            <div class="cart-page-empty">
                <i class="fas fa-shopping-bag"></i>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any pizzas yet!</p>
                <a href="{{ route('shop.index') }}">
                    <i class="fas fa-pizza-slice"></i>
                    Explore Menu
                </a>
            </div>
        `;
            return;
        }

        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const deliveryFee = 50.00;
        const total = subtotal + deliveryFee;

        cartPageContent.innerHTML = `
        <div class="cart-page-items">
            ${cart.map((item, index) => `
                <div class="cart-page-item">
                    <img src="${item.image}" alt="${item.name}" class="cart-page-item-image">
                    <div class="cart-page-item-info">
                        <div class="cart-page-item-name">${item.name}</div>
                        <div class="cart-page-item-size">${item.size.charAt(0).toUpperCase() + item.size.slice(1)} Size</div>
                        <div class="cart-page-item-price">₱${(item.price * item.quantity).toFixed(2)}</div>
                    </div>
                    <div class="cart-page-item-actions">
                        <button class="cart-page-item-remove" onclick="removeItemFromCart(${index})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <div class="cart-page-quantity">
                            <button class="cart-page-qty-btn" onclick="updateItemQuantity(${index}, -1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="cart-page-qty-value">${item.quantity}</span>
                            <button class="cart-page-qty-btn" onclick="updateItemQuantity(${index}, 1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>

        <div class="cart-page-summary">
            <div class="cart-page-summary-row">
                <span>Subtotal</span>
                <span>₱${subtotal.toFixed(2)}</span>
            </div>
            <div class="cart-page-summary-row">
                <span>Delivery Fee</span>
                <span>₱${deliveryFee.toFixed(2)}</span>
            </div>
            <div class="cart-page-summary-row total">
                <span>Total</span>
                <span>₱${total.toFixed(2)}</span>
            </div>
            <a href="{{ route('shop.checkout') }}" class="cart-page-checkout-btn">
                <span>Proceed to Checkout</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    `;
    }

    function removeItemFromCart(index) {
        let cart = JSON.parse(localStorage.getItem('pizzaCart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('pizzaCart', JSON.stringify(cart));
        renderCartPage();
        updateCartBadge();
    }

    function updateItemQuantity(index, delta) {
        let cart = JSON.parse(localStorage.getItem('pizzaCart')) || [];
        cart[index].quantity += delta;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        localStorage.setItem('pizzaCart', JSON.stringify(cart));
        renderCartPage();
        updateCartBadge();
    }

    document.addEventListener('DOMContentLoaded', renderCartPage);
</script>
@endsection