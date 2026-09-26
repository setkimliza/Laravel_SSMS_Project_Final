<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff Portal - FreshMart SSMS')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --sidebar-width: 270px;
            --primary: #10b981;
            --primary-dark: #059669;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #10b981;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            min-height: 100vh;
        }

        /* Sidebar Styling */
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
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            font-size: 1.25rem;
            font-weight: 800;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid #1e293b;
        }

        .sidebar-brand i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .nav-heading {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            padding: 1.25rem 1.25rem 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.7rem 1.25rem;
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.92rem;
            border-radius: 8px;
            margin: 0.15rem 0.75rem;
            transition: all 0.2s ease;
        }

        .sidebar-link i {
            font-size: 1.15rem;
            color: #94a3b8;
            width: 20px;
            text-align: center;
        }

        .sidebar-link:hover {
            color: white;
            background-color: var(--sidebar-hover);
        }

        .sidebar-link.active {
            background-color: var(--primary);
            color: white;
        }

        .sidebar-link.active i {
            color: white;
        }

        /* Main Content Layout */
        #content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .top-navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.9rem 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .card-stat {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: white;
            padding: 1.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -8px rgba(0,0,0,0.08);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .badge-role-admin {
            background: #8b5cf6;
            color: white;
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
        }

        .badge-role-stock {
            background: #0ea5e9;
            color: white;
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
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

    <!-- Sidebar Navigation -->
    <nav id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-basket2-fill"></i>
            <div>
                <div>FreshMart</div>
                <div style="font-size: 0.68rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Supermarket SSMS</div>
            </div>
        </div>

        <div class="p-3">
            @php $currentStaff = Auth::guard('staff')->user(); @endphp
            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background: #1e293b;">
                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                    {{ strtoupper(substr($currentStaff->UserName ?? 'S', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-white fw-bold text-truncate" style="font-size: 0.9rem;">{{ $currentStaff->UserName ?? 'Staff Member' }}</div>
                    <span class="{{ ($currentStaff && $currentStaff->isAdmin()) ? 'badge-role-admin' : 'badge-role-stock' }}">
                        {{ strtoupper($currentStaff->Role ?? 'STAFF') }}
                    </span>
                </div>
            </div>
        </div>

        <ul class="list-unstyled mb-4">
            @if($currentStaff && $currentStaff->isAdmin())
                <div class="nav-heading">ADMINISTRATION</div>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Admin Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.staff.index') }}" class="sidebar-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Staff Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.sales.index') }}" class="sidebar-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i> Sales & Analytics
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt"></i> Customer Orders
                    </a>
                </li>
            @endif

            <div class="nav-heading">STOCK & INVENTORY</div>
            <li>
                <a href="{{ route('stock.dashboard') }}" class="sidebar-link {{ request()->routeIs('stock.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-boxes"></i> Stock Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('stock.alerts') }}" class="sidebar-link {{ request()->routeIs('stock.alerts') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i> Inventory Alerts
                </a>
            </li>
            <li>
                <a href="{{ route('stock.products.index') }}" class="sidebar-link {{ request()->routeIs('stock.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Products CRUD
                </a>
            </li>
            <li>
                <a href="{{ route('stock.categories.index') }}" class="sidebar-link {{ request()->routeIs('stock.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill"></i> Categories CRUD
                </a>
            </li>

            <div class="nav-heading">SYSTEM NAVIGATION</div>
            <li>
                <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                    <i class="bi bi-shop"></i> View Storefront <i class="bi bi-box-arrow-up-right ms-auto" style="font-size: 0.75rem;"></i>
                </a>
            </li>
            <li>
                <form action="{{ route('staff.logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="submit" class="sidebar-link border-0 w-100 text-start bg-transparent text-danger">
                        <i class="bi bi-box-arrow-left text-danger"></i> Sign Out
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Content Wrapper -->
    <div id="content-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary d-lg-none" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-sm-block">
                    <h5 class="fw-bold mb-0 text-dark">@yield('page-title', 'Management Console')</h5>
                    <span class="text-muted small">@yield('page-subtitle', 'Supermarket & Store Management System')</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="badge {{ ($currentStaff && $currentStaff->isAdmin()) ? 'bg-purple-subtle text-purple text-dark border' : 'bg-info-subtle text-info-emphasis border' }} px-3 py-2 rounded-pill">
                    <i class="bi bi-shield-check me-1"></i> Logged as <strong>{{ $currentStaff->Role ?? 'Staff' }}</strong> ({{ $currentStaff->UserName ?? '' }})
                </span>

                <form action="{{ route('staff.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Log out of Staff Portal">
                        <i class="bi bi-power me-1"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="p-3 p-md-4 flex-grow-1">
            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-shield-exclamation me-1"></i> Validation Errors:</div>
                    <ul class="mb-0 ps-3">
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
            <div>FreshMart SSMS &bull; Role-Based Supermarket Management System</div>
            <div>Database: <code>laravel_mart_db</code> &bull; Laravel v{{ Illuminate\Foundation\Application::VERSION }}</div>
        </footer>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
