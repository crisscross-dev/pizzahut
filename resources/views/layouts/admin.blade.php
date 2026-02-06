<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | Pizzeria Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #E63946;
            --primary-light: #FF6B6B;
            --secondary: #F77F00;
            --dark: #1A1A2E;
            --dark-light: #252541;
            --dark-card: #2D2D4A;
            --text: #FFFFFF;
            --text-muted: #A0A0B0;
            --success: #4CAF50;
            --warning: #FFC107;
            --danger: #DC3545;
            --info: #17A2B8;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: var(--text);
            min-height: 100vh;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--dark-light);
            padding: 20px 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .sidebar-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-header {
            padding: 0 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 20px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text);
        }

        .sidebar-logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            overflow: hidden;
        }

        .sidebar-logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .sidebar-logo-text {
            font-size: 22px;
            font-weight: 700;
        }

        .sidebar-logo-text span {
            color: var(--secondary);
        }

        .sidebar-logo-text-wrap {
            display: flex;
            flex-direction: column;
            line-height: 1.05;
        }

        .sidebar-overline {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.4px;
        }

        .sidebar-logo-text {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-section {
            padding: 0 15px;
            margin-bottom: 25px;
        }

        .nav-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            padding: 0 10px;
            margin-bottom: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--text);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .nav-link .badge {
            margin-left: auto;
            background: var(--primary);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: var(--dark-card);
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        @media (min-width: 769px) {
            .header.header-hide-desktop {
                display: none;
            }
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
        }

        .header-title h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .header-title p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 4px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-brand {
            display: none;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text);
        }

        .header-brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .header-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .header-brand-text-wrap {
            display: flex;
            flex-direction: column;
            line-height: 1.05;
        }

        .header-brand-overline {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.4px;
        }

        .header-brand-text {
            font-size: 18px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            background: var(--dark-light);
            border-radius: 12px;
            cursor: pointer;
            border: 0;
            color: inherit;
            font: inherit;
        }

        .user-menu:focus {
            outline: none;
        }

        .user-menu:focus-visible {
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.35);
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 220px;
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 8px;
            z-index: 1100;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity 0.15s ease, transform 0.15s ease, visibility 0.15s ease;
        }

        .user-dropdown.open .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-dropdown-item {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            color: var(--text);
            text-decoration: none;
            background: transparent;
            border: 0;
            cursor: pointer;
            text-align: left;
            font: inherit;
        }

        .user-dropdown-item i {
            width: 18px;
            text-align: center;
            color: var(--text-muted);
        }

        .user-dropdown-item:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .user-dropdown-item.danger {
            color: #FF7A86;
        }

        .user-dropdown-item.danger i {
            color: #FF7A86;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 500;
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        /* Cards */
        .card {
            background: var(--dark-card);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
        }

        .stat-card.stat-emphasis {
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .stat-card.stat-emphasis .stat-info h3 {
            font-size: 32px;
            letter-spacing: -0.5px;
        }

        .dashboard-mobile-only {
            display: none;
        }

        .dashboard-desktop-only {
            display: block;
        }

        .dashboard-order-card {
            display: block;
            text-decoration: none;
            color: var(--text);
            background: var(--dark-light);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
            transition: all 0.2s;
        }

        .dashboard-order-card:hover {
            transform: translateY(-1px);
        }

        .dashboard-order-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .dashboard-order-number {
            font-weight: 700;
            color: var(--primary);
        }

        .dashboard-order-meta {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
        }

        .dashboard-order-customer {
            font-weight: 600;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 70%;
        }

        .dashboard-order-total {
            font-weight: 700;
        }

        .dashboard-order-time {
            margin-top: 6px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .dashboard-top-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .dashboard-top-item {
            background: var(--dark-light);
            border-radius: 14px;
            padding: 14px;
        }

        .dashboard-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .dashboard-top-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .dashboard-top-name {
            font-weight: 700;
            line-height: 1.2;
        }

        .dashboard-top-sub {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .dashboard-top-badge {
            background: rgba(247, 127, 0, 0.15);
            color: var(--secondary);
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 12px;
            flex-shrink: 0;
        }

        .dashboard-top-bar {
            margin-top: 10px;
            height: 8px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 999px;
            overflow: hidden;
        }

        .dashboard-top-bar-fill {
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 999px;
            width: calc(var(--pct, 0) * 1%);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--dark-card);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .stat-icon.green {
            background: rgba(76, 175, 80, 0.15);
            color: #4CAF50;
        }

        .stat-icon.blue {
            background: rgba(23, 162, 184, 0.15);
            color: #17A2B8;
        }

        .stat-icon.orange {
            background: rgba(247, 127, 0, 0.15);
            color: #F77F00;
        }

        .stat-icon.red {
            background: rgba(230, 57, 70, 0.15);
            color: #E63946;
        }

        .stat-icon.purple {
            background: rgba(156, 39, 176, 0.15);
            color: #9C27B0;
        }

        .stat-info h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-info p {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .admin-mobile-only {
            display: none;
        }

        .admin-desktop-only {
            display: block;
        }

        .admin-order-card {
            background: var(--dark-light);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
        }

        .admin-order-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .admin-order-card-number {
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
        }

        .admin-order-card-mid {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .admin-order-card-customer {
            font-weight: 700;
            line-height: 1.2;
        }

        .admin-order-card-sub {
            margin-top: 4px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .admin-order-card-total {
            font-weight: 800;
            font-size: 16px;
            white-space: nowrap;
        }

        .admin-order-card-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        th {
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
        }

        td {
            font-size: 14px;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.pending {
            background: rgba(255, 193, 7, 0.15);
            color: #FFC107;
        }

        .status-badge.confirmed {
            background: rgba(23, 162, 184, 0.15);
            color: #17A2B8;
        }

        .status-badge.preparing {
            background: rgba(156, 39, 176, 0.15);
            color: #9C27B0;
        }

        .status-badge.out_for_delivery {
            background: rgba(0, 188, 212, 0.15);
            color: #00BCD4;
        }

        .status-badge.delivered {
            background: rgba(76, 175, 80, 0.15);
            color: #4CAF50;
        }

        .status-badge.completed {
            background: rgba(76, 175, 80, 0.15);
            color: #4CAF50;
        }

        .status-badge.cancelled {
            background: rgba(220, 53, 69, 0.15);
            color: #DC3545;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(230, 57, 70, 0.3);
        }

        .btn-secondary {
            background: var(--dark-light);
            color: var(--text);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-muted);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: var(--text);
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        select.form-control {
            cursor: pointer;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--dark-light);
            border-radius: 26px;
            transition: 0.3s;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
        }

        input:checked+.toggle-slider {
            background: var(--success);
        }

        input:checked+.toggle-slider:before {
            transform: translateX(24px);
        }

        /* Alert */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.15);
            color: #4CAF50;
        }

        .alert-error {
            background: rgba(220, 53, 69, 0.15);
            color: #DC3545;
        }

        .mobile-toggle {
            display: none;
            width: 40px;
            height: 40px;
            background: var(--dark-light);
            border: none;
            border-radius: 10px;
            color: var(--text);
            font-size: 18px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
            }

            .header {
                padding: 16px 18px;
            }

            .header-brand {
                display: flex;
            }

            .content {
                padding: 18px;
            }

            .card {
                padding: 18px;
                border-radius: 14px;
            }

            .stat-card {
                padding: 18px;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .header-left {
                justify-content: flex-start;
            }

            .header-title h1 {
                font-size: 18px;
            }

            .header-title p {
                font-size: 12px;
            }

            .user-menu {
                padding: 8px 12px;
                justify-content: space-between;
            }

            .user-info {
                text-align: left;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .admin-mobile-only {
                display: block;
            }

            .admin-desktop-only {
                display: none;
            }

            .admin-order-card-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .admin-order-card-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .dashboard-mobile-only {
                display: block;
            }

            .dashboard-desktop-only {
                display: none;
            }
        }

        /* Product Image */
        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .action-btn.edit {
            background: rgba(23, 162, 184, 0.15);
            color: #17A2B8;
        }

        .action-btn.delete {
            background: rgba(220, 53, 69, 0.15);
            color: #DC3545;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        /* Grid */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 1024px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <img src="{{ asset('image/logo.jfif') }}" alt="Logo">
                </div>
                <div class="sidebar-logo-text-wrap">
                    <div class="sidebar-overline">Eliseo's</div>
                    <div class="sidebar-logo-text">Pizzeria</div>
                </div>
            </a>
        </div>

        <nav class="nav-section">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                Dashboard
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-section-title">Store</div>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-pizza-slice"></i>
                Products
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i>
                Orders
                @php $pendingCount = \App\Models\Order::whereIn('status', ['pending', 'confirmed', 'preparing'])->count(); @endphp
                @if($pendingCount > 0)
                <span class="badge">{{ $pendingCount }}</span>
                @endif
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-section-title">Reports</div>
            <a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                Sales Report
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-section-title">Other</div>
            <a href="{{ route('shop.index') }}" class="nav-link" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                View Store
            </a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="nav-link" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header {{ !trim($__env->yieldContent('showHeaderDesktop')) ? 'header-hide-desktop' : '' }}">
            <div class="header-left">
                <button class="mobile-toggle" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="header-brand">
                    <div class="header-brand-icon">
                        <img src="{{ asset('image/logo.jfif') }}" alt="Logo">
                    </div>
                    <div class="header-brand-text-wrap">
                        <div class="header-brand-overline">Eliseo's</div>
                        <div class="header-brand-text">Pizzeria</div>
                    </div>
                </a>
                @if(!trim($__env->yieldContent('hideHeaderTitle')))
                <div class="header-title">
                    <h1>@yield('title', 'Dashboard')</h1>
                    <p>@yield('subtitle', 'Welcome to Pizzeria Admin Panel')</p>
                </div>
                @endif
            </div>
            @if(!trim($__env->yieldContent('hideUserMenu')))
            <div class="header-actions">
                <div class="user-dropdown" id="userDropdown">
                    <button class="user-menu" id="userMenuButton" type="button" aria-haspopup="menu" aria-expanded="false">
                        @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="user-avatar">
                        @else
                        <div class="user-avatar" style="background: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 600;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        @endif
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Staff' }}</div>
                        </div>
                        <i class="fas fa-chevron-down" style="color: var(--text-muted);"></i>
                    </button>

                    <div class="user-dropdown-menu" id="userDropdownMenu" role="menu" aria-label="User menu">
                        <a class="user-dropdown-item" href="{{ route('admin.reports.sales') }}" role="menuitem">
                            <i class="fas fa-chart-line"></i>
                            Sales Report
                        </a>
                        <a class="user-dropdown-item" href="{{ route('shop.index') }}" target="_blank" role="menuitem">
                            <i class="fas fa-external-link-alt"></i>
                            View Store
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="user-dropdown-item danger" role="menuitem">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </header>

        <!-- Page Content -->
        <div class="content">
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        // CSRF Token for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Mobile sidebar UX
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const sidebarToggle = document.getElementById('sidebarToggle');

        // User dropdown
        const userDropdown = document.getElementById('userDropdown');
        const userMenuButton = document.getElementById('userMenuButton');

        function closeUserDropdown() {
            if (!userDropdown) return;
            userDropdown.classList.remove('open');
            if (userMenuButton) userMenuButton.setAttribute('aria-expanded', 'false');
        }

        function toggleUserDropdown() {
            if (!userDropdown) return;
            const willOpen = !userDropdown.classList.contains('open');
            userDropdown.classList.toggle('open', willOpen);
            if (userMenuButton) userMenuButton.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        }

        if (userMenuButton) {
            userMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleUserDropdown();
            });
        }

        document.addEventListener('click', (e) => {
            if (!userDropdown) return;
            if (!userDropdown.contains(e.target)) closeUserDropdown();
        });

        function openSidebar() {
            if (!sidebar) return;
            sidebar.classList.add('open');
            if (sidebarBackdrop) sidebarBackdrop.classList.add('show');
            document.body.classList.add('sidebar-open');
        }

        function closeSidebar() {
            if (!sidebar) return;
            sidebar.classList.remove('open');
            if (sidebarBackdrop) sidebarBackdrop.classList.remove('show');
            document.body.classList.remove('sidebar-open');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                if (sidebar && sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }

        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', closeSidebar);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeSidebar();
                closeUserDropdown();
            }
        });

        // Helper for fetch requests
        async function fetchWithCsrf(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            };
            return fetch(url, {
                ...defaultOptions,
                ...options
            });
        }
    </script>

    @yield('scripts')
</body>

</html>