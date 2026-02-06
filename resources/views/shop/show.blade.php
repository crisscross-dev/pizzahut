@extends('layouts.shop')

@section('title', $pizza->name . ' - Pizzeria')

@section('content')
<style>
    .pizza-detail {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        padding-bottom: 120px;
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

    .pizza-detail-content {
        display: grid;
        gap: 30px;
    }

    .pizza-detail-image-container {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .pizza-detail-image {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        display: block;
    }

    .pizza-detail-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        padding: 8px 16px;
        background: var(--gradient-warm);
        border-radius: 25px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pizza-detail-info {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 30px;
    }

    .pizza-detail-category {
        color: var(--primary-orange);
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .pizza-detail-name {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .pizza-detail-description {
        color: var(--text-muted);
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 24px;
    }

    .pizza-detail-ingredients-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--text-muted);
    }

    .pizza-detail-ingredients {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }

    .pizza-detail-ingredient {
        padding: 10px 16px;
        background: rgba(247, 127, 0, 0.15);
        border-radius: 25px;
        font-size: 13px;
        color: var(--primary-orange);
        font-weight: 500;
    }

    .pizza-detail-size-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--text-muted);
    }

    .pizza-detail-sizes {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 30px;
    }

    .pizza-detail-size {
        padding: 16px;
        background: var(--dark-surface);
        border: 2px solid transparent;
        border-radius: var(--border-radius-sm);
        cursor: pointer;
        transition: var(--transition-smooth);
        text-align: center;
    }

    .pizza-detail-size:hover {
        border-color: var(--primary-orange);
    }

    .pizza-detail-size.active {
        border-color: var(--primary-orange);
        background: rgba(247, 127, 0, 0.15);
    }

    .pizza-detail-size-name {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .pizza-detail-size-info {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 8px;
    }

    .pizza-detail-size-price {
        font-weight: 700;
        color: var(--primary-orange);
        font-size: 18px;
    }

    .pizza-detail-quantity {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .pizza-detail-quantity-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .pizza-detail-quantity-control {
        display: flex;
        align-items: center;
        gap: 16px;
        background: var(--dark-surface);
        border-radius: 14px;
        padding: 10px;
    }

    .pizza-detail-qty-btn {
        width: 44px;
        height: 44px;
        background: var(--dark-card);
        border: none;
        border-radius: 12px;
        color: var(--text-light);
        font-size: 18px;
        cursor: pointer;
        transition: var(--transition-smooth);
    }

    .pizza-detail-qty-btn:hover {
        background: var(--primary-orange);
    }

    .pizza-detail-qty-value {
        font-weight: 700;
        font-size: 20px;
        min-width: 30px;
        text-align: center;
    }

    .pizza-detail-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .pizza-detail-price {
        font-size: 36px;
        font-weight: 700;
    }

    .pizza-detail-price .currency {
        font-size: 20px;
        color: var(--text-muted);
        font-weight: 400;
    }

    .pizza-detail-add-btn {
        flex: 1;
        max-width: 280px;
        padding: 18px 30px;
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
    }

    .pizza-detail-add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(230, 57, 70, 0.4);
    }

    .pizza-detail-add-btn:active {
        transform: scale(0.98);
    }

    .pizza-detail-add-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
        background: var(--dark-card);
    }

    @media (min-width: 768px) {
        .pizza-detail-content {
            grid-template-columns: 1fr 1fr;
            align-items: start;
        }

        .pizza-detail-image-container {
            position: sticky;
            top: 100px;
        }

        .pizza-detail-name {
            font-size: 38px;
        }
    }
</style>

