<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pizzeria - Artisan Pizza Delivery')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-red: #E63946;
            --primary-orange: #F77F00;
            --primary-lightorange: #ffa23f;
            --primary-cream: #FFF8F0;
            --dark-bg: #1A1A2E;
            --dark-surface: #252541;
            --dark-card: #2D2D4A;
            --text-light: #FFFFFF;
            --text-muted: #A0A0B0;
            --accent-gold: #FFD166;
            --success-green: #4CAF50;
            --shadow-soft: 0 10px 40px rgba(0, 0, 0, 0.3);
            --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.4);
            --gradient-warm: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-orange) 100%);
            --gradient-dark: linear-gradient(180deg, var(--dark-bg) 0%, var(--dark-surface) 100%);
            --border-radius: 20px;
            --border-radius-sm: 12px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-dark);
            color: var(--text-light);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }

        body.cart-open {
            overflow: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-orange);
            border-radius: 3px;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 16px 20px;
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition-smooth);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-light);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-warm);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            overflow: hidden;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            background: var(--gradient-warm);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-text-wrap {
            display: flex;
            flex-direction: column;
            line-height: 1.05;
        }

        .logo-overline {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.4px;
        }

        /* Mobile brand sizing */
        @media (max-width: 480px) {
            .header {
                padding: 12px 14px;
            }

            .logo-icon {
                width: 34px;
                height: 34px;
                border-radius: 10px;
            }

            .logo-text {
                font-size: 20px;
            }

            .logo-overline {
                font-size: 11px;
            }
        }

        /* Login Button */
        .login-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--dark-card);
            border: none;
            border-radius: 12px;
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .login-btn:hover {
            background: var(--primary-red);
        }

        .bottom-nav-burger {
            width: 48px;
            height: 48px;
            background: var(--dark-card);
            border: none;
            border-radius: 14px;
            color: var(--text-light);
            font-size: 18px;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: none;
            align-items: center;
            justify-content: center;
        }

        .bottom-nav-burger:hover {
            background: var(--primary-red);
        }

        .bottom-nav-burger.show {
            display: flex;
        }

        /* Hide hamburger button in PC view */
        @media (min-width: 1024px) {
            .bottom-nav-burger {
                display: none !important;
            }
        }

        /* Mobile header/footer cleanup */
        @media (max-width: 768px) {

            /* Header actions are redundant on mobile (bottom nav already has these) */
            .header-actions .login-btn,
            .header-actions .cart-btn {
                display: none;
            }

            /* Mobile bottom nav with labels */
            .bottom-nav {
                height: 64px;
                padding: 4px 10px;
            }

            .nav-item {
                padding: 4px 0;
                gap: 2px;
                font-size: 10px;
            }

            .nav-item i {
                font-size: 18px;
            }

            .nav-item span {
                display: block;
                font-size: 10px;
            }
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            position: relative;
            width: 48px;
            height: 48px;
            background: var(--dark-card);
            border: none;
            border-radius: 14px;
            color: var(--text-light);
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            overflow: hidden;
        }

        .user-btn:hover {
            background: var(--primary-red);
            transform: scale(1.05);
        }

        .user-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .user-avatar-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient-warm);
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-menu-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            min-width: 200px;
            background: var(--dark-card);
            border-radius: 12px;
            box-shadow: var(--shadow-card);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition-smooth);
            z-index: 1001;
            overflow: hidden;
        }

        .user-menu-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 14px;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
            color: var(--text-muted);
        }

        .cart-btn {
            position: relative;
            width: 48px;
            height: 48px;
            background: var(--dark-card);
            border: none;
            border-radius: 14px;
            color: var(--text-light);
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-btn:hover {
            background: var(--primary-red);
            transform: scale(1.05);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 22px;
            height: 22px;
            background: var(--gradient-warm);
            border-radius: 50%;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0);
            transition: var(--transition-smooth);
        }

        .cart-badge.show {
            opacity: 1;
            transform: scale(1);
        }

        /* Mobile bottom-nav badge: text only (no circle) */
        @media (max-width: 768px) {
            #cartBadgeMobile.cart-badge {
                top: -6px;
                right: -10px;
                background: transparent;
                width: auto;
                height: auto;
                border-radius: 0;
                padding: 0;
                color: var(--primary-lightorange);
                font-size: 15px;
                font-weight: 800;
                line-height: 1;
                display: inline-flex;
                filter: drop-shadow(0 0 4px var(--primary-orange));
                pointer-events: none;
            }
        }

        /* Cart badge for PC view (matches mobile style) */
        .cart-badge-pc {
            position: absolute;
            top: -8px;
            right: -10px;
            width: 18px;
            height: 18px;
            font-size: 11px;
            background: var(--gradient-warm);
            color: var(--text-light);
            border-radius: 50%;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0);
            transition: var(--transition-smooth);
        }

        .cart-badge-pc.show {
            opacity: 1;
            transform: scale(1);
        }

        /* Search Bar Styles */
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input-wrap {
            display: flex;
            align-items: center;
            background: var(--dark-card);
            border-radius: 12px;
            overflow: hidden;
            transition: var(--transition-smooth);
        }

        .search-input {
            width: 180px;
            padding: 10px 14px;
            background: transparent;
            border: none;
            color: var(--text-light);
            font-size: 14px;
            outline: none;
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .search-input-wrap:focus-within {
            box-shadow: 0 0 0 2px var(--primary-orange);
        }

        .search-btn {
            width: 40px;
            height: 40px;
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
        }

        .search-btn:hover {
            color: var(--primary-orange);
        }

        /* Mobile Search Bar - appears below header */
        .mobile-search-bar {
            position: fixed;
            top: 73px;
            left: 0;
            right: 0;
            padding: 12px 16px;
            background: rgba(26, 26, 46, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 999;
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        @media (max-width: 480px) {
            .mobile-search-bar {
                top: 58px;
            }
        }

        .mobile-search-bar.open {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .mobile-search-input {
            width: 100%;
            padding: 14px 16px;
            background: var(--dark-card);
            border: none;
            border-radius: 12px;
            color: var(--text-light);
            font-size: 16px;
            outline: none;
        }

        .mobile-search-input::placeholder {
            color: var(--text-muted);
        }

        .mobile-search-input:focus {
            box-shadow: 0 0 0 2px var(--primary-orange);
        }

        /* Desktop: show inline search, Mobile: hide inline, show mobile search bar */
        @media (max-width: 768px) {
            .search-container {
                display: none;
            }
        }

        @media (min-width: 769px) {
            .mobile-search-bar {
                display: none !important;
            }
        }

        /* Main Content */
        .main-content {
            padding-top: 80px;
            padding-bottom: 80px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Hero Section */
        .hero {
            padding: 40px 20px 30px;
            text-align: center;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 8vw, 3.5rem);
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .hero-title span {
            background: var(--gradient-warm);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            color: var(--text-muted);
            font-size: 16px;
            font-weight: 300;
            max-width: 300px;
            margin: 0 auto;
        }

        /* Category Pills */
        .category-pills {
            display: flex;
            gap: 10px;
            padding: 0 20px 20px;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .category-pills::-webkit-scrollbar {
            display: none;
        }

        .category-pill {
            flex-shrink: 0;
            padding: 10px 20px;
            background: var(--dark-card);
            border: none;
            border-radius: 25px;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition-smooth);
            white-space: nowrap;
        }

        .category-pill:hover,
        .category-pill.active {
            background: var(--gradient-warm);
            color: var(--text-light);
            transform: translateY(-2px);
        }

        /* Pizza Cards Container */
        .pizza-section {
            padding: 0 20px 100px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--gradient-warm);
            border-radius: 2px;
        }

        /* Pizza Card - Mobile First */
        .pizza-card {
            background: var(--dark-card);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: var(--shadow-card);
            opacity: 0;
            transform: translateY(30px);
            transition: var(--transition-smooth);
        }

        .pizza-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .pizza-card:active {
            transform: scale(0.98);
        }

        .pizza-image-container {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
        }

        .pizza-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .pizza-card:hover .pizza-image {
            transform: scale(1.05);
        }

        .pizza-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            padding: 6px 14px;
            background: var(--gradient-warm);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .pizza-info {
            padding: 24px;
        }

        .pizza-category {
            color: var(--primary-orange);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .pizza-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .pizza-description {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .pizza-ingredients {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .ingredient-tag {
            padding: 6px 12px;
            background: rgba(247, 127, 0, 0.15);
            border-radius: 20px;
            font-size: 11px;
            color: var(--primary-orange);
            font-weight: 500;
        }

        .pizza-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .pizza-price {
            font-size: 28px;
            font-weight: 700;
        }

        .pizza-price .currency {
            font-size: 16px;
            color: var(--text-muted);
            font-weight: 400;
        }

        .add-to-cart-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 24px;
            background: var(--gradient-warm);
            border: none;
            border-radius: 14px;
            color: var(--text-light);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(230, 57, 70, 0.4);
        }

        .add-to-cart-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            background: var(--dark-card);
        }

        .add-to-cart-btn:active {
            transform: scale(0.95);
        }

        .add-to-cart-btn i {
            font-size: 16px;
        }

        /* Size Selector */
        .size-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .size-option {
            flex: 1;
            padding: 12px;
            background: var(--dark-surface);
            border: 2px solid transparent;
            border-radius: var(--border-radius-sm);
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-align: center;
        }

        .size-option:hover {
            border-color: var(--primary-orange);
            color: var(--text-light);
        }

        .size-option.active {
            border-color: var(--primary-orange);
            background: rgba(247, 127, 0, 0.15);
            color: var(--primary-orange);
        }

        .size-option .size-name {
            display: block;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .size-option .size-price {
            font-size: 11px;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px 20px 10px;
            background: rgba(26, 26, 46, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 1900;
            transition: transform 0.25s ease;
            will-change: transform;
            pointer-events: auto;
        }

        .bottom-nav.bottom-nav--hidden {
            transform: translateY(110%);
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 8px 16px;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 12px;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            position: relative;
            z-index: 1;
            pointer-events: auto;
        }

        .nav-item i {
            font-size: 22px;
        }

        .nav-item:hover,
        .nav-item.active {
            color: var(--primary-orange);
        }

        .nav-item.active i {
            transform: scale(1.1);
        }

        /* Cart Slide Up Panel */
        .cart-panel {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            max-height: 80vh;
            background: var(--dark-surface);
            border-radius: 24px 24px 0 0;
            padding: 24px 20px;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2000;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
            pointer-events: none;
        }

        .cart-panel.open {
            transform: translateY(0);
            pointer-events: auto;
            touch-action: pan-y;
        }

        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition-smooth);
            z-index: 1999;
            pointer-events: none;
        }

        .cart-overlay.open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .cart-handle {
            width: 40px;
            height: 4px;
            background: var(--text-muted);
            border-radius: 2px;
            margin: 0 auto 20px;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .cart-title {
            font-size: 22px;
            font-weight: 700;
        }

        .cart-close {
            width: 40px;
            height: 40px;
            background: var(--dark-card);
            border: none;
            border-radius: 12px;
            color: var(--text-light);
            font-size: 18px;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .cart-close:hover {
            background: var(--primary-red);
        }

        .cart-items {
            margin-bottom: 24px;
        }

        .cart-item {
            display: flex;
            gap: 16px;
            padding: 16px;
            background: var(--dark-card);
            border-radius: var(--border-radius-sm);
            margin-bottom: 12px;
        }

        .cart-item-image {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .cart-item-size {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .cart-item-price {
            font-weight: 600;
            color: var(--primary-orange);
        }

        .cart-item-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
        }

        .cart-item-remove {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            transition: var(--transition-smooth);
        }

        .cart-item-remove:hover {
            color: var(--primary-red);
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--dark-surface);
            border-radius: 10px;
            padding: 6px;
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            background: var(--dark-card);
            border: none;
            border-radius: 8px;
            color: var(--text-light);
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .quantity-btn:hover {
            background: var(--primary-orange);
        }

        .quantity-value {
            font-weight: 600;
            min-width: 20px;
            text-align: center;
        }

        .cart-summary {
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .cart-summary-row.total {
            font-size: 18px;
            font-weight: 700;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .checkout-btn {
            width: 100%;
            padding: 18px;
            background: var(--gradient-warm);
            border: none;
            border-radius: 14px;
            color: var(--text-light);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(230, 57, 70, 0.4);
        }

        /* Empty Cart */
        .cart-empty {
            text-align: center;
            padding: 40px 20px;
        }

        .cart-empty i {
            font-size: 60px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .cart-empty h3 {
            margin-bottom: 10px;
        }

        .cart-empty p {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            padding: 16px 24px;
            background: var(--dark-card);
            border-radius: 14px;
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 3000;
            opacity: 0;
            transition: var(--transition-smooth);
            pointer-events: none;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .toast-icon {
            width: 36px;
            height: 36px;
            background: var(--success-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .toast-message {
            font-weight: 500;
        }

        /* Responsive - Tablet */
        @media (min-width: 640px) {
            .pizza-section {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }

            .section-title {
                grid-column: span 2;
            }

            .pizza-card {
                margin-bottom: 0;
            }

            .hero-subtitle {
                max-width: 400px;
            }
        }

        /* Responsive - Desktop */
        @media (min-width: 1024px) {
            .pizza-section {
                max-width: 1200px;
                margin: 0 auto;
                grid-template-columns: repeat(3, 1fr);
                padding: 0 40px 100px;
            }

            .section-title {
                grid-column: span 3;
            }

            .hero {
                padding: 60px 40px 40px;
            }

            .category-pills {
                justify-content: center;
                padding: 0 40px 30px;
            }

            .bottom-nav {
                display: none;
            }

            .header-content {
                padding: 0 20px;
            }

            .cart-panel {
                right: 20px;
                left: auto;
                width: 420px;
                border-radius: 24px;
                bottom: 20px;
                max-height: calc(100vh - 120px);
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease forwards;
        }

        .animate-pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        .delay-4 {
            animation-delay: 0.4s;
        }

        .delay-5 {
            animation-delay: 0.5s;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="{{ route('shop.index') }}" class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('image/logo.jfif') }}" alt="Logo">
                </div>
                <span class="logo-text-wrap">
                    <span class="logo-overline">Eliseo's</span>
                    <span class="logo-text">Pizzeria</span>
                </span>
            </a>
            <div class="header-actions" style="display: flex; align-items: center; gap: 12px;">
                <!-- Desktop Search Bar -->
                <div class="search-container">
                    <div class="search-input-wrap">
                        <input type="text" class="search-input" id="desktopSearch" placeholder="Search pizzas...">
                        <button class="search-btn" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                @auth
                <div class="user-dropdown">
                    <button class="user-btn" id="userToggle">
                        @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="user-avatar">
                        @else
                        <div class="user-avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        @endif
                    </button>
                    <div class="user-menu-dropdown" id="userMenu">
                        <div style="padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <div style="font-weight: 600;">{{ auth()->user()->name }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">{{ auth()->user()->email }}</div>
                        </div>
                        <a href="{{ route('orders.index') }}" class="dropdown-item">
                            <i class="fas fa-receipt"></i> My Orders
                        </a>
                        @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                            <i class="fas fa-cog"></i> Admin Dashboard
                        </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left; color: var(--primary-red);">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="login-btn">
                    <i class="fas fa-user"></i>
                    <span>Sign In</span>
                </a>
                @endauth
                <button class="cart-btn" id="cartToggle">
                    <i class="fas fa-shopping-bag" style="position:relative;">
                        <span class="cart-badge cart-badge-pc" id="cartBadge">0</span>
                    </i>
                </button>

                <button class="bottom-nav-burger" id="bottomNavBurger" type="button" aria-label="Show navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Search Bar (appears below header on mobile) -->
    <div class="mobile-search-bar" id="mobileSearchBar">
        <input type="text" class="mobile-search-input" id="mobileSearch" placeholder="Search pizzas...">
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Bottom Navigation (Mobile) -->
    <nav class="bottom-nav">
        <a href="{{ route('shop.index') }}" class="nav-item {{ request()->routeIs('shop.index') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <button type="button" class="nav-item" id="searchNav">
            <i class="fas fa-search"></i>
            <span>Search</span>
        </button>
        <button type="button" class="nav-item" id="cartNav">
            <i class="fas fa-shopping-bag" style="position:relative;">
                <span class="cart-badge" id="cartBadgeMobile">0</span>
            </i>
            <span>Cart</span>
        </button>
        @auth
        <a href="{{ route('orders.index') }}" class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>Orders</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="nav-item">
            <i class="fas fa-user"></i>
            <span>Sign In</span>
        </a>
        @endauth
    </nav>

    <!-- Cart Overlay -->
    <div class="cart-overlay" id="cartOverlay"></div>

    <!-- Cart Panel -->
    <div class="cart-panel" id="cartPanel">
        <div class="cart-handle"></div>
        <div class="cart-header">
            <h2 class="cart-title">Your Cart</h2>
            <button class="cart-close" id="cartClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-content" id="cartContent">
            <!-- Cart items will be rendered here -->
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <div class="toast-icon">
            <i class="fas fa-check"></i>
        </div>
        <span class="toast-message" id="toastMessage">Added to cart!</span>
    </div>

    <script>
        // Cart State
        let cart = JSON.parse(localStorage.getItem('pizzaCart')) || [];

        // DOM Elements
        const cartToggle = document.getElementById('cartToggle');
        const cartNav = document.getElementById('cartNav');
        const cartPanel = document.getElementById('cartPanel');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartClose = document.getElementById('cartClose');
        const cartContent = document.getElementById('cartContent');
        const cartBadge = document.getElementById('cartBadge');
        const cartBadgeMobile = document.getElementById('cartBadgeMobile');
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');

        // Single-tap handler helper
        // (Fixes mobile issue where one tap triggers both `touchend` and `click`, canceling toggles.)
        function onTap(el, handler) {
            if (!el) return;
            if (window.PointerEvent) {
                el.addEventListener('pointerup', handler);
            } else {
                el.addEventListener('click', handler);
            }
        }

        function isMobileLayout() {
            return window.matchMedia && window.matchMedia('(max-width: 1023px)').matches;
        }

        let lockedScrollY = 0;

        function lockPageScroll() {
            lockedScrollY = window.scrollY || 0;
            document.body.classList.add('cart-open');
            document.body.style.position = 'fixed';
            document.body.style.top = `-${lockedScrollY}px`;
            document.body.style.left = '0';
            document.body.style.right = '0';
            document.body.style.width = '100%';
        }

        function unlockPageScroll() {
            document.body.classList.remove('cart-open');
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.left = '';
            document.body.style.right = '';
            document.body.style.width = '';
            window.scrollTo(0, lockedScrollY);
        }

        // Toggle Cart
        function toggleCart(forceState) {
            const shouldOpen = typeof forceState === 'boolean' ? forceState : !cartPanel.classList.contains('open');
            cartPanel.classList.toggle('open', shouldOpen);
            cartOverlay.classList.toggle('open', shouldOpen);

            // Mobile: lock background scroll and focus cart until click outside
            if (isMobileLayout()) {
                if (shouldOpen) {
                    lockPageScroll();
                    cartPanel.setAttribute('tabindex', '-1');
                    try {
                        cartPanel.focus({
                            preventScroll: true
                        });
                    } catch (err) {
                        cartPanel.focus();
                    }
                } else {
                    unlockPageScroll();
                }
            }

            renderCart();
        }

        function handleCartToggle(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleCart();
        }

        onTap(cartToggle, handleCartToggle);
        onTap(cartNav, handleCartToggle);
        onTap(cartClose, handleCartToggle);
        onTap(cartOverlay, (e) => {
            e.preventDefault();
            e.stopPropagation();
            toggleCart(false);
        });

        // Mobile Search Bar Handling
        const searchNav = document.getElementById('searchNav');
        const mobileSearchBar = document.getElementById('mobileSearchBar');
        const mobileSearchInput = document.getElementById('mobileSearch');
        const desktopSearch = document.getElementById('desktopSearch');

        function toggleMobileSearch(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            if (mobileSearchBar) {
                const isOpen = mobileSearchBar.classList.toggle('open');
                if (isOpen && mobileSearchInput) {
                    setTimeout(() => mobileSearchInput.focus(), 100);
                }
            }
        }

        function closeMobileSearch() {
            if (mobileSearchBar) {
                mobileSearchBar.classList.remove('open');
            }
        }

        onTap(searchNav, toggleMobileSearch);

        // Close mobile search when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileSearchBar && mobileSearchBar.classList.contains('open')) {
                if (!mobileSearchBar.contains(e.target) && e.target !== searchNav && !searchNav.contains(e.target)) {
                    closeMobileSearch();
                }
            }
        });

        // Search functionality - filter pizza cards
        function filterPizzas(searchTerm) {
            const pizzaCards = document.querySelectorAll('.pizza-card');
            const term = searchTerm.toLowerCase().trim();

            pizzaCards.forEach(card => {
                const name = card.querySelector('.pizza-name')?.textContent.toLowerCase() || '';
                const description = card.querySelector('.pizza-description')?.textContent.toLowerCase() || '';
                const category = card.querySelector('.pizza-category')?.textContent.toLowerCase() || '';
                const ingredients = Array.from(card.querySelectorAll('.ingredient-tag')).map(el => el.textContent.toLowerCase()).join(' ');

                const matches = term === '' ||
                    name.includes(term) ||
                    description.includes(term) ||
                    category.includes(term) ||
                    ingredients.includes(term);

                card.style.display = matches ? '' : 'none';
            });
        }

        // Desktop search input
        if (desktopSearch) {
            desktopSearch.addEventListener('input', (e) => filterPizzas(e.target.value));
        }

        // Mobile search input
        if (mobileSearchInput) {
            mobileSearchInput.addEventListener('input', (e) => filterPizzas(e.target.value));
        }

        // Sync search inputs
        if (desktopSearch && mobileSearchInput) {
            desktopSearch.addEventListener('input', () => {
                mobileSearchInput.value = desktopSearch.value;
            });
            mobileSearchInput.addEventListener('input', () => {
                desktopSearch.value = mobileSearchInput.value;
            });
        }

        // Add to Cart
        function addToCart(pizza) {
            const existingIndex = cart.findIndex(item =>
                item.id === pizza.id && item.size === pizza.size
            );

            if (existingIndex > -1) {
                cart[existingIndex].quantity += pizza.quantity;
            } else {
                cart.push(pizza);
            }

            saveCart();
            updateCartBadge();
            showToast('Added to cart!');
        }

        // Remove from Cart
        function removeFromCart(index) {
            cart.splice(index, 1);
            saveCart();
            updateCartBadge();
            renderCart();
        }

        // Update Quantity
        function updateQuantity(index, delta) {
            cart[index].quantity += delta;
            if (cart[index].quantity <= 0) {
                removeFromCart(index);
            } else {
                saveCart();
                renderCart();
            }
        }

        // Save Cart to LocalStorage
        function saveCart() {
            localStorage.setItem('pizzaCart', JSON.stringify(cart));
        }

        // Update Cart Badge
        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            if (cartBadge) {
                cartBadge.textContent = totalItems;
                if (totalItems > 0) {
                    cartBadge.classList.add('show');
                } else {
                    cartBadge.classList.remove('show');
                }
            }
            if (cartBadgeMobile) {
                cartBadgeMobile.textContent = totalItems;
                if (totalItems > 0) {
                    cartBadgeMobile.classList.add('show');
                } else {
                    cartBadgeMobile.classList.remove('show');
                }
            }
        }

        // Calculate Cart Total
        function getCartTotal() {
            return cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        }

        // Render Cart
        function renderCart() {
            if (cart.length === 0) {
                cartContent.innerHTML = `
                    <div class="cart-empty">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>Your cart is empty</h3>
                        <p>Add some delicious pizzas to get started!</p>
                    </div>
                `;
                return;
            }

            const subtotal = getCartTotal();
            const deliveryFee = 50.00;
            const total = subtotal + deliveryFee;

            cartContent.innerHTML = `
                <div class="cart-items">
                    ${cart.map((item, index) => `
                        <div class="cart-item">
                            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                            <div class="cart-item-info">
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-size">${item.size.charAt(0).toUpperCase() + item.size.slice(1)} Size</div>
                                <div class="cart-item-price">₱${(item.price * item.quantity).toFixed(2)}</div>
                            </div>
                            <div class="cart-item-actions">
                                <button class="cart-item-remove" onclick="removeFromCart(${index})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <div class="quantity-control">
                                    <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="quantity-value">${item.quantity}</span>
                                    <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
                <div class="cart-summary">
                    <div class="cart-summary-row">
                        <span>Subtotal</span>
                        <span>₱${subtotal.toFixed(2)}</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Delivery Fee</span>
                        <span>₱${deliveryFee.toFixed(2)}</span>
                    </div>
                    <div class="cart-summary-row total">
                        <span>Total</span>
                        <span>₱${total.toFixed(2)}</span>
                    </div>
                </div>
                <a href="{{ route('shop.checkout') }}" class="checkout-btn">
                    <span>Proceed to Checkout</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            `;
        }

        // Show Toast
        function showToast(message) {
            toastMessage.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 2500);
        }

        // Intersection Observer for scroll animations
        function setupScrollAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.pizza-card').forEach(card => {
                observer.observe(card);
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            updateCartBadge();
            setupScrollAnimations();

            // Hide bottom nav on scroll down, show on scroll up
            const bottomNav = document.querySelector('.bottom-nav');
            const bottomNavBurger = document.getElementById('bottomNavBurger');
            if (bottomNav) {
                let lastScrollY = window.scrollY || 0;
                let ticking = false;
                let isHidden = false;
                let lastDirection = 0; // 1 down, -1 up
                let accumulated = 0;
                let lastToggleAt = 0;

                const HIDE_THRESHOLD_PX = 70;
                const SHOW_THRESHOLD_PX = 140;
                const TOGGLE_COOLDOWN_MS = 250;

                const setBottomNavHidden = (hidden) => {
                    if (hidden) {
                        bottomNav.classList.add('bottom-nav--hidden');
                        isHidden = true;
                        if (bottomNavBurger) bottomNavBurger.classList.add('show');
                    } else {
                        bottomNav.classList.remove('bottom-nav--hidden');
                        isHidden = false;
                        if (bottomNavBurger) bottomNavBurger.classList.remove('show');
                    }
                };

                const updateBottomNav = () => {
                    const currentScrollY = window.scrollY || 0;
                    const delta = currentScrollY - lastScrollY;

                    // Ignore tiny movements (touch jitter)
                    if (Math.abs(delta) < 12) {
                        lastScrollY = currentScrollY;
                        return;
                    }

                    const direction = delta > 0 ? 1 : -1;

                    if (direction !== lastDirection) {
                        accumulated = 0;
                        lastDirection = direction;
                    }

                    accumulated += Math.abs(delta);

                    // Always show when at top
                    if (currentScrollY <= 0) {
                        setBottomNavHidden(false);
                        accumulated = 0;
                        lastScrollY = currentScrollY;
                        return;
                    }

                    const now = Date.now();
                    if (now - lastToggleAt < TOGGLE_COOLDOWN_MS) {
                        lastScrollY = currentScrollY;
                        return;
                    }

                    if (!isHidden && direction === 1 && accumulated >= HIDE_THRESHOLD_PX) {
                        setBottomNavHidden(true);
                        accumulated = 0;
                        lastToggleAt = now;
                    } else if (isHidden && direction === -1 && accumulated >= SHOW_THRESHOLD_PX) {
                        setBottomNavHidden(false);
                        accumulated = 0;
                        lastToggleAt = now;
                    }

                    lastScrollY = currentScrollY;
                };

                window.addEventListener('scroll', () => {
                    if (ticking) return;
                    ticking = true;
                    window.requestAnimationFrame(() => {
                        updateBottomNav();
                        ticking = false;
                    });
                }, {
                    passive: true
                });

                if (bottomNavBurger) {
                    bottomNavBurger.addEventListener('click', () => {
                        setBottomNavHidden(false);
                        accumulated = 0;
                        lastDirection = 0;
                        lastToggleAt = Date.now();
                    });
                }
            }

            // User dropdown toggle
            const userToggle = document.getElementById('userToggle');
            const userMenu = document.getElementById('userMenu');

            if (userToggle && userMenu) {
                userToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenu.classList.toggle('show');
                });

                document.addEventListener('click', (e) => {
                    if (!userMenu.contains(e.target) && !userToggle.contains(e.target)) {
                        userMenu.classList.remove('show');
                    }
                });
            }
        });

        // Touch swipe handling for cart panel
        let touchStartY = 0;
        let touchEndY = 0;

        cartPanel.addEventListener('touchstart', (e) => {
            touchStartY = e.changedTouches[0].screenY;
        });

        cartPanel.addEventListener('touchend', (e) => {
            touchEndY = e.changedTouches[0].screenY;
            if (touchEndY - touchStartY > 100) {
                toggleCart();
            }
        });
    </script>

    @yield('scripts')
</body>

</html>