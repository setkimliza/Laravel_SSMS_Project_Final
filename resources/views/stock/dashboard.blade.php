@extends('layouts.admin')

@section('title', 'Stock Dashboard - FreshMart SSMS')
@section('page-title', 'Stock & Inventory Control Dashboard')
@section('page-subtitle', 'Monitor current quantity, low-stock warnings, expired shelf detection, and replenishments')

@section('content')
<!-- Bento KPI Statistics Grid -->
<div class="row g-3 mb-4">
    <!-- Total Products -->
    <div class="col-xl-3 col-md-6">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Total Catalog Items</span>
                    <div class="bento-stat-num mt-1" style="color: #0f172a;">{{ number_format($totalProducts) }} <span style="font-size: 1rem; font-weight: 700; color: #64748b;">SKUs</span></div>
                </div>
                <div class="bento-icon-wrapper bento-icon-blue">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <a href="{{ route('stock.products.index') }}" class="text-decoration-none fw-bold d-inline-flex align-items-center gap-1 text-primary">
                    View Catalog <i class="bi bi-arrow-right"></i>
                </a>
                <span class="text-muted">Live Inventory</span>
            </div>
        </div>
    </div>

    <!-- Total Categories -->
    <div class="col-xl-3 col-md-6">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Aisle Departments</span>
                    <div class="bento-stat-num mt-1" style="color: #0f172a;">{{ number_format($totalCategories) }}</div>
                </div>
                <div class="bento-icon-wrapper bento-icon-gold">
                    <i class="bi bi-tags-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <a href="{{ route('stock.categories.index') }}" class="text-decoration-none fw-bold d-inline-flex align-items-center gap-1 text-warning-emphasis text-nowrap">
                    Manage Aisles <i class="bi bi-arrow-right"></i>
                </a>
                <span class="text-muted text-nowrap">Categories</span>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-xl-3 col-md-6">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Low Stock Warnings</span>
                    <div class="bento-stat-num mt-1" style="color: #b45309;">{{ $lowStockCount }}</div>
                </div>
                <div class="bento-icon-wrapper bento-icon-amber">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <a href="{{ route('stock.alerts', ['filter' => 'low_stock']) }}" class="text-decoration-none fw-bold d-inline-flex align-items-center gap-1 text-warning-emphasis">
                    Replenish Now <i class="bi bi-arrow-right"></i>
                </a>
                <span class="text-muted">&le; MinStock</span>
            </div>
        </div>
    </div>

    <!-- Expired Products Alert -->
    <div class="col-xl-3 col-md-6">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <span class="bento-stat-label">Expired On Shelf</span>
                    <div class="bento-stat-num mt-1" style="color: #b91c1c;">{{ $expiredCount }}</div>
                </div>
                <div class="bento-icon-wrapper bento-icon-red">
                    <i class="bi bi-calendar-x-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle small">
                <a href="{{ route('stock.alerts', ['filter' => 'expired']) }}" class="text-decoration-none fw-bold d-inline-flex align-items-center gap-1 text-danger">
                    Pull From Shelves <i class="bi bi-arrow-right"></i>
                </a>
                <span class="text-danger fw-bold">Critical</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Restock and Actions Toolbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="{{ route('stock.products.index', ['stock_status' => 'out']) }}" class="badge bg-danger-subtle text-danger border px-3 py-2 rounded-pill text-decoration-none">
            <i class="bi bi-dash-circle me-1"></i> Out of Stock: <strong>{{ $outOfStockCount }}</strong> &rarr;
        </a>
        <a href="{{ route('stock.alerts', ['filter' => 'expiring_soon']) }}" class="badge bg-warning-subtle text-warning-emphasis border px-3 py-2 rounded-pill text-decoration-none">
            <i class="bi bi-hourglass-split me-1"></i> Expiring Soon (30d): <strong>{{ $expiringSoonCount }}</strong> &rarr;
        </a>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('stock.alerts') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold">
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
                                    <div class="d-inline-flex gap-1 justify-content-end align-items-center">
                                        <!-- Restock New Batch Modal Trigger -->
                                        <button type="button" class="btn btn-sm btn-success py-1 px-3 rounded-pill fw-bold" 
                                                data-bs-toggle="modal" data-bs-target="#restockModal"
                                                data-action="{{ route('stock.products.quick-stock', $ep->PID) }}"
                                                data-discard-action="{{ route('stock.products.discard-expired', $ep->PID) }}"
                                                data-pname="{{ $ep->PName }}"
                                                data-qty="{{ max(20, $ep->MinStock * 2) }}"
                                                data-default-date="{{ \Carbon\Carbon::today()->addMonths(6)->format('Y-m-d') }}"
                                                title="Receive New Delivery with Fresh Expiry Date">
                                            <i class="bi bi-box-seam me-1"></i> Restock
                                        </button>

                                        <a href="{{ route('stock.products.edit', $ep->PID) }}" class="btn btn-sm btn-outline-secondary py-1 px-2 rounded-pill" title="Update Details">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
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

