@extends('layouts.app')

@section('title', $product->PName . ' - FreshMart')

@section('content')
<div class="container pb-5">

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog') }}" class="text-decoration-none text-muted">Groceries</a></li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('catalog', ['category' => $product->CatID]) }}" class="text-decoration-none text-muted">
                        {{ $product->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active fw-semibold text-dark" aria-current="page">{{ $product->PName }}</li>
        </ol>
    </nav>

    <!-- Product Showcase Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-5">
        <div class="row g-0">
            <!-- Left: Product Image -->
            <div class="col-md-5 bg-light p-4 d-flex align-items-center justify-content-center" style="min-height: 380px;">
                <img src="{{ $product->image_url }}" alt="{{ $product->PName }}" class="img-fluid rounded-3" style="max-height: 320px; object-fit: contain;">
            </div>

            <!-- Right: Product Info & Actions -->
            <div class="col-md-7 p-4 p-lg-5 d-flex flex-column justify-content-center">
                <div class="mb-2">
                    <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill">
                        <i class="bi bi-tag-fill me-1"></i> {{ $product->category->name ?? 'General' }}
                    </span>
                </div>

                <h2 class="fw-extrabold text-dark mb-2" style="font-weight: 800;">{{ $product->PName }}</h2>
                <div class="text-muted small mb-3">Item Code: <code>SKU-{{ str_pad($product->PID, 5, '0', STR_PAD_LEFT) }}</code></div>

                <div class="d-flex align-items-baseline gap-3 mb-4">
                    <div class="display-5 fw-bold text-dark">${{ number_format($product->Price, 2) }}</div>
                    <span class="text-muted small">Inclusive of standard handling</span>
                </div>

                <!-- Stock & Expiry Indicators -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @if($product->Qty <= 0)
                        <span class="badge bg-danger px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-x-circle me-1"></i> Out of Stock
                        </span>
                    @elseif($product->isLowStock())
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Low Stock: Only {{ $product->Qty }} units remaining!
                        </span>
                    @else
                        <span class="badge bg-success px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-check-circle-fill me-1"></i> In Stock ({{ $product->Qty }} available)
                        </span>
                    @endif

                    @if($product->ExpiredDate)
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-calendar-event me-1"></i> Best Before: {{ \Carbon\Carbon::parse($product->ExpiredDate)->format('M d, Y') }}
                        </span>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-2">Product Description</h6>
                    <p class="text-muted mb-0" style="line-height: 1.6;">
                        {{ $product->description ?: 'No detailed description provided for this supermarket item.' }}
                    </p>
                </div>

                <!-- Add to Cart Form -->
                @if($product->Qty > 0)
                    <form action="{{ route('cart.add', $product->PID) }}" method="POST" class="d-flex align-items-center gap-3">
                        @csrf
                        <div class="input-group" style="width: 140px;">
                            <span class="input-group-text bg-light border-end-0">Qty</span>
                            <input type="number" name="quantity" class="form-control text-center bg-light" value="1" min="1" max="{{ $product->Qty }}" required>
                        </div>

                        <button type="submit" class="btn btn-fresh btn-lg px-4 rounded-pill shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-cart-plus-fill"></i> Add to Shopping Cart
                        </button>
                    </form>
                @else
                    <div class="alert alert-secondary rounded-4 border-0 d-flex align-items-center gap-2 mb-0">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <div>This item is currently sold out. Our stock team has been notified for replenishment.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <h4 class="fw-bold mb-4">You May Also Like in {{ $product->category->name ?? 'This Department' }}</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @foreach($relatedProducts as $rel)
                    <div class="col">
                        <div class="product-card position-relative" style="cursor: pointer;" 
                             onclick="window.location='{{ route('product.detail', $rel->PID) }}';">
                            <a href="{{ route('product.detail', $rel->PID) }}" class="product-img-wrap text-decoration-none d-flex">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->PName }}" loading="lazy">
                            </a>
                            <div class="card-body p-3 d-flex flex-column flex-grow-1">
                                <h6 class="fw-bold text-dark mb-2 text-truncate-2" style="font-size: 0.95rem; height: 2.8rem; overflow: hidden;">
                                    <a href="{{ route('product.detail', $rel->PID) }}" class="text-decoration-none text-dark">
                                        {{ $rel->PName }}
                                    </a>
                                </h6>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="price-tag">${{ number_format($rel->Price, 2) }}</span>
                                    <a href="{{ route('product.detail', $rel->PID) }}" class="btn btn-sm btn-outline-fresh rounded-pill px-3">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
