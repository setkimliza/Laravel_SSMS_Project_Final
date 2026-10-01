<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FreshMart - Fresh, Healthy, Everyday.')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #facc15;
            --primary-hover: #eab308;
            --primary-dark: #ca8a04;
            --primary-light: #fefce8;
            --primary-accent: #fde047;
            --dark: #0f172a;
            --slate-600: #475569;
            --slate-500: #64748b;
            --slate-400: #94a3b8;
            --gray-bg: #fffdf2;
            --border-color: #fef08a;
            --border-yellow: #fde047;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #1e293b;
            background-color: var(--gray-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* MindFuel Style Warm Golden Ticker Bar */
        .top-announcement {
            background: linear-gradient(90deg, #facc15 0%, #fbbf24 50%, #facc15 100%);
            color: #0f172a;
            font-size: 0.8125rem;
            font-weight: 700;
            padding: 0.45rem 0;
            border-bottom: 1px solid #eab308;
            letter-spacing: 0.02em;
        }
        .top-announcement a {
            color: #0f172a;
            text-decoration: underline;
            font-weight: 800;
        }
        .top-announcement a:hover {
            color: #854d0e;
        }

        /* Main Header */
        .header-main {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            color: var(--dark);
        }
        .brand-logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #0f172a;
            color: #facc15;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }
        .brand-name {
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: -0.04em;
            line-height: 1.05;
            color: var(--dark);
        }
        .brand-name .brand-accent {
            color: #ca8a04;
        }
        .brand-name .brand-tm {
            font-size: 0.75rem;
            font-weight: 700;
            vertical-align: top;
            color: #64748b;
            margin-left: 2px;
        }
        .brand-tagline {
            font-size: 0.6875rem;
            font-weight: 800;
            color: var(--slate-400);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Search Bar Widget with Category Select (MindFuel Sleek Pill) */
        .header-search-box {
            display: flex;
            align-items: center;
            border: 2px solid #0f172a;
            border-radius: 9999px;
            background: #ffffff;
            overflow: hidden;
            width: 100%;
            max-width: 580px;
            transition: box-shadow 0.15s ease;
        }
        .header-search-box:focus-within {
            box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.45);
        }
        .search-input-field {
            border: none;
            outline: none;
            padding: 0.55rem 1.1rem;
            font-size: 0.875rem;
            flex-grow: 1;
            background: transparent;
        }
        .search-cat-select {
            border: none;
            border-left: 1px solid #e2e8f0;
            outline: none;
            background: #ffffff;
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--slate-600);
            padding: 0.55rem 0.85rem;
            cursor: pointer;
        }
        .search-submit-btn {
            background: #facc15;
            border: none;
            color: #0f172a;
            padding: 0.55rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }
        .search-submit-btn:hover {
            background: #eab308;
        }

        /* Unified Header Action Control Cluster */
        .header-actions-group {
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }
        .header-action-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            height: 42px;
            padding: 0 0.85rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
        }

        /* Account Pill */
        .header-account-pill {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            color: #0f172a;
        }
        .header-account-pill:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(15, 23, 42, 0.05);
            color: #0f172a;
        }
        .header-pill-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            font-weight: 700;
            flex-shrink: 0;
            transition: all 0.15s ease;
        }
        .header-account-pill:hover .header-pill-avatar {
            background: #e2e8f0;
            color: #0f172a;
        }
        .header-pill-avatar.logged-in {
            background: linear-gradient(135deg, #facc15 0%, #ca8a04 100%);
            color: #0f172a;
            font-weight: 900;
            font-size: 0.8rem;
        }

        /* Cart Pill */
        .header-cart-pill {
            background: #fffbeb;
            border: 1.5px solid #fef08a;
            color: #0f172a;
            box-shadow: 0 2px 6px rgba(250, 204, 21, 0.15);
        }
        .header-cart-pill:hover {
            background: #fef08a;
            border-color: #facc15;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(250, 204, 21, 0.3);
            color: #0f172a;
        }
        .header-cart-icon-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #facc15;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            position: relative;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(250, 204, 21, 0.35);
        }
        .header-cart-badge {
            position: absolute;
            top: -5px;
            right: -6px;
            background: #0f172a;
            color: #facc15;
            font-size: 0.65rem;
            font-weight: 900;
            min-width: 17px;
            height: 17px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.18);
        }

        /* Text details inside pills */
        .header-pill-content {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
            text-align: left;
        }
        .header-pill-title {
            font-size: 0.78rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
        }
        .header-pill-subtitle {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
        }
        .header-cart-total {
            color: #b45309;
            font-weight: 800;
        }

        /* Top Shop Now Button */
        .header-shop-now-pill {
            background: #facc15;
            color: #0f172a !important;
            font-weight: 800;
            font-size: 0.8125rem;
            height: 42px;
            padding: 0 1.15rem;
            border-radius: 9999px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border: 1.5px solid #facc15;
            box-shadow: 0 2px 8px rgba(250, 204, 21, 0.35);
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .header-shop-now-pill:hover {
            background: #eab308;
            border-color: #eab308;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.45);
        }

        /* Secondary Sub-Navbar */
        .navbar-sub {
            background: #ffffff;
            border-bottom: 1.5px solid var(--border-color);
            padding: 0.45rem 0;
        }
        .btn-shop-categories {
            background: #0f172a;
            color: #facc15 !important;
            font-weight: 800;
            font-size: 0.875rem;
            border-radius: 9999px;
            padding: 0.55rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1.5px solid #0f172a;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.15);
            transition: all 0.15s ease;
        }
        .btn-shop-categories:hover {
            background: #1e293b;
            color: #ffffff !important;
        }
        .subnav-link {
            font-size: 0.9rem;
            font-weight: 700;
            color: #334155 !important;
            padding: 0.5rem 0.85rem !important;
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .subnav-link:hover, .subnav-link.active {
            color: #ca8a04 !important;
            font-weight: 800;
        }
        .badge-flash-deals {
            background: #fef08a;
            color: #854d0e;
            font-weight: 800;
            font-size: 0.8125rem;
            padding: 0.45rem 1rem;
            border-radius: 9999px;
            border: 1.5px solid #fde047;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 2px 6px rgba(250, 204, 21, 0.2);
            transition: all 0.15s ease;
        }
        .badge-flash-deals:hover {
            background: #fde047;
            color: #713f12;
            transform: translateY(-1px);
        }

        /* Buttons & Utility (MindFuel Yellow & Obsidian Style) */
        .btn-fresh {
            background-color: #facc15;
            color: #0f172a !important;
            font-weight: 800;
            font-size: 0.9375rem;
            border-radius: 9999px;
            padding: 0.6rem 1.5rem;
            border: none;
            box-shadow: 0 4px 12px rgba(250, 204, 21, 0.35);
            transition: all 0.15s ease;
        }
        .btn-fresh:hover {
            background-color: #eab308;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(234, 179, 8, 0.45);
        }
        .btn-outline-fresh {
            color: #0f172a !important;
            background-color: transparent;
            border: 2px solid #facc15;
            font-weight: 800;
            font-size: 0.9375rem;
            border-radius: 9999px;
            padding: 0.55rem 1.35rem;
            transition: all 0.15s ease;
        }
        .btn-outline-fresh:hover {
            background-color: #facc15;
            color: #0f172a !important;
        }

        /* Product Card Standard */
        .product-card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background: #ffffff;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.06);
            border-color: #cbd5e1;
        }
        .product-img-wrap {
            height: 180px;
            background: #fbfcfd;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 1rem;
        }
        .product-img-wrap img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        /* Footer */
        .footer {
            background-color: #0f172a;
            color: #94a3b8;
            margin-top: auto;
            border-top: 1px solid #1e293b;
            font-size: 0.875rem;
        }
        .footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .footer a:hover {
            color: #facc15;
        }

        /* Pagination Theme */
        .page-link {
            color: #0f172a;
            border-color: #fef08a;
        }
        .page-link:hover {
            color: #0f172a;
            background-color: #fefce8;
            border-color: #fde047;
        }
        .page-item.active .page-link {
            background-color: #facc15 !important;
            border-color: #facc15 !important;
            color: #0f172a !important;
            font-weight: 800;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Announcement Bar (MindFuel Golden Ticker) -->
    <div class="top-announcement">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3 overflow-hidden text-nowrap">
                <span>🔥 Free delivery on orders over $25</span>
                <span class="opacity-50">•</span>
                <span>⚡ 30-Min Fast Express Delivery</span>
                <span class="opacity-50">•</span>
                <span>🥤 Chilled Drinks & Fresh Snacks Restocked Daily</span>
                <span class="opacity-50 d-none d-md-inline">•</span>
                <span class="d-none d-md-inline">🏪 Neighborhood Mini Mart Open 7 Days</span>
            </div>
            <div class="d-none d-lg-flex align-items-center gap-3 flex-shrink-0 ms-3">
                <a href="{{ route('staff.login') }}" class="d-flex align-items-center gap-1">
                    <i class="bi bi-shield-lock"></i>
                    <span>Staff Portal</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header Bar -->
    <header class="header-main">
        <div class="container d-flex align-items-center justify-content-between gap-3 flex-wrap flex-lg-nowrap">
            
            <!-- Logo (MindFuel Bold Modern Style) -->
            <a href="{{ route('home') }}" class="header-brand">
                <div class="brand-logo-icon">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div>
                    <div class="brand-name">Fresh<span class="brand-accent">Mart</span><span class="brand-tm">™</span></div>
                    <div class="brand-tagline">Neighborhood Mini Mart</div>
                </div>
            </a>

            <!-- Search Form with Category Selector -->
            @php
                $headerCategories = \App\Models\Category::all();
            @endphp
            <form action="{{ route('catalog') }}" method="GET" class="header-search-box mx-lg-3 flex-grow-1 order-3 order-lg-2 mt-2 mt-lg-0">
                <input type="text" name="search" class="search-input-field" 
                       placeholder="Search snacks, cold drinks, bakery, dairy, personal care..." 
                       value="{{ request('search') }}">
                <select name="category" class="search-cat-select d-none d-sm-block">
                    <option value="">All Aisles</option>
                    @foreach($headerCategories as $hCat)
                        <option value="{{ $hCat->CatID }}" {{ request('category') == $hCat->CatID ? 'selected' : '' }}>
                            {{ $hCat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="search-submit-btn" title="Search">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <!-- Right Action Control Cluster -->
            <div class="header-actions-group order-2 order-lg-3">
                
                <!-- Account Widget -->
                @if(Auth::guard('web')->check())
                    <div class="dropdown">
                        <a href="#" class="header-action-pill header-account-pill dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="header-pill-avatar logged-in">
                                {{ strtoupper(substr(Auth::guard('web')->user()->name, 0, 1)) }}
                            </div>
                            <div class="d-none d-md-flex flex-column header-pill-content">
                                <span class="header-pill-title">{{ Str::limit(Auth::guard('web')->user()->name, 12) }}</span>
                                <span class="header-pill-subtitle">My Account</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border rounded-3 mt-2">
                            <li><h6 class="dropdown-header small text-uppercase fw-bold text-muted" style="letter-spacing: 0.05em; font-size: 0.72rem;">Customer Account</h6></li>
                            <li>
                                <a class="dropdown-item py-2 fw-semibold small" href="{{ route('orders.history') }}">
                                    <i class="bi bi-receipt me-2 text-warning"></i> Order History
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2 fw-semibold small">
                                        <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="header-action-pill header-account-pill">
                        <div class="header-pill-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="d-none d-md-flex flex-column header-pill-content">
                            <span class="header-pill-title">Sign In</span>
                            <span class="header-pill-subtitle">My Account</span>
                        </div>
                    </a>
                @endif

                <!-- Cart Widget -->
                @php
                    $navCart = session('cart', []);
                    $navCartCount = array_sum(array_column($navCart, 'quantity'));
                    $navCartTotal = 0;
                    foreach($navCart as $item) {
                        $navCartTotal += $item['price'] * $item['quantity'];
                    }
                @endphp
                <a href="{{ route('cart.index') }}" class="header-action-pill header-cart-pill">
                    <div class="header-cart-icon-circle">
                        <i class="bi bi-basket2-fill"></i>
                        @if($navCartCount > 0)
                            <span class="header-cart-badge">{{ $navCartCount }}</span>
                        @endif
                    </div>
                    <div class="d-none d-md-flex flex-column header-pill-content">
                        <span class="header-pill-title">My Cart</span>
                        <span class="header-pill-subtitle header-cart-total">${{ number_format($navCartTotal, 2) }}</span>
                    </div>
                </a>

                <!-- Shop Now Button -->
                <a href="{{ route('catalog') }}" class="header-shop-now-pill d-none d-sm-inline-flex">
                    <span>Shop Now</span>
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>
        </div>
    </header>

    <!-- Secondary Navigation Bar -->
    <nav class="navbar-sub sticky-top shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <!-- Shop by Categories Dropdown -->
                <div class="dropdown">
                    <button class="btn-shop-categories dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-lightning-charge-fill text-warning fs-6"></i>
                        <span>Shop Mini Mart</span>
                    </button>
                    <ul class="dropdown-menu shadow border rounded-3 mt-1 py-2" style="min-width: 220px;">
                        @foreach($headerCategories as $hCat)
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2 small fw-medium" href="{{ route('catalog', ['category' => $hCat->CatID]) }}">
                                    <i class="bi {{ $hCat->icon ?: 'bi-bag' }} text-warning"></i>
                                    <span>{{ $hCat->name }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item py-2 fw-bold small text-dark" href="{{ route('catalog') }}">
                                <i class="bi bi-shop me-1 text-warning"></i> Browse All Mini Mart Items
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Nav Links -->
                <div class="d-none d-lg-flex align-items-center gap-1">
                    <a href="{{ route('home') }}" class="subnav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <div class="dropdown">
                        <a href="#" class="subnav-link dropdown-toggle" data-bs-toggle="dropdown">Aisles</a>
                        <ul class="dropdown-menu shadow-sm border rounded-3 mt-1">
                            @foreach($headerCategories as $hCat)
                                <li>
                                    <a class="dropdown-item small" href="{{ route('catalog', ['category' => $hCat->CatID]) }}">
                                        {{ $hCat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{ route('catalog') }}?sort=price_low" class="subnav-link">Deals</a>
                    <a href="{{ route('catalog') }}?category=2" class="subnav-link">Drinks</a>
                    <a href="{{ route('catalog') }}?category=7" class="subnav-link">Snacks</a>
                    <a href="{{ route('catalog') }}?category=1" class="subnav-link">Bakery</a>
                    <a href="{{ route('catalog') }}?category=4" class="subnav-link">Milk & Dairy</a>
                    <a href="{{ route('catalog') }}" class="subnav-link">All Items</a>
                </div>
            </div>

            <!-- Flash Deals Button -->
            <div>
                <a href="{{ route('catalog') }}?in_stock=1" class="badge-flash-deals">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span>FLASH DEALS</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash Notifications -->
    <div class="container mt-2">
        @if(session('success'))
            <div class="alert alert-dismissible fade show rounded-3 d-flex align-items-center gap-2" style="background: #fef9c3; color: #854d0e; border: 1.5px solid #fde047 !important;" role="alert">
                <i class="bi bi-check-circle-fill fs-5" style="color: #ca8a04;"></i>
                <div class="small fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                <div class="small fw-medium">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0" role="alert">
                <div class="fw-bold mb-1 small"><i class="bi bi-shield-exclamation me-1"></i> Please check the following:</div>
                <ul class="mb-0 ps-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content Injection -->
    <main class="pt-2 pb-4">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-logo-icon" style="width: 36px; height: 36px; font-size: 1.2rem;">
                            <i class="bi bi-cart4"></i>
                        </div>
                        <div class="text-white fw-bold fs-5">Fresh<span style="color: #facc15;">Mart</span></div>
                    </div>
                    <p class="text-muted pe-lg-4 small">
                        Your trusted neighbourhood supermarket system offering farm-fresh produce, pantry essentials, dairy, beverages, and daily household goods at unbeatable prices.
                    </p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-2"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-2"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-2"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white small fw-bold text-uppercase mb-3">Quick Links</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('catalog') }}">All Groceries</a></li>
                        <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                        <li><a href="{{ route('orders.history') }}">Track Orders</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white small fw-bold text-uppercase mb-3">Departments</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="{{ route('catalog') }}?category=1">Fresh Bakery</a></li>
                        <li><a href="{{ route('catalog') }}?category=2">Beverages & Drinks</a></li>
                        <li><a href="{{ route('catalog') }}?category=3">Farm Fruits</a></li>
                        <li><a href="{{ route('catalog') }}?category=4">Dairy & Eggs</a></li>
                        <li><a href="{{ route('catalog') }}?category=7">Snacks & Confectionery</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white small fw-bold text-uppercase mb-3">Store Operations</h6>
                    <p class="small text-muted mb-2">Staff members and inventory controllers:</p>
                    <a href="{{ route('staff.login') }}" class="btn btn-sm btn-outline-light rounded-2 px-3 mb-3">
                        <i class="bi bi-shield-lock me-1"></i> Staff Portal
                    </a>
                    <div class="text-muted small">
                        <i class="bi bi-geo-alt me-1 text-success"></i> 100 Sunrise Blvd, Metro City
                    </div>
                </div>
            </div>

            <hr class="border-secondary opacity-25 my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small text-muted">
                <div>&copy; {{ date('Y') }} FreshMart SSMS. All rights reserved.</div>
                <div class="d-flex gap-3">
                    <span>Cash on Delivery</span>
                    <span>•</span>
                    <span>Visa / MasterCard</span>
                    <span>•</span>
                    <span>Direct Bank Transfer</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
