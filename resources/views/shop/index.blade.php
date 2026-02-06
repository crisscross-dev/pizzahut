@extends('layouts.shop')

@section('title', 'Pizzeria - Artisan Pizza Delivery')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <h1 class="hero-title animate-fadeInUp">
        Crafted with <span>Passion</span>
    </h1>
    <p class="hero-subtitle animate-fadeInUp delay-2">
        Experience artisan pizzas made with love and the finest ingredients
    </p>
</section>

<!-- Category Pills -->
<div class="category-pills">
    <button class="category-pill active" data-category="all">
        <i class="fas fa-fire"></i> All Pizzas
    </button>
    <button class="category-pill" data-category="classic">
        <i class="fas fa-star"></i> Classic
    </button>
    <button class="category-pill" data-category="gourmet">
        <i class="fas fa-crown"></i> Gourmet
    </button>
    <button class="category-pill" data-category="specialty">
        <i class="fas fa-gem"></i> Specialty
    </button>
    <button class="category-pill" data-category="vegetarian">
        <i class="fas fa-leaf"></i> Vegetarian
    </button>
</div>

<!-- Featured Pizzas -->
@if($featuredPizzas->count() > 0)
<section class="pizza-section" id="featuredSection">
    <h2 class="section-title">Featured Picks</h2>

    @foreach($featuredPizzas as $pizza)
    <article class="pizza-card" data-category="{{ $pizza->category }}">
        <div class="pizza-image-container">
            <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="pizza-image" loading="lazy">
            @if(!$pizza->is_available)
            <span class="pizza-badge" style="background: var(--primary-red);">
                <i class="fas fa-ban"></i> Unavailable
            </span>
            @else
            <span class="pizza-badge">
                <i class="fas fa-star"></i> Featured
            </span>
            @endif
        </div>
        <div class="pizza-info">
            <span class="pizza-category">{{ ucfirst($pizza->category) }}</span>
            <h3 class="pizza-name">{{ $pizza->name }}</h3>
            <p class="pizza-description">{{ $pizza->description }}</p>

            <div class="pizza-ingredients">
                @foreach($pizza->ingredients as $ingredient)
                <span class="ingredient-tag">{{ $ingredient }}</span>
                @endforeach
            </div>

            <!-- Size Selector -->
            <div class="size-selector" data-pizza-id="{{ $pizza->id }}">
                <button class="size-option" data-size="small" data-multiplier="0.8">
                    <span class="size-name">Small</span>
                    <span class="size-price">₱{{ number_format($pizza->price * 0.8, 2) }}</span>
                </button>
                <button class="size-option active" data-size="medium" data-multiplier="1">
                    <span class="size-name">Medium</span>
                    <span class="size-price">₱{{ number_format($pizza->price, 2) }}</span>
                </button>
                <button class="size-option" data-size="large" data-multiplier="1.3">
                    <span class="size-name">Large</span>
                    <span class="size-price">₱{{ number_format($pizza->price * 1.3, 2) }}</span>
                </button>
            </div>

            <div class="pizza-footer">
                <div class="pizza-price">
                    <span class="currency">₱</span><span class="price-value" id="price-{{ $pizza->id }}">{{ number_format($pizza->price, 2) }}</span>
                </div>
                <button class="add-to-cart-btn"
                    data-id="{{ $pizza->id }}"
                    data-name="{{ $pizza->name }}"
                    data-price="{{ $pizza->price }}"
                    data-image="{{ $pizza->image_url }}"
                    data-available="{{ $pizza->is_available ? 1 : 0 }}"
                    {{ $pizza->is_available ? '' : 'disabled' }}>
                    <i class="fas fa-plus"></i>
                    <span>{{ $pizza->is_available ? 'Add to Cart' : 'Unavailable' }}</span>
                </button>
            </div>
        </div>
    </article>
    @endforeach
</section>
@endif

