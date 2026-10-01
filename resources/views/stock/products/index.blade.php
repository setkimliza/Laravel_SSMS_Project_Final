@extends('layouts.admin')

@section('title', 'Product Management - FreshMart SSMS')
@section('page-title', 'Supermarket Products Catalog (CRUD)')
@section('page-subtitle', 'Manage product details, pricing, live inventory counts, and expiration dates')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <!-- Filter Toolbar -->
    <div class="card bg-light border-0 rounded-4 p-3 mb-4">
        <form action="{{ route('stock.products.index') }}" method="GET" class="row g-2 align-items-center">
            <!-- Search -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 rounded-end-pill ps-0" 
                           placeholder="Search product or SKU..." value="{{ request('search') }}">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="col-6 col-md-3 col-lg-2">
                <select name="category" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->CatID }}" {{ request('category') == $cat->CatID ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Stock Status Filter -->
            <div class="col-6 col-md-3 col-lg-2">
                <select name="stock_status" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">All Stock Levels</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (&le; Min)</option>
                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock (0)</option>
                    <option value="healthy" {{ request('stock_status') == 'healthy' ? 'selected' : '' }}>Healthy Stock</option>
                </select>
            </div>

            <!-- Expiry Status Filter -->
            <div class="col-6 col-md-3 col-lg-2">
                <select name="expiry_status" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">All Expiries</option>
                    <option value="expired" {{ request('expiry_status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="expiring_soon" {{ request('expiry_status') == 'expiring_soon' ? 'selected' : '' }}>Expiring Soon (30d)</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="col-6 col-md-auto d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3">Filter</button>
                @if(request()->anyFilled(['search', 'category', 'stock_status', 'expiry_status']))
                    <a href="{{ route('stock.products.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2">Clear</a>
                @endif
            </div>

            <!-- Add Product (Pushed to Right) -->
            <div class="col-12 col-lg text-lg-end mt-2 mt-lg-0">
                <a href="{{ route('stock.products.create') }}" class="btn btn-sm btn-success rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 text-nowrap">
                    <i class="bi bi-plus-lg"></i> Add New Product
                </a>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">PID</th>
                    <th>Product</th>
                    <th>Department</th>
                    <th class="text-end">Price</th>
                    <th class="text-center">Stock / Min</th>
                    <th>Expiration</th>
                    <th class="text-center">Quick Adjust</th>
                    <th class="pe-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="ps-3 fw-bold text-muted">#{{ str_pad($product->PID, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $product->image_url }}" alt="{{ $product->PName }}" 
                                     class="rounded-3 border" style="width: 44px; height: 44px; object-fit: contain; background: #f8fafc;">
                                <div>
                                    <div class="fw-bold text-dark">{{ $product->PName }}</div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                        @if($product->Qty <= 0)
                                            <span class="text-danger fw-bold"><i class="bi bi-x-circle me-1"></i>Out of Stock</span>
                                        @elseif($product->isLowStock())
                                            <span class="text-warning fw-bold"><i class="bi bi-exclamation-circle me-1"></i>Low Stock Alert</span>
                                        @else
                                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>In Stock</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $product->category->name ?? 'General' }}</span>
                        </td>
                        <td class="text-end fw-bold text-dark">${{ number_format($product->Price, 2) }}</td>
                        <td class="text-center">
                            <span class="badge {{ $product->Qty <= 0 ? 'bg-danger' : ($product->isLowStock() ? 'bg-warning text-dark' : 'bg-success') }} rounded-pill px-3 py-1">
                                {{ $product->Qty }} units
                            </span>
                            <div class="text-muted small" style="font-size: 0.72rem;">Min: {{ $product->MinStock }}</div>
                        </td>
                        <td>
                            @if($product->ExpiredDate)
                                <div class="{{ $product->isExpired() ? 'text-danger fw-bold' : ($product->isExpiringSoon(30) ? 'text-warning-emphasis fw-bold' : 'text-secondary small') }}">
                                    {{ \Carbon\Carbon::parse($product->ExpiredDate)->format('M d, Y') }}
                                </div>
                                @if($product->isExpired())
                                    <span class="badge bg-danger" style="font-size: 0.65rem;">EXPIRED</span>
                                @elseif($product->isExpiringSoon(30))
                                    <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">EXPIRING SOON</span>
                                @endif
                            @else
                                <span class="text-muted small">No Expiry</span>
                            @endif
                        </td>
                        <td class="text-center" style="width: 150px;">
                            <!-- Inline Stock Quick Adjustment Form -->
                            <form action="{{ route('stock.products.quick-stock', $product->PID) }}" method="POST" class="d-inline-flex gap-1 align-items-center">
                                @csrf
                                <input type="number" name="Qty" value="{{ $product->Qty }}" min="0" 
                                       class="form-control form-control-sm text-center py-0" style="width: 65px;" required>
                                <button type="submit" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill" title="Update Stock">
                                    <i class="bi bi-check2"></i>
                                </button>
                            </form>
                        </td>
                        <td class="pe-3 text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('stock.products.edit', $product->PID) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="Edit Product">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2" 
                                        data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                                        data-action="{{ route('stock.products.destroy', $product->PID) }}"
                                        data-name="{{ $product->PName }}"
                                        data-id="#{{ str_pad($product->PID, 4, '0', STR_PAD_LEFT) }}"
                                        data-type="Product"
                                        title="{{ ($product->order_details_count ?? 0) > 0 ? 'Cannot delete: linked to ' . $product->order_details_count . ' order transaction(s)' : 'Delete Product' }}" 
                                        {{ ($product->order_details_count ?? 0) > 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            No products found matching the specified filters.
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
