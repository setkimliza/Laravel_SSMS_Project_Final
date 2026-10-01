@extends('layouts.admin')

@section('title', 'Inventory Alerts - FreshMart SSMS')
@section('page-title', 'Inventory Warnings & Shelf Expiry Alerts')
@section('page-subtitle', 'Track low-stock products below safety thresholds and expired items')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <!-- Filters Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div class="btn-group rounded-pill p-1 bg-light border" role="group">
            <a href="{{ route('stock.alerts', ['filter' => 'all']) }}" 
               class="btn btn-sm rounded-pill px-3 {{ $filter === 'all' ? 'btn-dark' : 'btn-light' }}">
                All Warnings
            </a>
            <a href="{{ route('stock.alerts', ['filter' => 'low_stock']) }}" 
               class="btn btn-sm rounded-pill px-3 {{ $filter === 'low_stock' ? 'btn-warning text-dark' : 'btn-light' }}">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Low Stock
            </a>
            <a href="{{ route('stock.alerts', ['filter' => 'expired']) }}" 
               class="btn btn-sm rounded-pill px-3 {{ $filter === 'expired' ? 'btn-danger' : 'btn-light' }}">
                <i class="bi bi-calendar-x-fill me-1"></i> Expired
            </a>
            <a href="{{ route('stock.alerts', ['filter' => 'expiring_soon']) }}" 
               class="btn btn-sm rounded-pill px-3 {{ $filter === 'expiring_soon' ? 'btn-info text-dark' : 'btn-light' }}">
                <i class="bi bi-clock-history me-1"></i> Expiring Soon (30d)
            </a>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="window.print();">
                <i class="bi bi-printer me-1"></i> Print Warning Sheet
            </button>
            <a href="{{ route('stock.products.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                All Products
            </a>
        </div>
    </div>

    <!-- Alerts Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">PID</th>
                    <th>Product</th>
                    <th>Department</th>
                    <th class="text-center">Current Qty</th>
                    <th class="text-center">Min Stock</th>
                    <th>Expiry Date</th>
                    <th>Status Alert</th>
                    <th class="pe-3 text-end">Quick Restock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="ps-3 fw-bold text-muted">#{{ str_pad($product->PID, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $product->PName }}</div>
                            <div class="small text-muted">${{ number_format($product->Price, 2) }}</div>
                        </td>
                        <td>{{ $product->category->name ?? 'General' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $product->Qty <= 0 ? 'bg-danger' : ($product->isLowStock() ? 'bg-warning text-dark' : 'bg-success') }} rounded-pill fs-6 px-3">
                                {{ $product->Qty }}
                            </span>
                        </td>
                        <td class="text-center text-secondary fw-semibold">{{ $product->MinStock }}</td>
                        <td>
                            @if($product->ExpiredDate)
                                <span class="{{ $product->isExpired() ? 'text-danger fw-bold' : ($product->isExpiringSoon(30) ? 'text-warning-emphasis fw-bold' : 'text-secondary') }}">
                                    {{ \Carbon\Carbon::parse($product->ExpiredDate)->format('M d, Y') }}
                                </span>
                            @else
                                <span class="text-muted small">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                @if($product->Qty <= 0)
                                    <span class="badge bg-danger">OUT OF STOCK</span>
                                @elseif($product->isLowStock())
                                    <span class="badge bg-warning text-dark">LOW STOCK (&le; {{ $product->MinStock }})</span>
                                @endif

                                @if($product->isExpired())
                                    <span class="badge bg-danger">EXPIRED</span>
                                @elseif($product->isExpiringSoon(30))
                                    <span class="badge bg-info text-dark">EXPIRING SOON</span>
                                @endif
                            </div>
                        </td>
                        <td class="pe-3 text-end">
                            <div class="d-inline-flex gap-1 justify-content-end align-items-center">
                                @if($product->isExpired())
                                    <!-- Restock New Batch with New Expiry -->
                                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-bold" 
                                            data-bs-toggle="modal" data-bs-target="#restockModal"
                                            data-action="{{ route('stock.products.quick-stock', $product->PID) }}"
                                            data-discard-action="{{ route('stock.products.discard-expired', $product->PID) }}"
                                            data-pname="{{ $product->PName }}"
                                            data-qty="{{ max(20, $product->MinStock * 2) }}"
                                            data-default-date="{{ \Carbon\Carbon::today()->addMonths(6)->format('Y-m-d') }}"
                                            title="Receive New Batch with Fresh Expiration Date">
                                        <i class="bi bi-box-seam me-1"></i> Restock
                                    </button>
                                @else
                                    <!-- Quick Restock Inline -->
                                    <form action="{{ route('stock.products.quick-stock', $product->PID) }}" method="POST" class="d-inline-flex gap-1 justify-content-end align-items-center">
                                        @csrf
                                        <input type="number" name="Qty" value="{{ max($product->Qty + 20, $product->MinStock * 2) }}" min="0" class="form-control form-control-sm text-center" style="width: 65px;">
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-2" title="Quick Restock Quantity">
                                            <i class="bi bi-check2"></i> Restock
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-2" 
                                            data-bs-toggle="modal" data-bs-target="#restockModal"
                                            data-action="{{ route('stock.products.quick-stock', $product->PID) }}"
                                            data-pname="{{ $product->PName }}"
                                            data-qty="{{ max($product->Qty + 20, $product->MinStock * 2) }}"
                                            data-default-date="{{ $product->ExpiredDate ? \Carbon\Carbon::parse($product->ExpiredDate)->format('Y-m-d') : \Carbon\Carbon::today()->addMonths(6)->format('Y-m-d') }}"
                                            title="Restock with New Date">
                                        <i class="bi bi-calendar-plus"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-shield-check text-success display-4 d-block mb-2"></i>
                            <span class="fw-bold">No inventory warnings under this filter. Everything looks great!</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
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
