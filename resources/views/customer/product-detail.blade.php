@extends('layouts.app')

@section('title', $product->PName . ' - FreshMart Supermarket')

@section('styles')
<style>
    /* Product Detail Redesign Styling */
    .product-detail-card {
        background: #ffffff;
        border-radius: 28px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05), 0 0 1px 1px rgba(226, 232, 240, 0.6);
        overflow: hidden;
    }

    /* Product Image Stage */
    .product-stage {
        background: radial-gradient(circle at 50% 50%, #ffffff 0%, #f8fafc 85%, #f1f5f9 100%);
        border-radius: 24px;
        position: relative;
        min-height: 480px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .product-hero-img {
        max-height: 370px;
        max-width: 86%;
        object-fit: contain;
        transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), filter 0.35s ease;
        filter: drop-shadow(0 18px 24px rgba(0, 0, 0, 0.09));
    }

    .product-stage:hover .product-hero-img {
        transform: scale(1.08) translateY(-6px);
        filter: drop-shadow(0 26px 32px rgba(0, 0, 0, 0.14));
    }

    .stage-badge-top-left {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 2;
    }

    .stage-actions-top-right {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .action-circle-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(6px);
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 1.15rem;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .action-circle-btn:hover {
        background: #ffffff;
        color: #ef4444;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .action-circle-btn.active {
        color: #ef4444;
        background: #fef2f2;
        border-color: #fecaca;
    }

    .stage-hint-bottom {
        position: absolute;
        bottom: 16px;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(8px);
        padding: 5px 14px;
        border-radius: 9999px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #64748b;
        border: 1px solid rgba(226, 232, 240, 0.8);
        pointer-events: none;
    }

    /* Pulse dot indicator */
    .pulse-dot-green {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border-radius: 50%;
        position: relative;
        margin-right: 8px;
    }

    .pulse-dot-green::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #10b981;
        animation: radarPulse 1.8s infinite;
    }

    @keyframes radarPulse {
        0% { transform: scale(1); opacity: 0.85; }
        100% { transform: scale(2.8); opacity: 0; }
    }

    /* Price Section */
    .price-display-box {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        border: 1.5px solid #bbf7d0;
        border-radius: 20px;
        padding: 1.25rem 1.6rem;
    }

    /* Stepper Styling */
    .stepper-container {
        display: inline-flex;
        align-items: center;
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 9999px;
        padding: 4px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    .stepper-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .stepper-btn:hover:not(:disabled) {
        background: var(--primary);
        color: white;
        transform: scale(1.06);
    }

    .stepper-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .stepper-input {
        width: 55px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 800;
        font-size: 1.2rem;
        color: #0f172a;
        outline: none;
    }

    .stepper-input::-webkit-outer-spin-button,
    .stepper-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* CTA buttons */
    .btn-add-cart {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        font-weight: 700;
        font-size: 1.05rem;
        border-radius: 9999px;
        padding: 0.85rem 1.85rem;
        border: none;
        box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-add-cart:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 14px 25px -5px rgba(16, 185, 129, 0.5);
    }

    .btn-buy-now {
        background: #0f172a;
        color: white;
        font-weight: 700;
        font-size: 1.05rem;
        border-radius: 9999px;
        padding: 0.85rem 1.65rem;
        border: none;
        box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.25);
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-buy-now:hover {
        background: #1e293b;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 14px 25px -5px rgba(15, 23, 42, 0.35);
    }

    /* Trust badges */
    .trust-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1rem 1.15rem;
        display: flex;
        align-items: center;
        gap: 14px;
        height: 100%;
        transition: all 0.25s ease;
    }

    .trust-card:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.04);
        transform: translateY(-2px);
    }

    .trust-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #ecfdf5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    /* Tabs Styling */
    .product-nav-tabs {
        border-bottom: 2px solid #e2e8f0;
    }

    .product-nav-tabs .nav-link {
        font-weight: 700;
        color: #64748b;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 0.9rem 1.6rem;
        font-size: 1rem;
        background: transparent;
        transition: all 0.2s ease;
    }

    .product-nav-tabs .nav-link:hover {
        color: #0f172a;
    }

    .product-nav-tabs .nav-link.active {
        color: var(--primary-dark);
        border-bottom-color: var(--primary);
        background: transparent;
    }

    /* Feature tags under image */
    .micro-tag {
        font-size: 0.78rem;
        font-weight: 600;
        color: #475569;
        background: #ffffff;
        padding: 6px 14px;
        border-radius: 9999px;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">

    <!-- Top Navigation Bar (Breadcrumb & Back Button) -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 py-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-house-door-fill me-1"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('catalog') }}" class="text-decoration-none text-muted">Groceries</a>
                </li>
                @if($product->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('catalog', ['category' => $product->CatID]) }}" class="text-decoration-none text-muted">
                            {{ $product->category->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active fw-bold text-dark text-truncate" style="max-width: 280px;" aria-current="page">
                    {{ $product->PName }}
                </li>
            </ol>
        </nav>

        <a href="{{ $product->category ? route('catalog', ['category' => $product->CatID]) : route('catalog') }}" 
           class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm">
            <i class="bi bi-arrow-left"></i> Back to {{ $product->category->name ?? 'Groceries' }}
        </a>
    </div>

    <!-- Main Product Showcase Card -->
    <div class="product-detail-card mb-5">
        <div class="row g-0">
            
            <!-- Left Column: Product Image Showcase Stage -->
            <div class="col-lg-5 p-4 p-md-5 d-flex flex-column align-items-center justify-content-between border-end border-light">
                
                <div class="product-stage w-100">
                    <!-- Top Left Badge: Freshness / Category -->
                    <div class="stage-badge-top-left">
                        <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill fw-bold border d-inline-flex align-items-center gap-1">
                            <i class="bi bi-shield-check text-success"></i> 100% Genuine
                        </span>
                    </div>

                    <!-- Top Right Quick Actions: Wishlist & Share -->
                    <div class="stage-actions-top-right">
                        <button type="button" class="action-circle-btn" id="wishlist-btn" title="Add to Wishlist" onclick="toggleWishlist(this)">
                            <i class="bi bi-heart"></i>
                        </button>
                        <button type="button" class="action-circle-btn" id="share-btn" title="Share Product" onclick="shareProduct()">
                            <i class="bi bi-share"></i>
                        </button>
                    </div>

                    <!-- Product Image -->
                    <img src="{{ $product->image_url }}" 
                         alt="{{ $product->PName }}" 
                         class="product-hero-img img-fluid"
                         id="main-product-img">

                    <!-- Zoom Hint -->
                    <div class="stage-hint-bottom">
                        <i class="bi bi-search me-1"></i> Hover to Zoom Image
                    </div>
                </div>

                <!-- Micro Quality Badges below Image -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-3 pt-2">
                    <span class="micro-tag">
                        <i class="bi bi-snow text-primary"></i> Climate Controlled
                    </span>
                    <span class="micro-tag">
                        <i class="bi bi-box-seam text-success"></i> Sealed Packaging
                    </span>
                    <span class="micro-tag">
                        <i class="bi bi-lightning-charge text-warning"></i> Quick Store Dispatch
                    </span>
                </div>

            </div>

            <!-- Right Column: Product Info & Commerce Actions -->
            <div class="col-lg-7 p-4 p-lg-5 d-flex flex-column justify-content-between">
                <div>
                    
                    <!-- Department & Rating Header -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-2 rounded-pill fw-bold fs-7 d-inline-flex align-items-center gap-1">
                            <i class="bi bi-tag-fill"></i> {{ $product->category->name ?? 'Grocery Essentials' }}
                        </span>

                        <div class="d-flex align-items-center gap-2 small">
                            <div class="text-warning d-inline-flex align-items-center gap-1">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="fw-bold text-dark ms-1">4.9</span>
                            </div>
                            <span class="text-muted">(128 verified reviews)</span>
                        </div>
                    </div>

                    <!-- Product Title -->
                    <h1 class="fw-extrabold text-dark mb-2" style="font-size: 2.15rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.25;">
                        {{ $product->PName }}
                    </h1>

                    <!-- SKU & Inventory Barcode Pill -->
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="text-muted small">Item SKU:</span>
                        <span class="badge bg-light text-secondary border font-monospace px-2 py-1" style="cursor: pointer;" title="Click to copy SKU" onclick="copySku('SKU-{{ str_pad($product->PID, 5, '0', STR_PAD_LEFT) }}')">
                            <code>SKU-{{ str_pad($product->PID, 5, '0', STR_PAD_LEFT) }}</code> <i class="bi bi-copy ms-1 small"></i>
                        </span>
                        <span class="badge bg-light text-muted border px-2 py-1 small">
                            Department: {{ $product->category->name ?? 'General' }}
                        </span>
                    </div>

                    <!-- Modern Pricing Display Box -->
                    <div class="price-display-box mb-4">
                        <div class="d-flex flex-wrap align-items-baseline justify-content-between gap-3">
                            <div>
                                <div class="d-flex align-items-baseline gap-3">
                                    <span class="display-5 fw-extrabold text-dark" style="font-weight: 800;">${{ number_format($product->Price, 2) }}</span>
                                    <span class="text-muted text-decoration-line-through fs-5">${{ number_format($product->Price * 1.18, 2) }}</span>
                                    <span class="badge bg-danger text-white rounded-pill px-2 py-1 fw-bold fs-7">Save 15%</span>
                                </div>
                                <div class="small text-muted mt-1 d-flex align-items-center gap-2">
                                    <i class="bi bi-check2-circle text-success fw-bold"></i> Guaranteed supermarket shelf price • Taxes included
                                </div>
                            </div>

                            <div class="text-end d-none d-sm-block">
                                <span class="badge bg-success text-white px-3 py-1 rounded-pill small fw-semibold">
                                    <i class="bi bi-truck me-1"></i> Fast Delivery
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Status & Freshness Guarantee Card -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-4 border h-100">
                                <div class="text-muted small mb-1 fw-semibold">Availability Status</div>
                                @if($product->Qty <= 0)
                                    <div class="d-flex align-items-center text-danger fw-bold fs-6">
                                        <i class="bi bi-x-circle-fill me-2 fs-5"></i> Currently Sold Out
                                    </div>
                                    <small class="text-muted d-block mt-1">Restock expected in 24-48 hours</small>
                                @elseif($product->isLowStock())
                                    <div class="d-flex align-items-center text-warning-emphasis fw-bold fs-6">
                                        <i class="bi bi-exclamation-triangle-fill text-warning me-2 fs-5"></i> Low Stock Alert
                                    </div>
                                    <small class="text-dark fw-semibold d-block mt-1">Only <strong>{{ $product->Qty }}</strong> units remaining!</small>
                                @else
                                    <div class="d-flex align-items-center text-success fw-bold fs-6">
                                        <span class="pulse-dot-green"></span> In Stock & Ready to Ship
                                    </div>
                                    <small class="text-muted d-block mt-1"><strong>{{ $product->Qty }}</strong> units ready in local warehouse</small>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-4 border h-100">
                                <div class="text-muted small mb-1 fw-semibold">Freshness Guarantee</div>
                                @if($product->ExpiredDate)
                                    <div class="d-flex align-items-center text-dark fw-bold fs-6">
                                        <i class="bi bi-calendar2-check-fill text-success me-2 fs-5"></i> 
                                        Best Before: {{ \Carbon\Carbon::parse($product->ExpiredDate)->format('M d, Y') }}
                                    </div>
                                    <small class="text-muted d-block mt-1">Handpicked fresh before packaging</small>
                                @else
                                    <div class="d-flex align-items-center text-dark fw-bold fs-6">
                                        <i class="bi bi-patch-check-fill text-primary me-2 fs-5"></i> Guaranteed Fresh
                                    </div>
                                    <small class="text-muted d-block mt-1">100% Quality checked standard</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Brief Description Highlight -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle text-primary"></i> Product Overview
                        </h6>
                        <p class="text-secondary mb-0" style="line-height: 1.65; font-size: 0.98rem;">
                            {{ $product->description ?: 'Premium quality supermarket item sourced directly from certified suppliers. Guaranteed authentic and freshly packaged for your daily convenience.' }}
                        </p>
                    </div>

                </div>

                <!-- Add to Cart & Buy Now Action Section -->
                <div class="pt-3 border-top mt-3">
                    @if($product->Qty > 0)
                        <form action="{{ route('cart.add', $product->PID) }}" method="POST" id="add-to-cart-form">
                            @csrf
                            
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                                
                                <!-- Sleek Stepper Component -->
                                <div class="d-flex align-items-center gap-3">
                                    <span class="fw-bold text-dark small">Quantity:</span>
                                    <div class="stepper-container">
                                        <button type="button" class="stepper-btn" id="btn-qty-minus" onclick="decrementQty()" aria-label="Decrease quantity">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" 
                                               name="quantity" 
                                               id="product-quantity-input" 
                                               class="stepper-input" 
                                               value="1" 
                                               min="1" 
                                               max="{{ $product->Qty }}" 
                                               data-unit-price="{{ $product->Price }}"
                                               required
                                               onchange="updateSubtotal()"
                                               oninput="updateSubtotal()">
                                        <button type="button" class="stepper-btn" id="btn-qty-plus" onclick="incrementQty({{ $product->Qty }})" aria-label="Increase quantity">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Live Dynamic Subtotal Calculator -->
                                <div class="text-end">
                                    <span class="text-muted small d-block">Subtotal:</span>
                                    <span class="fs-4 fw-extrabold text-success" id="live-subtotal-display">
                                        ${{ number_format($product->Price, 2) }}
                                    </span>
                                </div>

                            </div>

                            <!-- Buttons: Add to Cart & Buy Now -->
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <button type="submit" name="action" value="add" class="btn-add-cart flex-grow-1 shadow">
                                    <i class="bi bi-cart-plus-fill fs-5"></i> Add to Shopping Cart
                                </button>
                                
                                <button type="submit" name="action" value="buy_now" class="btn-buy-now px-4">
                                    <i class="bi bi-lightning-fill text-warning"></i> Buy Now
                                </button>
                            </div>

                        </form>
                    @else
                        <!-- Out of Stock Notification Alert -->
                        <div class="alert alert-secondary rounded-4 border-0 p-3 d-flex align-items-center gap-3 mb-0">
                            <div class="fs-3 text-danger"><i class="bi bi-exclamation-octagon-fill"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">This item is currently sold out</h6>
                                <p class="small text-muted mb-0">Our stock replenishment team has been notified. You can browse other fresh groceries below.</p>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

        </div>

        <!-- Trust Badges Strip -->
        <div class="bg-light p-4 border-top">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="trust-card">
                        <div class="trust-card-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Express Local Delivery</h6>
                            <small class="text-muted">Delivered fresh in 30-45 minutes</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="trust-card">
                        <div class="trust-card-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">100% Fresh Guarantee</h6>
                            <small class="text-muted">Instant refund or replacement</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="trust-card">
                        <div class="trust-card-icon">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Safe & Flexible Payment</h6>
                            <small class="text-muted">Cash on delivery or card checkout</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Product Deep-Dive Information Tabs -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5 mb-5">
        <ul class="nav product-nav-tabs mb-4" id="productDetailTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-tab-pane" type="button" role="tab">
                    <i class="bi bi-card-checklist me-2"></i> Specifications & Details
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="freshness-tab" data-bs-toggle="tab" data-bs-target="#freshness-tab-pane" type="button" role="tab">
                    <i class="bi bi-flower1 me-2"></i> Quality & Storage
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab">
                    <i class="bi bi-chat-heart me-2"></i> Customer Reviews (128)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="productDetailTabsContent">
            
            <!-- Tab 1: Specifications -->
            <div class="tab-pane fade show active" id="specs-tab-pane" role="tabpanel" tabindex="0">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <h5 class="fw-bold text-dark mb-3">Item Specifications</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="bg-light text-muted w-25">Product Name</th>
                                        <td class="fw-semibold text-dark">{{ $product->PName }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Category</th>
                                        <td>
                                            <span class="badge bg-success-subtle text-success fw-bold px-2 py-1">
                                                {{ $product->category->name ?? 'General Grocery' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Stock Keeping Unit</th>
                                        <td><code>SKU-{{ str_pad($product->PID, 5, '0', STR_PAD_LEFT) }}</code></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Current Shelf Quantity</th>
                                        <td class="fw-bold {{ $product->Qty > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $product->Qty }} units available
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Best Before Date</th>
                                        <td>{{ $product->ExpiredDate ? \Carbon\Carbon::parse($product->ExpiredDate)->format('F d, Y') : 'Fresh Stock (Check packaging)' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Packaging</th>
                                        <td>Factory sealed retail packaging</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="p-4 bg-light rounded-4 h-100 border">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-lock-fill text-success me-2"></i> FreshMart Supermarket Standard</h6>
                            <p class="small text-muted mb-3" style="line-height: 1.6;">
                                Every item listed on FreshMart passes rigorous barcode verification, batch expiration tracking, and stock rotation audits before placement on our shelves.
                            </p>
                            <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-0">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Verified distributor supply chain</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> FIFO inventory freshness management</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Temperature-managed storage facilities</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Quality & Storage -->
            <div class="tab-pane fade" id="freshness-tab-pane" role="tabpanel" tabindex="0">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold text-dark mb-3">Storage & Handling Recommendations</h5>
                        <p class="text-secondary" style="line-height: 1.7;">
                            To ensure optimal taste, crispness, and freshness, keep this product stored in a cool, dry place away from direct sunlight, excess moisture, and extreme heat.
                        </p>
                        <div class="p-3 bg-light rounded-4 border mb-3">
                            <div class="fw-bold text-dark small mb-1"><i class="bi bi-thermometer-half text-danger me-1"></i> Recommended Storage Temp</div>
                            <div class="text-muted small">15°C - 22°C (Room Temperature or cool pantry)</div>
                        </div>
                        <div class="p-3 bg-light rounded-4 border">
                            <div class="fw-bold text-dark small mb-1"><i class="bi bi-droplet-half text-info me-1"></i> Moisture Protection</div>
                            <div class="text-muted small">Reseal tightly after opening to preserve aroma and crunchiness.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="fw-bold text-dark mb-3">Our 100% Satisfaction Policy</h5>
                        <p class="text-secondary" style="line-height: 1.7;">
                            We take pride in delivering only the freshest supermarket goods. If your package arrives damaged, unsealed, or past its prime, we will issue an immediate refund or replacement with zero hassles.
                        </p>
                        <div class="d-flex align-items-center gap-3 p-3 bg-success-subtle rounded-4 border border-success-subtle">
                            <i class="bi bi-patch-check-fill text-success fs-1"></i>
                            <div>
                                <h6 class="fw-bold text-success-emphasis mb-0">Hassle-Free Guarantee</h6>
                                <small class="text-success-emphasis">Contact our customer service team within 24 hours of delivery.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Customer Reviews -->
            <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" tabindex="0">
                <div class="row g-4 align-items-center mb-4">
                    <div class="col-md-4 text-center p-4 bg-light rounded-4 border">
                        <div class="display-4 fw-extrabold text-dark mb-1">4.9</div>
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <div class="text-muted small">Based on 128 verified customer reviews</div>
                    </div>

                    <div class="col-md-8">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <span class="small fw-bold text-muted" style="width: 50px;">5 Star</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 92%;"></div>
                                </div>
                                <span class="small text-muted" style="width: 35px;">92%</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="small fw-bold text-muted" style="width: 50px;">4 Star</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: 6%;"></div>
                                </div>
                                <span class="small text-muted" style="width: 35px;">6%</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="small fw-bold text-muted" style="width: 50px;">3 Star</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 2%;"></div>
                                </div>
                                <span class="small text-muted" style="width: 35px;">2%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verified Reviews List -->
                <div class="d-flex flex-column gap-3">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-dark">Sarah M. <span class="badge bg-success-subtle text-success ms-2 small"><i class="bi bi-check2"></i> Verified Buyer</span></span>
                            <span class="text-muted small">3 days ago</span>
                        </div>
                        <div class="text-warning small mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p class="small text-secondary mb-0">Arrived super fresh and in perfect condition! Delivered right to my door in under 40 minutes.</p>
                    </div>

                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-dark">David K. <span class="badge bg-success-subtle text-success ms-2 small"><i class="bi bi-check2"></i> Verified Buyer</span></span>
                            <span class="text-muted small">1 week ago</span>
                        </div>
                        <div class="text-warning small mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p class="small text-secondary mb-0">Genuine product, long expiry date, very reasonable supermarket prices. Highly recommended!</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Related Products ("You May Also Like") Section -->
    @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                <div>
                    <span class="text-success fw-bold text-uppercase small letter-spacing-1">Related Suggestions</span>
                    <h3 class="fw-extrabold text-dark mb-0" style="font-weight: 800;">
                        You May Also Like in {{ $product->category->name ?? 'This Department' }}
                    </h3>
                </div>

                @if($product->category)
                    <a href="{{ route('catalog', ['category' => $product->CatID]) }}" class="btn btn-sm btn-outline-fresh rounded-pill px-3 fw-semibold">
                        View All {{ $product->category->name }} <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                @endif
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @foreach($relatedProducts as $rel)
                    <div class="col">
                        <div class="product-card position-relative h-100" style="cursor: pointer;" 
                             onclick="window.location='{{ route('product.detail', $rel->PID) }}';">
                            
                            <a href="{{ route('product.detail', $rel->PID) }}" class="product-img-wrap text-decoration-none d-flex">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->PName }}" loading="lazy">
                                <span class="badge badge-stock bg-success">
                                    <i class="bi bi-check-circle me-1"></i> In Stock
                                </span>
                            </a>

                            <div class="card-body p-3 d-flex flex-column flex-grow-1">
                                <div class="badge-category mb-1">{{ $product->category->name ?? 'Grocery' }}</div>
                                <h6 class="fw-bold text-dark mb-2 text-truncate-2" style="font-size: 0.95rem; height: 2.8rem; overflow: hidden;">
                                    <a href="{{ route('product.detail', $rel->PID) }}" class="text-decoration-none text-dark">
                                        {{ $rel->PName }}
                                    </a>
                                </h6>
                                
                                <div class="mt-auto d-flex justify-content-between align-items-center pt-2">
                                    <div>
                                        <span class="text-muted small d-block" style="font-size: 0.75rem;">Price:</span>
                                        <span class="price-tag">${{ number_format($rel->Price, 2) }}</span>
                                    </div>
                                    <a href="{{ route('product.detail', $rel->PID) }}" class="btn btn-sm btn-outline-fresh rounded-pill px-3 fw-bold">
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

<!-- Toast for Copied SKU / Share Link -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
    <div id="liveToast" class="toast align-items-center text-bg-dark border-0 rounded-4 shadow" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <span id="toast-message">Copied to clipboard!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Live quantity increment and decrement
    function incrementQty(maxStock) {
        const input = document.getElementById('product-quantity-input');
        if (!input) return;
        let current = parseInt(input.value) || 1;
        if (current < maxStock) {
            input.value = current + 1;
            updateSubtotal();
        }
    }

    function decrementQty() {
        const input = document.getElementById('product-quantity-input');
        if (!input) return;
        let current = parseInt(input.value) || 1;
        if (current > 1) {
            input.value = current - 1;
            updateSubtotal();
        }
    }

    // Dynamic Live Subtotal calculation
    function updateSubtotal() {
        const input = document.getElementById('product-quantity-input');
        const display = document.getElementById('live-subtotal-display');
        const minusBtn = document.getElementById('btn-qty-minus');
        const plusBtn = document.getElementById('btn-qty-plus');

        if (!input || !display) return;

        let qty = parseInt(input.value) || 1;
        const max = parseInt(input.getAttribute('max')) || 999;
        const min = parseInt(input.getAttribute('min')) || 1;
        const price = parseFloat(input.getAttribute('data-unit-price')) || 0;

        if (qty < min) { qty = min; input.value = min; }
        if (qty > max) { qty = max; input.value = max; }

        if (minusBtn) minusBtn.disabled = (qty <= min);
        if (plusBtn) plusBtn.disabled = (qty >= max);

        const subtotal = (qty * price).toFixed(2);
        display.textContent = '$' + subtotal;
    }

    // Copy SKU to clipboard
    function copySku(sku) {
        navigator.clipboard.writeText(sku).then(() => {
            showToast('SKU ' + sku + ' copied to clipboard!');
        }).catch(() => {
            showToast('Item: ' + sku);
        });
    }

    // Wishlist toggle interaction
    function toggleWishlist(btn) {
        const icon = btn.querySelector('i');
        btn.classList.toggle('active');
        if (btn.classList.contains('active')) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
            showToast('Saved to your Favorites & Wishlist!');
        } else {
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
            showToast('Removed from your Wishlist.');
        }
    }

    // Share product link
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ addslashes($product->PName) }} - FreshMart',
                url: window.location.href
            }).catch(() => {});
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                showToast('Product link copied to clipboard!');
            });
        }
    }

    // Show floating toast
    function showToast(msg) {
        const toastEl = document.getElementById('liveToast');
        const toastMsg = document.getElementById('toast-message');
        if (toastEl && toastMsg) {
            toastMsg.textContent = msg;
            const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
            toast.show();
        }
    }

    // Initialize subtotal on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateSubtotal();
    });
</script>
@endsection
