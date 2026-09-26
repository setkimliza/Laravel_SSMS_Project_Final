@extends('layouts.app')

@section('title', 'FreshMart - Fresh Groceries, Dairy, Beverages & Supermarket Essentials')

@section('content')
<div class="container pb-5">

    <!-- Hero Showcase Banner -->
    <div class="rounded-5 overflow-hidden shadow-sm mb-5 position-relative text-white" 
         style="background: linear-gradient(135deg, #064e3b 0%, #059669 50%, #10b981 100%);">
        <div class="row align-items-center g-0 p-4 p-md-5">
            <div class="col-lg-7 p-3 p-md-4">
                <span class="badge bg-white text-success fw-bold px-3 py-2 rounded-pill mb-3">
                    <i class="bi bi-stars me-1"></i> Everyday Low Supermarket Prices
                </span>
                <h1 class="display-4 fw-extrabold text-white mb-3" style="letter-spacing: -1px; font-weight: 800;">
                    Fresh Quality Groceries Delivered Right to Your Door.
                </h1>
                <p class="lead text-white-50 mb-4" style="max-width: 540px;">
                    Shop over 1,000+ hand-picked fresh supermarket items, dairy, snacks, bakery, beverages, and pantry staples with guaranteed freshness.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('catalog') }}" class="btn btn-light text-dark fw-bold rounded-pill px-4 py-3 shadow-sm">
                        <i class="bi bi-bag-check-fill text-success me-2"></i> Start Shopping Now
                    </a>
                    <a href="{{ route('catalog') }}?in_stock=1" class="btn btn-outline-light fw-bold rounded-pill px-4 py-3">
                        <i class="bi bi-lightning-charge me-1"></i> View In-Stock Items
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block p-4">
                <div class="bg-white bg-opacity-10 p-4 rounded-4 backdrop-blur border border-white border-opacity-20 text-center">
                    <i class="bi bi-cart4 text-white display-1 mb-3"></i>
                    <h4 class="text-white fw-bold">Smart Grocery Shopping</h4>
                    <p class="text-white-50 small mb-0">Live stock tracking, automated freshness inspection & instant checkout</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Value Propositions -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white d-flex flex-row align-items-center gap-3">
                <div class="rounded-circle bg-success-subtle text-success p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                    <i class="bi bi-shield-check fs-3"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Guaranteed Freshness</h6>
                    <p class="text-muted small mb-0">Carefully monitored expiration dates on every product</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white d-flex flex-row align-items-center gap-3">
                <div class="rounded-circle bg-primary-subtle text-primary p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                    <i class="bi bi-truck fs-3"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Fast Delivery & Pickup</h6>
                    <p class="text-muted small mb-0">Free doorstep delivery on eligible supermarket orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white d-flex flex-row align-items-center gap-3">
                <div class="rounded-circle bg-warning-subtle text-warning-emphasis p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                    <i class="bi bi-tag-fill fs-3"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Supermarket Value</h6>
                    <p class="text-muted small mb-0">Best wholesale & retail pricing directly to consumers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-success fw-bold text-uppercase small" style="letter-spacing: 1px;">Categories</span>
                <h3 class="fw-bold mb-0">Explore Departments</h3>
            </div>
            <a href="{{ route('catalog') }}" class="btn btn-sm btn-outline-fresh">
                All Departments <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3">
            @foreach($categories as $category)
                <div class="col">
                    <a href="{{ route('catalog', ['category' => $category->CatID]) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 bg-white transition hover-shadow" 
                             style="transition: all 0.2s ease;">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-2 text-success" 
                                 style="width: 54px; height: 54px; font-size: 1.4rem;">
                                <i class="bi {{ $category->icon ?: 'bi-basket2' }}"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $category->name }}</h6>
                            <span class="text-muted small">{{ $category->products_count }} items</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Fresh Arrivals Showcase -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-success fw-bold text-uppercase small" style="letter-spacing: 1px;">Fresh In Stock</span>
                <h3 class="fw-bold mb-0">Featured Supermarket Items</h3>
            </div>
            <a href="{{ route('catalog') }}" class="btn btn-sm btn-outline-fresh">
                Browse Full Catalog <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($latestProducts as $product)
                <div class="col">
                    <div class="product-card position-relative" style="cursor: pointer;" 
                         onclick="if (!event.target.closest('form') && !event.target.closest('button')) window.location='{{ route('product.detail', $product->PID) }}';">
                        <!-- Product Image Wrapper -->
                        <a href="{{ route('product.detail', $product->PID) }}" class="product-img-wrap text-decoration-none d-flex">
                            <img src="{{ $product->image_url }}" alt="{{ $product->PName }}" loading="lazy">
                            
                            @if($product->isLowStock())
                                <span class="badge badge-stock bg-warning text-dark">
                                    <i class="bi bi-exclamation-circle-fill me-1"></i> Only {{ $product->Qty }} Left!
                                </span>
                            @else
                                <span class="badge badge-stock bg-success">
                                    <i class="bi bi-check-circle me-1"></i> In Stock
                                </span>
                            @endif
                        </a>

                        <!-- Product Content -->
                        <div class="card-body p-3 d-flex flex-column flex-grow-1">
                            <div class="badge-category mb-1">{{ $product->category->name ?? 'Grocery' }}</div>
                            <h6 class="fw-bold text-dark mb-2 text-truncate-2" style="font-size: 0.95rem; height: 2.8rem; overflow: hidden;">
                                <a href="{{ route('product.detail', $product->PID) }}" class="text-decoration-none text-dark">
                                    {{ $product->PName }}
                                </a>
                            </h6>

                            <div class="mt-auto pt-2 d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small">Price:</span>
                                    <div class="price-tag">${{ number_format($product->Price, 2) }}</div>
                                </div>

                                <form action="{{ route('cart.add', $product->PID) }}" method="POST" onclick="event.stopPropagation();">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-fresh btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-cart-plus"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Callout Banner -->
    <div class="card border-0 rounded-4 shadow-sm bg-dark text-white p-4 p-md-5 my-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold mb-2">Need Bulk Restocking or Institutional Supply?</h3>
                <p class="text-white-50 mb-0">FreshMart SSMS offers automated inventory alerts, batch shelf management, and daily sales analysis.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('staff.login') }}" class="btn btn-outline-light rounded-pill px-4 py-2">
                    <i class="bi bi-shield-lock me-1"></i> Staff Login Portal
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
