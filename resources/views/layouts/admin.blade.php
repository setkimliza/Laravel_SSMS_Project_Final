<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Console - FreshMart Supermarket')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --sidebar-width: 275px;
            --sidebar-bg: #090d16;
            --sidebar-border: rgba(255, 255, 255, 0.08);
            --sidebar-hover: rgba(255, 255, 255, 0.06);
            --gold: #facc15;
            --gold-hover: #eab308;
            --gold-dark: #ca8a04;
            --gold-light: #fef9c3;
            --dark-surface: #0f172a;
            --bg-canvas: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-canvas);
            color: #1e293b;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Sleek Obsidian Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            color: #94a3b8;
            z-index: 1040;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25);
        }

        /* Custom Scrollbar for Sidebar */
        #sidebar::-webkit-scrollbar {
            width: 5px;
        }
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 9999px;
        }

        .sidebar-brand-header {
            padding: 1.25rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid var(--sidebar-border);
            text-decoration: none;
            background: linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0) 100%);
        }
        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #facc15;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            box-shadow: 0 4px 14px rgba(250, 204, 21, 0.35);
            flex-shrink: 0;
        }
        .sidebar-brand-title {
            font-size: 1.2rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            color: #ffffff;
            line-height: 1.1;
        }
        .sidebar-brand-title span {
            color: #facc15;
        }
        .sidebar-brand-tag {
            font-size: 0.65rem;
            font-weight: 800;
            color: #94a3b8;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* User Profile Status Card in Sidebar */
        .sidebar-user-card {
            margin: 1rem 0.85rem;
            padding: 0.85rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--sidebar-border);
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #facc15 0%, #ca8a04 100%);
            color: #0f172a;
            font-weight: 900;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(250, 204, 21, 0.25);
            flex-shrink: 0;
        }
        .sidebar-user-role-admin {
            background: rgba(250, 204, 21, 0.15);
            color: #fef08a;
            border: 1px solid rgba(250, 204, 21, 0.3);
            font-size: 0.68rem;
            font-weight: 800;
            padding: 0.2rem 0.55rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        .sidebar-user-role-stock {
            background: rgba(14, 165, 233, 0.15);
            color: #7dd3fc;
            border: 1px solid rgba(14, 165, 233, 0.3);
            font-size: 0.68rem;
            font-weight: 800;
            padding: 0.2rem 0.55rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        .status-pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 8px #22c55e;
            display: inline-block;
        }

        /* Nav Section Groupings */
        .sidebar-nav-heading {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 1.15rem 1.25rem 0.4rem;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1rem;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 10px;
            margin: 0.15rem 0.75rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .sidebar-nav-link i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
            color: #64748b;
            transition: color 0.15s ease, transform 0.15s ease;
        }
        .sidebar-nav-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
            transform: translateX(3px);
        }
        .sidebar-nav-link:hover i {
            color: #facc15;
            transform: scale(1.1);
        }
        .sidebar-nav-link.active {
            background: linear-gradient(90deg, rgba(250, 204, 21, 0.16) 0%, rgba(250, 204, 21, 0.02) 100%);
            border-left: 3.5px solid #facc15;
            color: #fef08a !important;
            font-weight: 700;
        }
        .sidebar-nav-link.active i {
            color: #facc15 !important;
        }
        .sidebar-badge-count {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 0.15rem 0.55rem;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-badge-count.badge-warning-glow {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border-color: rgba(245, 158, 11, 0.4);
        }

        /* Main Content Layout */
        #content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* Glassmorphic Top Navbar */
        .top-navbar {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        .btn-live-storefront {
            background: #0f172a;
            color: #facc15 !important;
            font-weight: 700;
            font-size: 0.8125rem;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
            transition: all 0.15s ease;
        }
        .btn-live-storefront:hover {
            background: #1e293b;
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        /* Bento KPI Card Design System */
        .card-bento-kpi {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 1.4rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03), 0 6px 16px rgba(0, 0, 0, 0.02);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .card-bento-kpi:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }
        .bento-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .bento-icon-gold {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }
        .bento-icon-blue {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }
        .bento-icon-amber {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .bento-icon-red {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        .bento-stat-num {
            font-size: 1.85rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            color: #0f172a;
            line-height: 1.1;
        }
        .bento-stat-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
        }

        /* Executive Table Theme */
        .table-executive {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        .table-executive thead th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.85rem 1rem;
            border-bottom: 1.5px solid #e2e8f0;
        }
        .table-executive tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 0.875rem;
        }
        .table-executive tbody tr:hover td {
            background-color: #fbfcfe;
        }

        /* Modern Status Pills */
        .badge-status-completed {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            font-weight: 800;
            font-size: 0.72rem;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .badge-status-processing {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            font-weight: 800;
            font-size: 0.72rem;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .badge-status-pending {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
            font-weight: 800;
            font-size: 0.72rem;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .badge-status-cancelled {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            font-weight: 800;
            font-size: 0.72rem;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        /* Buttons & Actions */
        .btn-gold {
            background: #facc15;
            color: #0f172a !important;
            font-weight: 800;
            font-size: 0.875rem;
            border-radius: 9999px;
            padding: 0.5rem 1.25rem;
            border: none;
            box-shadow: 0 2px 8px rgba(250, 204, 21, 0.3);
            transition: all 0.15s ease;
        }
        .btn-gold:hover {
            background: #eab308;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.4);
        }
        .btn-obsidian {
            background: #0f172a;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 0.875rem;
            border-radius: 9999px;
            padding: 0.5rem 1.25rem;
            border: none;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
            transition: all 0.15s ease;
        }
        .btn-obsidian:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }

        /* Universal Table & Component Harmonization */
        .table thead.table-light th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-size: 0.75rem !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 0.85rem 1rem !important;
            border-bottom: 1.5px solid #e2e8f0 !important;
        }
        .table tbody td {
            padding: 0.9rem 1rem !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 0.875rem !important;
        }
        .table-hover tbody tr:hover td {
            background-color: #fbfcfe !important;
        }
        .card {
            border-radius: 18px !important;
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04), 0 2px 6px -1px rgba(15, 23, 42, 0.02) !important;
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 0.55rem 0.9rem;
            font-size: 0.875rem;
            transition: all 0.15s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #facc15 !important;
            box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.25) !important;
        }
        .btn-success {
            background-color: #facc15 !important;
            border-color: #facc15 !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            box-shadow: 0 2px 8px rgba(250, 204, 21, 0.25);
        }
        .btn-success:hover {
            background-color: #eab308 !important;
            border-color: #eab308 !important;
            color: #0f172a !important;
        }
        .btn-primary {
            background-color: #0f172a !important;
            border-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }
        .btn-primary:hover {
            background-color: #1e293b !important;
            border-color: #1e293b !important;
        }

        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.show {
                margin-left: 0;
            }
            #content-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    @php
        $currentStaff = Auth::guard('staff')->user();
        $pendingOrdersCount = \App\Models\Order::where('Status', 'Pending')->count();
        $lowStockCountBadge = \App\Models\Product::lowStock()->count();
    @endphp

    <!-- Executive Obsidian Sidebar -->
    <nav id="sidebar">
        <!-- Brand Header -->
        <a href="{{ ($currentStaff && $currentStaff->isAdmin()) ? route('admin.dashboard') : route('stock.dashboard') }}" class="sidebar-brand-header">
            <div class="sidebar-brand-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <div>
                <div class="sidebar-brand-title">Fresh<span>Mart</span></div>
                <div class="sidebar-brand-tag">Commerce Control Center</div>
            </div>
        </a>

        <!-- Staff Member Identity Card -->
        <div class="sidebar-user-card">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr($currentStaff->UserName ?? 'A', 0, 1)) }}
            </div>
            <div class="overflow-hidden flex-grow-1">
                <div class="text-white fw-bold text-truncate" style="font-size: 0.875rem;">
                    {{ $currentStaff->UserName ?? 'Staff Admin' }}
                </div>
                <div class="d-flex align-items-center gap-1 mt-1">
                    <span class="{{ ($currentStaff && $currentStaff->isAdmin()) ? 'sidebar-user-role-admin' : 'sidebar-user-role-stock' }}">
                        <i class="bi {{ ($currentStaff && $currentStaff->isAdmin()) ? 'bi-shield-fill-check' : 'bi-boxes' }}"></i>
                        {{ strtoupper($currentStaff->Role ?? 'ADMIN') }}
                    </span>
                    <span class="status-pulse-dot ms-1" title="Active Session"></span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-grow-1 pb-4">
            @if($currentStaff && $currentStaff->isAdmin())
                <div class="sidebar-nav-heading">Executive Management</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Admin Dashboard</span>
                </a>
                <a href="{{ route('admin.sales.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Sales & Analytics</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span>Customer Orders</span>
                    @if($pendingOrdersCount > 0)
                        <span class="sidebar-badge-count badge-warning-glow">{{ $pendingOrdersCount }} new</span>
                    @endif
                </a>
                <a href="{{ route('admin.staff.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Staff Personnel</span>
                </a>
            @endif

            <div class="sidebar-nav-heading">Inventory & Storefront</div>
            <a href="{{ route('stock.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('stock.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Stock Overview</span>
            </a>
            <a href="{{ route('stock.alerts') }}" class="sidebar-nav-link {{ request()->routeIs('stock.alerts') ? 'active' : '' }}">
                <i class="bi bi-shield-exclamation"></i>
                <span>Inventory Alerts</span>
                @if($lowStockCountBadge > 0)
                    <span class="sidebar-badge-count badge-warning-glow">{{ $lowStockCountBadge }} low</span>
                @endif
            </a>
            <a href="{{ route('stock.products.index') }}" class="sidebar-nav-link {{ request()->routeIs('stock.products.*') ? 'active' : '' }}">
                <i class="bi bi-basket3-fill"></i>
                <span>Product Catalog</span>
            </a>
            <a href="{{ route('stock.categories.index') }}" class="sidebar-nav-link {{ request()->routeIs('stock.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tag-fill"></i>
                <span>Aisle Categories</span>
            </a>

            <div class="sidebar-nav-heading">Store Shortcuts</div>
            <a href="{{ route('home') }}" target="_blank" class="sidebar-nav-link">
                <i class="bi bi-shop-window"></i>
                <span>Public Mini Mart</span>
                <i class="bi bi-box-arrow-up-right ms-auto small opacity-50"></i>
            </a>
        </div>

        <!-- Sidebar Sign Out Footer -->
        <div class="p-3 border-top border-secondary border-opacity-10 mt-auto">
            <a href="{{ route('staff.logout') }}" class="btn btn-sm w-100 d-flex align-items-center justify-content-center gap-2 rounded-pill py-2 text-decoration-none" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25);">
                <i class="bi bi-power"></i>
                <span class="fw-bold">Sign Out Session</span>
            </a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div id="content-wrapper">
        <!-- Top Sticky Header -->
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary d-lg-none rounded-pill" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="fw-bold mb-0 text-dark">@yield('page-title', 'Management Console')</h5>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0 small d-none d-md-inline-block">
                            <span class="status-pulse-dot me-1"></span> Live POS
                        </span>
                    </div>
                    <div class="text-muted small">@yield('page-subtitle', 'FreshMart Supermarket SSMS Management Console')</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <!-- Storefront Capsule Button -->
                <a href="{{ route('home') }}" target="_blank" class="btn-live-storefront d-none d-sm-inline-flex">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span>Storefront</span>
                </a>

                <!-- Profile Badge & Logout -->
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill border d-flex align-items-center gap-2 py-1 px-3" data-bs-toggle="dropdown">
                        <span class="rounded-circle bg-warning text-dark fw-bold d-flex align-items-center justify-content-center" style="width: 26px; height: 26px; font-size: 0.8rem;">
                            {{ strtoupper(substr($currentStaff->UserName ?? 'A', 0, 1)) }}
                        </span>
                        <span class="small fw-bold text-dark d-none d-md-inline">{{ $currentStaff->UserName ?? 'Staff' }}</span>
                        <i class="bi bi-chevron-down small opacity-50"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border rounded-4 mt-2 p-2" style="min-width: 200px;">
                        <li><h6 class="dropdown-header small text-uppercase fw-bold">Active Staff Session</h6></li>
                        <li>
                            <div class="px-3 py-1 small text-muted">
                                <div>Role: <strong class="text-dark">{{ $currentStaff->Role ?? 'Staff' }}</strong></div>
                                <div>ID: #{{ str_pad($currentStaff->Sid ?? 1, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a href="{{ route('staff.logout') }}" class="dropdown-item text-danger py-2 rounded-2 fw-semibold">
                                <i class="bi bi-box-arrow-right me-2"></i> Log Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="p-3 p-md-4 flex-grow-1">
            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="alert alert-dismissible fade show rounded-4 border-0 d-flex align-items-center gap-2 shadow-sm mb-4" style="background: #fefce8; color: #854d0e; border: 1.5px solid #fde047 !important;" role="alert">
                    <i class="bi bi-check-circle-fill fs-5" style="color: #ca8a04;"></i>
                    <div class="fw-semibold small">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                    <div class="fw-semibold small">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                    <div class="fw-bold mb-1 small"><i class="bi bi-shield-exclamation me-1"></i> Form Errors:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Admin Footer -->
        <footer class="bg-white border-top py-3 px-4 text-center text-md-between d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 text-muted small">
            <div><strong>FreshMart™ SSMS</strong> &bull; Executive Supermarket Management Console</div>
            <div class="d-flex align-items-center gap-3">
                <span>Database: <code>laravel_mart_db</code></span>
                <span>&bull;</span>
                <span>Active Server: <code>127.0.0.1:8000</code></span>
            </div>
        </footer>
    </div>

    <!-- Universal Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-body p-4 text-center">
                    <!-- Warning Icon with Halo -->
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" 
                         style="width: 64px; height: 64px; background: #fee2e2; color: #dc2626; box-shadow: 0 0 0 8px rgba(254, 226, 226, 0.5);">
                        <i class="bi bi-trash3-fill fs-2"></i>
                    </div>

                    <h5 class="fw-bold text-dark mb-1" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <p class="text-muted small mb-3">
                        Are you sure you want to permanently remove this <span id="deleteItemType" class="fw-bold text-dark">item</span>? This action cannot be reversed.
                    </p>

                    <!-- Item Identity Box -->
                    <div class="p-3 rounded-3 border bg-light text-start mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="badge bg-secondary rounded-pill" id="deleteItemId">#0000</span>
                            <span class="text-danger small fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i>Permanent</span>
                        </div>
                        <div class="fw-bold text-dark text-truncate" id="deleteItemName" style="font-size: 0.95rem;">
                            Item Name
                        </div>
                    </div>

                    <div class="text-muted small mb-4" style="font-size: 0.78rem;">
                        <i class="bi bi-shield-lock me-1"></i> Database safety guards will prevent deletion if linked orders or products exist.
                    </div>

                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold border" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <form id="deleteConfirmForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                                <i class="bi bi-trash3"></i> Yes, Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteConfirmModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const actionUrl = button.getAttribute('data-action');
                const name = button.getAttribute('data-name');
                const id = button.getAttribute('data-id') || '';
                const type = button.getAttribute('data-type') || 'item';

                document.getElementById('deleteConfirmForm').action = actionUrl;
                document.getElementById('deleteItemName').textContent = name;
                document.getElementById('deleteItemId').textContent = id;
                document.getElementById('deleteItemType').textContent = type.toLowerCase();
            });
        }
    });
    </script>
    @yield('scripts')
</body>
</html>
