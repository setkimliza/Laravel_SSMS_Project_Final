@extends('layouts.admin')

@section('title', 'Admin Dashboard - FreshMart SSMS')
@section('page-title', 'Supermarket Administration Dashboard')
@section('page-subtitle', 'Real-time sales analytics, stock alerts, staff overview, and order tracking')

@section('content')
<!-- KPI Statistics Cards -->
<div class="row g-3 mb-4">
    <!-- Total Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Total Sales Revenue</span>
                    <h3 class="fw-bold mb-0 text-dark mt-1">${{ number_format($totalSales, 2) }}</h3>
                    <div class="text-success small mt-1"><i class="bi bi-arrow-up-right me-1"></i> Completed Orders</div>
                </div>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Customer Orders</span>
                    <h3 class="fw-bold mb-0 text-dark mt-1">{{ number_format($totalOrders) }}</h3>
                    <div class="text-muted small mt-1"><a href="{{ route('admin.orders.index') }}" class="text-decoration-none">Manage orders &rarr;</a></div>
                </div>
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-cart-check-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Low Stock Items</span>
                    <h3 class="fw-bold mb-0 text-warning mt-1">{{ $lowStockCount }}</h3>
                    <div class="text-muted small mt-1"><a href="{{ route('stock.alerts') }}?filter=low_stock" class="text-warning text-decoration-none fw-semibold">Inspect alerts &rarr;</a></div>
                </div>
                <div class="stat-icon bg-warning-subtle text-warning-emphasis">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Expired Products -->
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Expired Products</span>
                    <h3 class="fw-bold mb-0 text-danger mt-1">{{ $expiredCount }}</h3>
                    <div class="text-muted small mt-1"><a href="{{ route('stock.alerts') }}?filter=expired" class="text-danger text-decoration-none fw-semibold">Remove from shelf &rarr;</a></div>
                </div>
                <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-calendar-x-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center justify-content-between">
            <div>
                <span class="text-muted small">Total Catalog Products</span>
                <h5 class="fw-bold text-dark mb-0">{{ $totalProducts }} SKUs</h5>
            </div>
            <a href="{{ route('stock.products.index') }}" class="btn btn-sm btn-light rounded-pill">Manage</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center justify-content-between">
            <div>
                <span class="text-muted small">Active Staff Accounts</span>
                <h5 class="fw-bold text-dark mb-0">{{ $totalStaff }} Personnel</h5>
            </div>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-light rounded-pill">Manage</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center justify-content-between">
            <div>
                <span class="text-muted small">Registered Shoppers</span>
                <h5 class="fw-bold text-dark mb-0">{{ $totalUsers }} Customers</h5>
            </div>
            <span class="badge bg-success-subtle text-success">Active</span>
        </div>
    </div>
</div>

<!-- Charts & Analytics Row -->
<div class="row g-4 mb-4">
    <!-- Sales Revenue Trend Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold text-dark mb-0">7-Day Sales Revenue Trend</h6>
                    <span class="text-muted small">Daily revenue performance across all supermarket transactions</span>
                </div>
                <a href="{{ route('admin.sales.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    Full Analytics
                </a>
            </div>
            <div style="height: 280px; position: relative;">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Selling Categories -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h6 class="fw-bold text-dark mb-1">Top Selling Departments</h6>
            <span class="text-muted small mb-3">Highest volume categories</span>

            <div class="list-group list-group-flush">
                @forelse($topCategories as $tc)
                    <div class="list-group-item px-0 py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-dark">{{ $tc->category_name }}</span>
                            <span class="badge bg-success-subtle text-success rounded-pill fw-bold">{{ $tc->total_sold }} sold</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: {{ min(100, $tc->total_sold * 4) }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4 small">No sales records available yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Products & Orders Row -->
<div class="row g-4 mb-4">
    <!-- Top Selling Products -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0">Top-Selling Products</h6>
                <span class="badge bg-light text-muted border">By Units</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Units Sold</th>
                            <th class="text-end">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $tp)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $tp->product->PName ?? 'SKU #' . $tp->PID }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $tp->product->category->name ?? 'General' }}</div>
                                </td>
                                <td class="text-center fw-bold">{{ $tp->total_qty }}</td>
                                <td class="text-end fw-semibold text-success">${{ number_format($tp->total_revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">No sales logged yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0">Recent Customer Orders</h6>
                <a href="{{ route('admin.orders.index') }}" class="small text-decoration-none">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $ro)
                            <tr>
                                <td class="fw-bold">#{{ str_pad($ro->OrderID, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $ro->user->name ?? 'Shopper' }}</td>
                                <td class="fw-bold">${{ number_format($ro->TotalAmount, 2) }}</td>
                                <td><span class="badge {{ $ro->status_badge }} rounded-pill">{{ $ro->Status }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.show', $ro->OrderID) }}" class="btn btn-sm btn-light py-0 px-2">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No recent orders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Stock Warnings Section -->
<div class="row g-4">
    <!-- Low Stock Quick Alert -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-warning-emphasis mb-0">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Urgent Low Stock Notice
                </h6>
                <a href="{{ route('stock.alerts') }}?filter=low_stock" class="small text-warning text-decoration-none">View All ({{ $lowStockCount }})</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Current Qty</th>
                            <th class="text-center">Min Stock</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts as $lp)
                            <tr>
                                <td class="fw-semibold">{{ $lp->PName }}</td>
                                <td class="text-center">
                                    <span class="badge bg-danger rounded-pill">{{ $lp->Qty }}</span>
                                </td>
                                <td class="text-center text-muted">{{ $lp->MinStock }}</td>
                                <td class="text-end">
                                    <a href="{{ route('stock.products.edit', $lp->PID) }}" class="btn btn-sm btn-outline-warning py-0 px-2 rounded-pill">
                                        Restock
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">All product stock levels are healthy!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Expired Products Quick Alert -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-danger mb-0">
                    <i class="bi bi-calendar-x-fill text-danger me-1"></i> Shelf Expiration Notice
                </h6>
                <a href="{{ route('stock.alerts') }}?filter=expired" class="small text-danger text-decoration-none">View All ({{ $expiredCount }})</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Department</th>
                            <th>Expiry Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expiredProducts as $ep)
                            <tr>
                                <td class="fw-semibold text-danger">{{ $ep->PName }}</td>
                                <td>{{ $ep->category->name ?? 'General' }}</td>
                                <td class="text-danger fw-bold">{{ \Carbon\Carbon::parse($ep->ExpiredDate)->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('stock.products.edit', $ep->PID) }}" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-pill">
                                        Inspect
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No expired items detected on shelves.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const trendData = @json($salesTrend);
        const labels = trendData.map(d => d.date);
        const values = trendData.map(d => d.amount);

        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Revenue ($)',
                    data: values,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#10b981',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(val) { return '$' + val; }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
