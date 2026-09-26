<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FreshMart - Supermarket & Grocery Store')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --secondary: #6366f1;
            --dark: #0f172a;
            --gray-light: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #334155;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            color: var(--primary-dark) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand i {
            color: var(--primary);
            font-size: 1.75rem;
        }

        .nav-link {
            font-weight: 600;
            color: #475569;
            padding: 0.5rem 1rem !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-dark) !important;
        }

        .btn-fresh {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.6rem 1.4rem;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-fresh:hover {
            background-color: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-outline-fresh {
            color: var(--primary-dark);
            border: 1.5px solid var(--primary);
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.5rem 1.25rem;
            background: transparent;
            transition: all 0.2s ease;
        }

        .btn-outline-fresh:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background-color: #ef4444;
            color: white;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.2rem 0.45rem;
            border-radius: 9999px;
        }

        .product-card {
            border: 1px solid var(--border-color);
            border-radius: 16px;
            background: white;
            overflow: hidden;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .product-img-wrap {
            height: 190px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .product-img-wrap img {
            max-height: 85%;
            max-width: 85%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-img-wrap img {
            transform: scale(1.05);
        }

        .badge-stock {
            position: absolute;
            top: 12px;
            left: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.3rem 0.65rem;
            border-radius: 8px;
        }

        .badge-category {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .price-tag {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
        }

        .footer {
            background-color: #0f172a;
            color: #94a3b8;
            margin-top: auto;
            border-top: 1px solid #1e293b;
        }

        .footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: var(--primary);
        }

        .top-announcement {
            background: linear-gradient(90deg, #059669, #10b981);
            color: white;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.4rem 0;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-announcement text-center">
        <div class="container d-flex justify-content-between align-items-center">
            <span><i class="bi bi-truck me-1"></i> Free express grocery delivery on orders over $35!</span>
            <div class="d-none d-md-flex gap-3 align-items-center">
                <span><i class="bi bi-clock me-1"></i> Open Daily: 7:00 AM - 10:00 PM</span>
                <span class="text-white-50">|</span>
                <a href="{{ route('staff.login') }}" class="text-white text-decoration-none fw-semibold">
                    <i class="bi bi-shield-lock me-1"></i> Staff Portal
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-basket2-fill"></i>
                <span>Fresh<span style="color: #0f172a;">Mart</span></span>
            </a>

            <!-- Search Form on Large Screens -->
            <form action="{{ route('catalog') }}" method="GET" class="d-none d-lg-flex mx-4 flex-grow-1" style="max-width: 480px;">
                <div class="input-group">
                    <input type="text" name="search" class="form-control rounded-start-pill border-end-0 ps-3 bg-light" 
                           placeholder="Search groceries, snacks, drinks, dairy..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary rounded-end-pill border-start-0 bg-light text-muted pe-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#storeNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="storeNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">All Groceries</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <!-- Shopping Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="btn btn-light rounded-circle position-relative p-2" title="Shopping Cart">
                        <i class="bi bi-cart3 fs-5 text-dark"></i>
                        @php
                            $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                        @endphp
                        @if($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- Customer Account Links -->
                    @if(Auth::guard('web')->check())
                        <div class="dropdown">
                            <button class="btn btn-outline-fresh dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ Str::limit(Auth::guard('web')->user()->name, 14) }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                                <li><h6 class="dropdown-header">Customer Account</h6></li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('orders.history') }}">
                                        <i class="bi bi-receipt me-2 text-primary"></i> My Orders
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2">
                                            <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-fresh">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-fresh">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Notifications -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                <div>{{ session('info') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-shield-exclamation me-1"></i> Please check the following:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content Injection -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-basket2-fill text-success"></i> FreshMart Supermarket
                    </h5>
                    <p class="text-muted pe-lg-4">
                        Your trusted neighbourhood supermarket system offering the freshest produce, pantry essentials, dairy, beverages, and daily household goods at unbeatable prices.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('catalog') }}">Browse All Items</a></li>
                        <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                        <li><a href="{{ route('orders.history') }}">Track Orders</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Supermarket Departments</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="{{ route('catalog') }}?category=1">Fresh Bakery & Pastries</a></li>
                        <li><a href="{{ route('catalog') }}?category=2">Beverages & Sodas</a></li>
                        <li><a href="{{ route('catalog') }}?category=3">Farm-Fresh Fruits</a></li>
                        <li><a href="{{ route('catalog') }}?category=4">Milk & Dairy</a></li>
                        <li><a href="{{ route('catalog') }}?category=5">Personal Care</a></li>
                        <li><a href="{{ route('catalog') }}?category=6">K-Beauty Skincare</a></li>
                        <li><a href="{{ route('catalog') }}?category=7">Snacks & Confectionery</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Internal Management</h6>
                    <p class="small text-muted mb-2">Staff members, stock controllers, and system administrators:</p>
                    <a href="{{ route('staff.login') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 mb-3">
                        <i class="bi bi-shield-lock-fill me-1 text-warning"></i> Access Staff Portal
                    </a>
                    <div class="text-muted small">
                        <i class="bi bi-geo-alt me-1 text-success"></i> 100 Sunrise Blvd, Metro City
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small text-muted">
                <div>&copy; {{ date('Y') }} FreshMart SSMS - Supermarket & Store Management System. All rights reserved.</div>
                <div class="d-flex gap-3">
                    <span>Cash on Delivery</span>
                    <span>•</span>
                    <span>Visa / MasterCard</span>
                    <span>•</span>
                    <span>Instant POS Checkout</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
