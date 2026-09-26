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
                            <form action="{{ route('stock.products.quick-stock', $product->PID) }}" method="POST" class="d-inline-flex gap-1 justify-content-end align-items-center">
                                @csrf
                                <input type="number" name="Qty" value="{{ max($product->Qty + 20, $product->MinStock * 2) }}" min="0" class="form-control form-control-sm text-center" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-2" title="Save New Qty">
                                    <i class="bi bi-check2"></i> Restock
                                </button>
                            </form>
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
@endsection
