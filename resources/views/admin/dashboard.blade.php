@extends('layouts.admin')

@section('title', 'Admin Dashboard - FreshMart Supermarket')
@section('page-title', 'Supermarket Administration Dashboard')
@section('page-subtitle', 'Real-time sales performance, inventory health, staff activities, and order queue')

@section('content')

<!-- Welcome Executive Banner -->
<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;">
    <div class="p-4 p-md-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4 position-relative" style="z-index: 2;">
        <div>
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(250, 204, 21, 0.15); border: 1px solid rgba(250, 204, 21, 0.3); color: #fef08a; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em; text-transform: uppercase;">
                <span class="status-pulse-dot"></span>
                <span>FreshMart Commerce Engine • Active</span>
            </div>
            <h2 class="fw-black mb-2 tracking-tight" style="font-size: 1.85rem; letter-spacing: -0.03em;">
                Welcome back, <span style="color: #facc15;">{{ Auth::guard('staff')->user()->UserName }}</span> ⚡
            </h2>
            <p class="text-slate-300 mb-0 small" style="max-width: 600px; color: #94a3b8; line-height: 1.5;">
                All systems operating at peak performance. Currently managing <strong class="text-white">{{ $totalProducts }} catalog items</strong>, <strong class="text-white">{{ $totalOrders }} customer orders</strong>, and generating <strong style="color: #fef08a;">${{ number_format($totalSales, 2) }}</strong> in gross supermarket sales.
            </p>
        </div>

        <!-- Quick Action Pills -->
        <div class="d-flex flex-wrap gap-2 flex-shrink-0">
            <a href="{{ route('stock.products.create') }}" class="btn-gold d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Add Product</span>
            </a>
            <a href="{{ route('admin.staff.create') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-bold small d-inline-flex align-items-center gap-2" style="border-color: rgba(255,255,255,0.25);">
                <i class="bi bi-person-plus-fill"></i>
                <span>Add Staff</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-dark rounded-pill px-3 py-2 fw-bold small d-inline-flex align-items-center gap-2" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);">
                <i class="bi bi-receipt"></i>
                <span>Live Orders</span>
            </a>
        </div>
    </div>
    <!-- Ambient Golden Glow -->
    <div style="position: absolute; right: -80px; top: -80px; width: 280px; height: 280px; background: radial-gradient(circle, rgba(250, 204, 21, 0.2) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; pointer-events: none;"></div>
</div>

<!-- Primary Bento KPI Statistics Grid (4 Key Metrics) -->
<div class="row g-3 mb-4">
    <!-- Total Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Gross Revenue</span>
                    <div class="bento-stat-num mt-1" style="color: #0f172a;">${{ number_format($totalSales, 2) }}</div>
                </div>
                <div class="bento-icon-wrapper bento-icon-gold">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <span class="text-success fw-bold d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-up-right"></i> Completed Orders
                </span>
                <span class="text-muted">{{ number_format($totalOrders) }} transactions</span>
            </div>
        </div>
    </div>

    <!-- Customer Orders -->
    <div class="col-xl-3 col-md-6">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Total Orders</span>
                    <div class="bento-stat-num mt-1" style="color: #0369a1;">{{ number_format($totalOrders) }}</div>
                </div>
                <div class="bento-icon-wrapper bento-icon-blue">
                    <i class="bi bi-cart-check-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <a href="{{ route('admin.orders.index') }}" class="text-primary fw-bold text-decoration-none">
                    Manage queue &rarr;
                </a>
                <span class="text-muted">Live Tracking</span>
            </div>
        </div>
    </div>

    <!-- Low Stock Items -->
    <div class="col-xl-3 col-md-6">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Low Stock Warning</span>
                    <div class="bento-stat-num mt-1" style="color: #b45309;">{{ $lowStockCount }} <span style="font-size: 1rem; font-weight: 600; color: #64748b;">SKUs</span></div>
                </div>
                <div class="bento-icon-wrapper bento-icon-amber">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <a href="{{ route('stock.alerts') }}?filter=low_stock" class="text-warning-emphasis fw-bold text-decoration-none">
                    Inspect alerts &rarr;
                </a>
                <span class="text-muted">&le; 10 units</span>
            </div>
        </div>
    </div>

    <!-- Expired Products -->
    <div class="col-xl-3 col-md-6">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Expired On Shelf</span>
                    <div class="bento-stat-num mt-1" style="color: #b91c1c;">{{ $expiredCount }} <span style="font-size: 1rem; font-weight: 600; color: #64748b;">SKUs</span></div>
                </div>
                <div class="bento-icon-wrapper bento-icon-red">
                    <i class="bi bi-calendar-x-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <a href="{{ route('stock.alerts') }}?filter=expired" class="text-danger fw-bold text-decoration-none">
                    Remove items &rarr;
                </a>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $expiringSoonCount }} soon</span>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Status Strip (Catalog, Staff, Customers) -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-light border p-2 text-dark">
                    <i class="bi bi-boxes fs-5 text-warning"></i>
                </div>
                <div>
                    <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">Catalog SKUs</span>
                    <h6 class="fw-black text-dark mb-0">{{ $totalProducts }} Grocery Items</h6>
                </div>
            </div>
            <a href="{{ route('stock.products.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">Manage</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-light border p-2 text-dark">
                    <i class="bi bi-people-fill fs-5 text-primary"></i>
                </div>
                <div>
                    <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">Staff Personnel</span>
                    <h6 class="fw-black text-dark mb-0">{{ $totalStaff }} Authorized Users</h6>
                </div>
            </div>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">Manage</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-light border p-2 text-dark">
                    <i class="bi bi-person-check-fill fs-5 text-success"></i>
                </div>
                <div>
                    <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">Shoppers</span>
                    <h6 class="fw-black text-dark mb-0">{{ $totalUsers }} Customer Accounts</h6>
                </div>
            </div>
            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">Active</span>
        </div>
    </div>