<!-- Receive New Stock Modal -->
<div class="modal fade" id="restockModal" tabindex="-1" aria-labelledby="restockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-warning bg-opacity-25 text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-box-arrow-in-down fs-5 text-dark"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-dark mb-0" id="restockModalLabel">Receive New Stock Delivery</h6>
                        <small class="text-muted" id="restockProductSub">Restock batch</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="restockForm" method="POST" action="">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info py-2 px-3 small rounded-3 border-0 d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                        <span>Enter the <strong>fresh quantity received</strong> and the <strong>new expiration date</strong> printed on the packaging to renew the product.</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Total Quantity (Units) <span class="text-danger">*</span></label>
                        <input type="number" name="Qty" id="modalQty" min="1" class="form-control" required>
                        <div class="form-text small">Total available units ready for the supermarket shelves.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">New Batch Expiration Date <span class="text-danger">*</span></label>
                        <input type="date" name="ExpiredDate" id="modalExpiredDate" class="form-control" required>
                        <div class="form-text small">Shelf expiry date printed on the newly arrived shipment.</div>
                    </div>
                </div>
                <div class="modal-footer border-top py-2 px-4 d-flex justify-content-between align-items-center">
                    <button type="submit" form="modalDiscardForm" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold" id="btnModalDiscard" style="display: none;" onclick="return confirm('Discard all units of this product from shelves to waste write-off?');">
                        <i class="bi bi-trash3 me-1"></i> Discard to 0
                    </button>

                    <div class="d-flex gap-2 ms-auto">
                        <button type="button" class="btn btn-sm btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold">
                            <i class="bi bi-check2-circle me-1"></i> Save Fresh Stock & Expiry
                        </button>
                    </div>
                </div>
            </form>
            <form id="modalDiscardForm" method="POST" action="" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const restockModal = document.getElementById('restockModal');
    if (restockModal) {
        restockModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const actionUrl = button.getAttribute('data-action');
            const discardActionUrl = button.getAttribute('data-discard-action');
            const pname = button.getAttribute('data-pname');
            const qty = button.getAttribute('data-qty');
            const defaultDate = button.getAttribute('data-default-date') || '';

            document.getElementById('restockForm').action = actionUrl;
            document.getElementById('restockProductSub').textContent = pname;
            document.getElementById('modalQty').value = qty;
            document.getElementById('modalExpiredDate').value = defaultDate;

            const discardBtn = document.getElementById('btnModalDiscard');
            if (discardActionUrl && discardBtn) {
                document.getElementById('modalDiscardForm').action = discardActionUrl;
                discardBtn.style.display = 'inline-block';
            } else if (discardBtn) {
                discardBtn.style.display = 'none';
            }
        });
    }
});
</script>
@endsection
