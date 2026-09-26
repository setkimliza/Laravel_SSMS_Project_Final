@extends('layouts.admin')

@section('title', 'Stock Dashboard - FreshMart SSMS')
@section('page-title', 'Stock & Inventory Control Dashboard')
@section('page-subtitle', 'Monitor current quantity, low-stock warnings, expired shelf detection, and replenishments')

@section('content')
<!-- KPI Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Total Products -->
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Catalog Items</span>
                    <h3 class="fw-bold mb-0 text-dark mt-1">{{ number_format($totalProducts) }} SKUs</h3>
                    <div class="text-muted small mt-1"><a href="{{ route('stock.products.index') }}" class="text-decoration-none">View products &rarr;</a></div>
                </div>
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Categories -->
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Departments</span>
                    <h3 class="fw-bold mb-0 text-dark mt-1">{{ number_format($totalCategories) }}</h3>
                    <div class="text-muted small mt-1"><a href="{{ route('stock.categories.index') }}" class="text-decoration-none">Manage categories &rarr;</a></div>
                </div>
                <div class="stat-icon bg-info-subtle text-info-emphasis">
                    <i class="bi bi-tags-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Low Stock Alert</span>
                    <h3 class="fw-bold mb-0 text-warning mt-1">{{ $lowStockCount }}</h3>
                    <div class="text-warning small mt-1"><i class="bi bi-exclamation-circle-fill me-1"></i> Below MinStock threshold</div>
                </div>
                <div class="stat-icon bg-warning-subtle text-warning-emphasis">
                    <i class="bi bi-graph-down-arrow"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Expired Products Alert -->
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Expired On Shelf</span>
                    <h3 class="fw-bold mb-0 text-danger mt-1">{{ $expiredCount }}</h3>
                    <div class="text-danger small mt-1"><i class="bi bi-x-octagon-fill me-1"></i> Immediate action required</div>
                </div>
                <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-calendar-x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Restock and Actions Toolbar -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex gap-2 align-items-center">
        <span class="badge bg-danger-subtle text-danger border px-3 py-2 rounded-pill">
            <i class="bi bi-dash-circle me-1"></i> Out of Stock: <strong>{{ $outOfStockCount }}</strong>
        </span>
        <span class="badge bg-warning-subtle text-warning-emphasis border px-3 py-2 rounded-pill">
            <i class="bi bi-hourglass-split me-1"></i> Expiring Soon (30d): <strong>{{ $expiringSoonCount }}</strong>
        </span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('stock.alerts') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
            <i class="bi bi-bell-fill me-1"></i> View All Inventory Alerts
        </a>
        <a href="{{ route('stock.products.create') }}" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
            <i class="bi bi-plus-lg me-1"></i> New Product
        </a>
    </div>
</div>

<!-- Two Column Layout: Low Stock vs Expired Products -->
<div class="row g-4 mb-4">
    <!-- Low Stock Table -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    <span>Low Stock Replenishment List</span>
                </h6>
                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Qty &le; MinStock</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Current</th>
                            <th class="text-center">Min</th>
                            <th class="text-end">Quick Restock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts as $prod)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $prod->PName }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $prod->category->name ?? 'General' }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $prod->Qty <= 0 ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill">
                                        {{ $prod->Qty }}
                                    </span>
                                </td>
                                <td class="text-center text-muted">{{ $prod->MinStock }}</td>
                                <td class="text-end">
                                    <form action="{{ route('stock.products.quick-stock', $prod->PID) }}" method="POST" class="d-inline-flex gap-1 justify-content-end align-items-center">
                                        @csrf
                                        <input type="number" name="Qty" value="{{ $prod->MinStock * 2 }}" min="0" class="form-control form-control-sm text-center py-0" style="width: 60px;">
                                        <button type="submit" class="btn btn-sm btn-outline-success py-0 px-2 rounded-pill" title="Update Quantity">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No products are currently low on stock.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Expired Products Table -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-x-fill text-danger"></i>
                    <span>Expired Products (Pull from Shelves)</span>
                </h6>
                <span class="badge bg-danger-subtle text-danger rounded-pill">Expired</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Stock</th>
                            <th>Expiry Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expiredProducts as $ep)
                            <tr>
                                <td>
                                    <div class="fw-bold text-danger">{{ $ep->PName }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $ep->category->name ?? 'General' }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill">{{ $ep->Qty }}</span>
                                </td>
                                <td class="text-danger fw-bold">
                                    {{ \Carbon\Carbon::parse($ep->ExpiredDate)->format('M d, Y') }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('stock.products.edit', $ep->PID) }}" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-pill">
                                        Update
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No expired items detected in stock.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Expiring Soon Products Table -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-info"></i>
                <span>Products Expiring Soon (Within Next 30 Days)</span>
            </h6>
            <span class="text-muted small">Consider promotional discounts or clearance before expiration date</span>
        </div>
        <span class="badge bg-info-subtle text-info-emphasis rounded-pill">Warning Window</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">PID</th>
                    <th>Product Name</th>
                    <th>Department</th>
                    <th>Current Quantity</th>
                    <th>Price</th>
                    <th>Expiry Date</th>
                    <th class="pe-3 text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expiringSoonProducts as $esp)
                    <tr>
                        <td class="ps-3 text-muted">#{{ $esp->PID }}</td>
                        <td class="fw-bold text-dark">{{ $esp->PName }}</td>
                        <td>{{ $esp->category->name ?? 'General' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border rounded-pill">{{ $esp->Qty }} units</span>
                        </td>
                        <td class="fw-semibold">${{ number_format($esp->Price, 2) }}</td>
                        <td class="fw-bold text-warning-emphasis">
                            {{ \Carbon\Carbon::parse($esp->ExpiredDate)->format('M d, Y') }} 
                            <span class="small text-muted font-monospace">({{ \Carbon\Carbon::parse($esp->ExpiredDate)->diffForHumans() }})</span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('stock.products.edit', $esp->PID) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No products are expiring within the next 30 days.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