<div class="pizza-detail">
    <a href="{{ route('shop.index') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Back to Menu
    </a>

    <div class="pizza-detail-content">
        <div class="pizza-detail-image-container">
            <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="pizza-detail-image">
            @if(!$pizza->is_available)
            <span class="pizza-detail-badge" style="background: var(--primary-red);">
                <i class="fas fa-ban"></i> Unavailable
            </span>
            @elseif($pizza->is_featured)
            <span class="pizza-detail-badge">
                <i class="fas fa-star"></i> Featured
            </span>
            @endif
        </div>

        <div class="pizza-detail-info">
            <span class="pizza-detail-category">{{ ucfirst($pizza->category) }}</span>
            <h1 class="pizza-detail-name">{{ $pizza->name }}</h1>
            <p class="pizza-detail-description">{{ $pizza->description }}</p>

            <div class="pizza-detail-ingredients-title">Ingredients</div>
            <div class="pizza-detail-ingredients">
                @foreach($pizza->ingredients as $ingredient)
                <span class="pizza-detail-ingredient">{{ $ingredient }}</span>
                @endforeach
            </div>

            <div class="pizza-detail-size-title">Choose Size</div>
            <div class="pizza-detail-sizes" id="sizeSelector">
                <button class="pizza-detail-size" data-size="small" data-multiplier="0.8">
                    <div class="pizza-detail-size-name">Small</div>
                    <div class="pizza-detail-size-info">8 inch</div>
                    <div class="pizza-detail-size-price">₱{{ number_format($pizza->price * 0.8, 2) }}</div>
                </button>
                <button class="pizza-detail-size active" data-size="medium" data-multiplier="1">
                    <div class="pizza-detail-size-name">Medium</div>
                    <div class="pizza-detail-size-info">12 inch</div>
                    <div class="pizza-detail-size-price">₱{{ number_format($pizza->price, 2) }}</div>
                </button>
                <button class="pizza-detail-size" data-size="large" data-multiplier="1.3">
                    <div class="pizza-detail-size-name">Large</div>
                    <div class="pizza-detail-size-info">16 inch</div>
                    <div class="pizza-detail-size-price">₱{{ number_format($pizza->price * 1.3, 2) }}</div>
                </button>
            </div>

            <div class="pizza-detail-quantity">
                <span class="pizza-detail-quantity-label">Quantity</span>
                <div class="pizza-detail-quantity-control">
                    <button class="pizza-detail-qty-btn" id="qtyMinus">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="pizza-detail-qty-value" id="qtyValue">1</span>
                    <button class="pizza-detail-qty-btn" id="qtyPlus">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="pizza-detail-footer">
                <div class="pizza-detail-price">
                    <span class="currency">₱</span><span id="totalPrice">{{ number_format($pizza->price, 2) }}</span>
                </div>
                <button class="pizza-detail-add-btn" id="addToCartBtn"
                    data-id="{{ $pizza->id }}"
                    data-name="{{ $pizza->name }}"
                    data-image="{{ $pizza->image_url }}"
                    data-base-price="{{ $pizza->price }}"
                    data-available="{{ $pizza->is_available ? 1 : 0 }}"
                    {{ $pizza->is_available ? '' : 'disabled' }}>
                    <i class="fas fa-plus"></i>
                    <span>{{ $pizza->is_available ? 'Add to Cart' : 'Unavailable' }}</span>
                </button>
            </div>

            @if(!$pizza->is_available)
            <p style="margin-top: 14px; color: var(--text-muted);">
                This pizza is currently unavailable for order.
            </p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedSize = 'medium';
        let multiplier = 1;
        let quantity = 1;

        const totalPriceEl = document.getElementById('totalPrice');
        const qtyValueEl = document.getElementById('qtyValue');
        const qtyMinusBtn = document.getElementById('qtyMinus');
        const qtyPlusBtn = document.getElementById('qtyPlus');
        const sizeButtons = document.querySelectorAll('.pizza-detail-size');
        const addToCartBtn = document.getElementById('addToCartBtn');

        const basePrice = parseFloat(addToCartBtn.dataset.basePrice || '0');

        function updatePrice() {
            const total = (basePrice * multiplier * quantity).toFixed(2);
            totalPriceEl.textContent = total;
        }

        // Size selection
        sizeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                sizeButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedSize = btn.dataset.size;
                multiplier = parseFloat(btn.dataset.multiplier);
                updatePrice();
            });
        });

        // Quantity control
        qtyMinusBtn.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                qtyValueEl.textContent = quantity;
                updatePrice();
            }
        });

        qtyPlusBtn.addEventListener('click', () => {
            if (quantity < 10) {
                quantity++;
                qtyValueEl.textContent = quantity;
                updatePrice();
            }
        });

        // Add to cart
        addToCartBtn.addEventListener('click', () => {
            const pizza = {
                id: addToCartBtn.dataset.id,
                name: addToCartBtn.dataset.name,
                price: basePrice * multiplier,
                image: addToCartBtn.dataset.image,
                size: selectedSize,
                quantity: quantity
            };

            addToCart(pizza);

            // Button animation
            addToCartBtn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                addToCartBtn.style.transform = '';
            }, 150);
        });
    });
</script>
@endsection