<!-- All Pizzas -->
<section class="pizza-section" id="allPizzasSection">
    <h2 class="section-title">Our Menu</h2>

    @foreach($pizzas as $pizza)
    <article class="pizza-card" data-category="{{ $pizza->category }}">
        <div class="pizza-image-container">
            <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="pizza-image" loading="lazy">
            @if(!$pizza->is_available)
            <span class="pizza-badge" style="background: var(--primary-red);">
                <i class="fas fa-ban"></i> Unavailable
            </span>
            @elseif($pizza->is_featured)
            <span class="pizza-badge">
                <i class="fas fa-star"></i> Featured
            </span>
            @endif
        </div>
        <div class="pizza-info">
            <span class="pizza-category">{{ ucfirst($pizza->category) }}</span>
            <h3 class="pizza-name">{{ $pizza->name }}</h3>
            <p class="pizza-description">{{ $pizza->description }}</p>

            <div class="pizza-ingredients">
                @foreach($pizza->ingredients as $ingredient)
                <span class="ingredient-tag">{{ $ingredient }}</span>
                @endforeach
            </div>

            <!-- Size Selector -->
            <div class="size-selector" data-pizza-id="{{ $pizza->id }}">
                <button class="size-option" data-size="small" data-multiplier="0.8">
                    <span class="size-name">Small</span>
                    <span class="size-price">₱{{ number_format($pizza->price * 0.8, 2) }}</span>
                </button>
                <button class="size-option active" data-size="medium" data-multiplier="1">
                    <span class="size-name">Medium</span>
                    <span class="size-price">₱{{ number_format($pizza->price, 2) }}</span>
                </button>
                <button class="size-option" data-size="large" data-multiplier="1.3">
                    <span class="size-name">Large</span>
                    <span class="size-price">₱{{ number_format($pizza->price * 1.3, 2) }}</span>
                </button>
            </div>

            <div class="pizza-footer">
                <div class="pizza-price">
                    <span class="currency">₱</span><span class="price-value" id="price-{{ $pizza->id }}-menu">{{ number_format($pizza->price, 2) }}</span>
                </div>
                <button class="add-to-cart-btn"
                    data-id="{{ $pizza->id }}"
                    data-name="{{ $pizza->name }}"
                    data-price="{{ $pizza->price }}"
                    data-image="{{ $pizza->image_url }}"
                    data-available="{{ $pizza->is_available ? 1 : 0 }}"
                    {{ $pizza->is_available ? '' : 'disabled' }}>
                    <i class="fas fa-plus"></i>
                    <span>{{ $pizza->is_available ? 'Add to Cart' : 'Unavailable' }}</span>
                </button>
            </div>
        </div>
    </article>
    @endforeach
</section>
@endsection

@section('scripts')
<script>
    // Category filtering
    document.querySelectorAll('.category-pill').forEach(pill => {
        pill.addEventListener('click', () => {
            // Update active state
            document.querySelectorAll('.category-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');

            const category = pill.dataset.category;
            const cards = document.querySelectorAll('.pizza-card');

            cards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Size selection
    document.querySelectorAll('.size-selector').forEach(selector => {
        const options = selector.querySelectorAll('.size-option');
        const card = selector.closest('.pizza-card');
        const addBtn = card.querySelector('.add-to-cart-btn');
        const basePrice = parseFloat(addBtn.dataset.price);

        options.forEach(option => {
            option.addEventListener('click', () => {
                options.forEach(o => o.classList.remove('active'));
                option.classList.add('active');

                const multiplier = parseFloat(option.dataset.multiplier);
                const newPrice = (basePrice * multiplier).toFixed(2);

                // Update displayed price
                const priceElement = card.querySelector('.price-value');
                if (priceElement) {
                    priceElement.textContent = newPrice;
                }
            });
        });
    });

    // Add to cart
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.pizza-card');
            const activeSize = card.querySelector('.size-option.active');
            const multiplier = parseFloat(activeSize.dataset.multiplier);
            const basePrice = parseFloat(btn.dataset.price);

            const pizza = {
                id: btn.dataset.id,
                name: btn.dataset.name,
                price: basePrice * multiplier,
                image: btn.dataset.image,
                size: activeSize.dataset.size,
                quantity: 1
            };

            addToCart(pizza);

            // Button animation
            btn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btn.style.transform = '';
            }, 150);
        });
    });
</script>
@endsection