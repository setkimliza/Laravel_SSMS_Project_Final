@extends('layouts.admin')

@section('title', 'Sales & Revenue Reports - FreshMart SSMS')
@section('page-title', 'Sales Analytics & Financial Reporting')
@section('page-subtitle', 'Supermarket revenue performance, department volume, and top item analysis')

@section('content')
<!-- Date Filter Card -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <form action="{{ route('admin.sales.index') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="start_date" class="form-label small fw-semibold text-secondary">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control rounded-pill" 
                   value="{{ $startDate->format('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label small fw-semibold text-secondary">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control rounded-pill" 
                   value="{{ $endDate->format('Y-m-d') }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary rounded-pill px-4 flex-grow-1">
                <i class="bi bi-funnel me-1"></i> Apply Filter
            </button>
            <button type="button" class="btn btn-outline-secondary rounded-pill px-3" onclick="window.print();" title="Print Report">
                <i class="bi bi-printer"></i>
            </button>
        </div>
    </form>
</div>

<!-- KPI Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-stat">
            <span class="text-muted small fw-semibold text-uppercase">Period Total Revenue</span>
            <h2 class="fw-bold mb-0 text-dark mt-1 text-success">${{ number_format($totalSales, 2) }}</h2>
            <div class="text-muted small mt-1">From completed orders</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat">
            <span class="text-muted small fw-semibold text-uppercase">Orders Processed</span>
            <h2 class="fw-bold mb-0 text-dark mt-1">{{ number_format($totalOrders) }}</h2>
            <div class="text-muted small mt-1">Total customer transactions</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat">
            <span class="text-muted small fw-semibold text-uppercase">Grocery Units Sold</span>
            <h2 class="fw-bold mb-0 text-dark mt-1">{{ number_format($totalProductsSold) }}</h2>
            <div class="text-muted small mt-1">Aggregated shelf volume</div>
        </div>
    </div>
</div>

<!-- Daily Sales Bar Chart -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-dark mb-0">Daily Revenue Timeline</h6>
        <span class="badge bg-light text-muted border">Filtered Range</span>
    </div>
    <div style="height: 260px; position: relative;">
        <canvas id="dailySalesChart"></canvas>
    </div>
</div>

<!-- Tables: Top Products & Top Categories -->
<div class="row g-4">
    <!-- Top Products -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h6 class="fw-bold text-dark mb-3">Top-Selling Supermarket Products</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Product Name</th>
                            <th class="text-center">Units Sold</th>
                            <th class="text-end">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $item)
                            <tr>
                                <td class="fw-bold text-dark">{{ $item->PName }}</td>
                                <td class="text-center fw-semibold">
                                    <span class="badge bg-light text-dark border">{{ $item->total_qty }}</span>
                                </td>
                                <td class="text-end fw-bold text-success">${{ number_format($item->total_revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">No product sales in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Categories -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h6 class="fw-bold text-dark mb-3">Top-Selling Departments</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Department</th>
                            <th class="text-center">Units Sold</th>
                            <th class="text-end">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCategories as $cat)
                            <tr>
                                <td class="fw-bold text-dark">{{ $cat->category_name }}</td>
                                <td class="text-center fw-semibold">
                                    <span class="badge bg-light text-dark border">{{ $cat->total_qty }}</span>
                                </td>
                                <td class="text-end fw-bold text-success">${{ number_format($cat->total_revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">No category sales in this period.</td></tr>
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

        const ctx = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: revenues,
                    backgroundColor: '#10b981',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