</div>

<!-- Charts & Analytics Section -->
<div class="row g-4 mb-4">
    <!-- 7-Day Revenue Performance Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                <div>
                    <h5 class="fw-black text-dark mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-graph-up-arrow text-warning"></i> 7-Day Sales Revenue Trend
                    </h5>
                    <span class="text-muted small">Daily revenue stream generated across all supermarket registers</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-1 small fw-bold">
                        Auto-Synced
                    </span>
                    <a href="{{ route('admin.sales.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
                        Full Reports &rarr;
                    </a>
                </div>
            </div>
            <div style="height: 290px; position: relative;">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Selling Aisles / Departments -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-black text-dark mb-0">Top Supermarket Aisles</h6>
                    <span class="text-muted small">Highest volume categories</span>
                </div>
                <a href="{{ route('stock.categories.index') }}" class="btn btn-sm btn-link text-decoration-none small p-0 text-muted">Aisles</a>
            </div>

            <div class="list-group list-group-flush mt-2">
                @forelse($topCategories as $index => $tc)
                    <div class="list-group-item px-0 py-3 border-bottom border-light-subtle">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-dark d-flex align-items-center gap-2">
                                <span class="rounded-circle bg-light border text-muted small fw-bold d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.72rem;">
                                    {{ $index + 1 }}
                                </span>
                                <span>{{ $tc->category_name }}</span>
                            </span>
                            <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill fw-bold">
                                {{ $tc->total_sold }} units sold
                            </span>
                        </div>
                        <div class="progress mt-2" style="height: 6px; border-radius: 9999px; background: #f1f5f9;">
                            <div class="progress-bar" style="width: {{ min(100, $tc->total_sold * 4) }}%; background: linear-gradient(90deg, #facc15 0%, #ca8a04 100%);"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4 small">No category sales recorded yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Operational Tables Row: Live Orders Stream & Low Stock Watchlist -->
<div class="row g-4">
    <!-- Recent Customer Orders Table -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-black text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-primary"></i> Recent Customer Orders
                    </h5>
                    <span class="text-muted small">Live customer queue & payment status</span>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
                    View All ({{ $totalOrders }})
                </a>
            </div>

            <div class="table-responsive">
                <table class="table-executive">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="fw-black text-dark">
                                    #{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light border text-dark fw-bold d-flex align-items-center justify-content-center small" style="width: 32px; height: 32px;">
                                            {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $order->user->name ?? 'Guest User' }}</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">{{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, h:i A') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-black text-dark">
                                    ${{ number_format($order->TotalAmount, 2) }}
                                </td>
                                <td>
                                    @php
                                        $statusClass = match(strtolower($order->Status)) {
                                            'completed' => 'badge-status-completed',
                                            'processing' => 'badge-status-processing',
                                            'pending' => 'badge-status-pending',
                                            default => 'badge-status-cancelled',
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }}">
                                        {{ $order->Status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.show', $order->OrderID) }}" class="btn btn-sm btn-light border rounded-pill px-2" title="View Order Invoice">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No supermarket orders received yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Low Stock Emergency Watchlist -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-black text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-shield-exclamation text-warning"></i> Low Stock Watchlist
                    </h5>
                    <span class="text-muted small">Items requiring immediate vendor replenishment</span>
                </div>
                <a href="{{ route('stock.alerts') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold text-dark">
                    All Alerts
                </a>
            </div>

            <div class="list-group list-group-flush">
                @forelse($lowStockProducts as $lsp)
                    <div class="list-group-item px-0 py-3 border-bottom border-light-subtle d-flex align-items-center justify-content-between gap-3">
                        <div class="overflow-hidden">
                            <div class="fw-bold text-dark text-truncate" style="max-width: 220px;">
                                {{ $lsp->PName }}
                            </div>
                            <div class="text-muted small d-flex align-items-center gap-2 mt-1">
                                <span class="badge bg-light text-secondary border">{{ $lsp->category->name ?? 'Aisle' }}</span>
                                <span>SKU: #{{ str_pad($lsp->PID, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                        <div class="text-end flex-shrink-0">
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill fw-black px-2 py-1">
                                {{ $lsp->Qty }} left
                            </span>
                            <div class="mt-1">
                                <a href="{{ route('stock.products.edit', $lsp->PID) }}" class="small text-decoration-none fw-bold text-dark">
                                    Restock &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4 small">
                        <i class="bi bi-check-circle text-success fs-3 d-block mb-1"></i>
                        All supermarket shelf inventory is healthy!
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesTrendChart');
    if (!ctx) return;

    const chartData = @json($salesTrend);
    const labels = chartData.map(item => item.date);
    const amounts = chartData.map(item => item.amount);

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(250, 204, 21, 0.45)');
    gradient.addColorStop(0.5, 'rgba(250, 204, 21, 0.15)');
    gradient.addColorStop(1, 'rgba(250, 204, 21, 0.00)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Gross Sales Revenue ($)',
                data: amounts,
                borderColor: '#ca8a04',
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#ca8a04',
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#facc15',
                pointHoverBorderColor: '#0f172a',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#facc15',
                    bodyColor: '#ffffff',
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: $' + context.parsed.y.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            family: 'Plus Jakarta Sans',
                            size: 11,
                            weight: '600'
                        },
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            family: 'Plus Jakarta Sans',
                            size: 11,
                            weight: '600'
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
