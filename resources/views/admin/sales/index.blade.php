@extends('layouts.admin')

@section('title', 'Sales & Financial Reports - FreshMart Supermarket')
@section('page-title', 'Financial Analytics & Revenue Reports')
@section('page-subtitle', 'Supermarket revenue performance, daily breakdown, and department volume analysis')

@section('content')

<!-- Date Filter & Reporting Toolbar -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
        <div>
            <h6 class="fw-black text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-funnel-fill text-warning"></i> Report Period Filter
            </h6>
            <span class="text-muted small">Select custom timeframe or use quick presets</span>
        </div>
        <!-- Quick Preset Buttons -->
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.sales.index') }}?start_date={{ \Carbon\Carbon::today()->format('Y-m-d') }}&end_date={{ \Carbon\Carbon::today()->format('Y-m-d') }}" 
               class="btn btn-sm btn-light border rounded-pill px-3 fw-bold small">
                Today
            </a>
            <a href="{{ route('admin.sales.index') }}?start_date={{ \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }}&end_date={{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
               class="btn btn-sm btn-light border rounded-pill px-3 fw-bold small">
                Last 7 Days
            </a>
            <a href="{{ route('admin.sales.index') }}?start_date={{ \Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}&end_date={{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
               class="btn btn-sm btn-warning rounded-pill px-3 fw-bold small">
                Last 30 Days
            </a>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" onclick="window.print();" title="Print Fiscal Report">
                <i class="bi bi-printer me-1"></i> Print Report
            </button>
        </div>
    </div>

    <form action="{{ route('admin.sales.index') }}" method="GET" class="row g-3 align-items-end pt-2 border-top border-light-subtle">
        <div class="col-md-5">
            <label for="start_date" class="form-label small fw-bold text-secondary">Start Date</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar3"></i></span>
                <input type="date" name="start_date" id="start_date" class="form-control bg-light border-start-0" 
                       value="{{ $startDate->format('Y-m-d') }}">
            </div>
        </div>
        <div class="col-md-5">
            <label for="end_date" class="form-label small fw-bold text-secondary">End Date</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-check"></i></span>
                <input type="date" name="end_date" id="end_date" class="form-control bg-light border-start-0" 
                       value="{{ $endDate->format('Y-m-d') }}">
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark rounded-pill w-100 fw-bold py-2">
                <i class="bi bi-arrow-clockwise me-1"></i> Apply
            </button>
        </div>
    </form>
</div>

<!-- Financial Summary Bento KPI Cards (3 Cards) -->
<div class="row g-3 mb-4">
    <!-- Period Total Revenue -->
    <div class="col-md-4">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Period Gross Sales</span>
                    <div class="bento-stat-num mt-1" style="color: #0f172a;">${{ number_format($totalSales, 2) }}</div>
                </div>
                <div class="bento-icon-wrapper bento-icon-gold">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <span class="text-success fw-bold d-inline-flex align-items-center gap-1">
                    <i class="bi bi-check-circle-fill"></i> Completed Transactions
                </span>
                <span class="text-muted">{{ $startDate->format('M d') }} - {{ $endDate->format('M d') }}</span>
            </div>
        </div>
    </div>

    <!-- Orders Count -->
    <div class="col-md-4">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Customer Orders</span>
                    <div class="bento-stat-num mt-1" style="color: #0369a1;">{{ number_format($totalOrders) }}</div>
                </div>
                <div class="bento-icon-wrapper bento-icon-blue">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <a href="{{ route('admin.orders.index') }}" class="text-primary fw-bold text-decoration-none">
                    View order list &rarr;
                </a>
                <span class="text-muted">Avg ${{ $totalOrders > 0 ? number_format($totalSales / $totalOrders, 2) : '0.00' }}/order</span>
            </div>
        </div>
    </div>

    <!-- Total Grocery Units -->
    <div class="col-md-4">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Grocery Units Sold</span>
                    <div class="bento-stat-num mt-1" style="color: #b45309;">{{ number_format($totalProductsSold) }} <span style="font-size: 1rem; color: #64748b;">items</span></div>
                </div>
                <div class="bento-icon-wrapper bento-icon-amber">
                    <i class="bi bi-basket-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <span class="text-muted">Total units moved off shelf</span>
                <span class="badge bg-light text-dark border">Catalog Volume</span>
            </div>
        </div>
    </div>
</div>

<!-- Daily Sales Bar Chart -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-black text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-bar-chart-fill text-warning"></i> Daily Revenue Performance
            </h5>
            <span class="text-muted small">Daily turnover within selected fiscal range</span>
        </div>
        <span class="badge bg-light text-muted border rounded-pill px-3 py-1 fw-bold small">
            Timeline View
        </span>
    </div>
    <div style="height: 280px; position: relative;">
        <canvas id="dailySalesChart"></canvas>
    </div>
</div>

<!-- Tables: Top Products & Top Categories -->
<div class="row g-4">
    <!-- Top-Selling Supermarket SKUs -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-black text-dark mb-0">Top-Performing Grocery Items</h6>
                    <span class="text-muted small">By total units sold & revenue generated</span>
                </div>
                <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small fw-bold">Top 10</span>
            </div>

            <div class="table-responsive">
                <table class="table-executive">
                    <thead>
                        <tr>
                            <th>Rank & SKU</th>
                            <th class="text-center">Units Sold</th>
                            <th class="text-end">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $idx => $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle bg-light border text-muted small fw-black d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.72rem;">
                                            {{ $idx + 1 }}
                                        </span>
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $item->PName }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">SKU: #{{ str_pad($item->PID, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill fw-bold">
                                        {{ $item->total_qty }} units
                                    </span>
                                </td>
                                <td class="text-end fw-black text-dark">
                                    ${{ number_format($item->total_revenue, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4 small">No product sales in this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top-Selling Supermarket Departments -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-black text-dark mb-0">Top Supermarket Departments</h6>
                    <span class="text-muted small">Revenue by department category</span>
                </div>
                <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small fw-bold">Top Aisles</span>
            </div>

            <div class="table-responsive">
                <table class="table-executive">
                    <thead>
                        <tr>
                            <th>Aisle Department</th>
                            <th class="text-center">Units Sold</th>
                            <th class="text-end">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCategories as $idx => $cat)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle bg-light border text-muted small fw-black d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.72rem;">
                                            {{ $idx + 1 }}
                                        </span>
                                        <span class="fw-bold text-dark small">{{ $cat->category_name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill fw-bold">
                                        {{ $cat->total_qty }} units
                                    </span>
                                </td>
                                <td class="text-end fw-black text-dark">
                                    ${{ number_format($cat->total_revenue, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4 small">No category sales in this period.</td>
                            </tr>
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
    const dailyData = @json($dailySales);
    const labels = dailyData.map(d => d.date);
    const revenues = dailyData.map(d => parseFloat(d.revenue));

    const ctx = document.getElementById('dailySalesChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Gross Sales ($)',
                data: revenues,
                backgroundColor: '#facc15',
                hoverBackgroundColor: '#eab308',
                borderRadius: 8,
                borderWidth: 1,
                borderColor: '#ca8a04',
                maxBarThickness: 45
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
                            return 'Daily Revenue: $' + context.parsed.y.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
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
                        callback: function(val) { return '$' + val; }
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
