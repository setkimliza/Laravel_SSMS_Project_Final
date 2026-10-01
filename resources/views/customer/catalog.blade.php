@extends('layouts.app')

@section('title', ($selectedCategory ? $selectedCategory->name . ' - ' : '') . 'Browse Mini Mart - FreshMart')

@section('styles')
<style>
    /* ========================================================
       FRESHMART CATALOG - REDESIGNED MODERN PRODUCT CARDS
       Clean Page Structure with Premium Bento E-Commerce Cards
       ======================================================== */

    .catalog-filter-card {
        background: #ffffff;
        border: 1.5px solid #fef08a;
        border-radius: 16px;
        padding: 1.25rem;
        box-shadow: 0 4px 14px rgba(250, 204, 21, 0.08);
    }

    .catalog-category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.55rem 0.75rem;
        border-radius: 9999px;
        color: var(--slate-600);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .catalog-category-link:hover {
        background-color: #fefce8;
        color: #ca8a04;
    }

    .catalog-category-link.active {
        background-color: #fef9c3;
        color: #854d0e;
        font-weight: 800;
        border: 1px solid #fde047;
    }

    .catalog-top-bar {
        background: #ffffff;
        border: 1.5px solid #fef08a;
        border-radius: 14px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 14px rgba(250, 204, 21, 0.08);
    }

    /* ========================================================
       PREMIUM PRODUCT CARD REDESIGN - HIGH-END E-COMMERCE
       ======================================================== */

    .product-modern-card {
        background: #ffffff;
        border: 1.5px solid #e9ecef;
        border-radius: 20px;
        padding: 0.9rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04), 0 2px 6px -1px rgba(15, 23, 42, 0.02);
    }

    .product-modern-card:hover {
        transform: translateY(-7px);
        border-color: #facc15;
        box-shadow: 0 20px 32px -10px rgba(15, 23, 42, 0.12), 0 0 0 1.5px #facc15;
    }

    /* Studio Product Image Stage - Seamless Pure White with Studio Podium */
    .card-image-stage {
        height: 205px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .product-modern-card:hover .card-image-stage {
        background: radial-gradient(circle at 50% 50%, #ffffff 0%, #fffef0 70%, #fefce8 100%);
        border-color: #fef08a;
    }

    /* Product image - cleanly isolated without rectangular bounding box artifacts */
    .card-image-stage img {
        max-height: 165px;
        max-width: 85%;
        object-fit: contain;
        mix-blend-mode: multiply;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        z-index: 1;
    }

    .product-modern-card:hover .card-image-stage img {
        transform: scale(1.1) translateY(-5px);
    }

    /* Studio Podium Grounding Radial Shadow */
    .card-image-stage::after {
        content: '';
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        width: 48%;
        height: 10px;
        background: radial-gradient(ellipse at center, rgba(15, 23, 42, 0.14) 0%, rgba(15, 23, 42, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
        transition: all 0.35s ease;
        z-index: 0;
    }

    .product-modern-card:hover .card-image-stage::after {
        width: 60%;
        height: 13px;
        background: radial-gradient(ellipse at center, rgba(202, 138, 4, 0.28) 0%, rgba(202, 138, 4, 0) 70%);
    }

    /* Top Left Category Pill */
    .card-badge-category {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(226, 232, 240, 0.9);
        color: #475569;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.25rem 0.6rem;
        border-radius: 8px;
        z-index: 2;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Top Right Stock Status Pill */
    .card-badge-status {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.25rem 0.65rem;
        border-radius: 9999px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        backdrop-filter: blur(6px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .badge-in-stock {
        background: rgba(236, 253, 245, 0.95);
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .badge-low-stock {
        background: rgba(255, 251, 235, 0.95);
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .badge-out-stock {
        background: rgba(254, 242, 242, 0.95);
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .status-pulse-dot {
        width: 6px;
        height: 6px;
        background: #059669;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 rgba(5, 150, 105, 0.4);
        animation: statusPulse 2s infinite;
    }

    @keyframes statusPulse {
        0% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.7); }
        70% { box-shadow: 0 0 0 5px rgba(5, 150, 105, 0); }
        100% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0); }
    }

    /* Floating Quick View Trigger */
    .card-quickview-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 34px;
        height: 34px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(6px);
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 0.9rem;
        z-index: 3;
        opacity: 0;
        transform: translateY(6px) scale(0.9);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        text-decoration: none;
    }

    .product-modern-card:hover .card-quickview-btn {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .card-quickview-btn:hover {
        background: #facc15;
        color: #0f172a;
        border-color: #facc15;
        transform: scale(1.12);
    }

    /* Card Details Area */
    .card-body-details {
        padding: 0.9rem 0.25rem 0.2rem 0.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-department-sub {
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #ca8a04;
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-product-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
        height: 2.6rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 0.45rem;
        transition: color 0.2s ease;
    }

    .product-modern-card:hover .card-product-title {
        color: #ca8a04;
    }

    .card-micro-tags {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.72rem;
        color: #64748b;
        margin-bottom: 0.75rem;
    }

    .card-micro-tag-express {
        color: #ca8a04;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .card-micro-tag-fresh {
        color: #059669;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Price & Action Row */
    .card-footer-row {
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-price-primary {
        font-size: 1.35rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1;
    }

    .card-price-struck {
        font-size: 0.78rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 0.35rem;
    }

    .card-save-badge {
        font-size: 0.65rem;
        font-weight: 800;
        color: #ef4444;
        background: #fef2f2;
        border: 1px solid #fecaca;
        padding: 0.1rem 0.4rem;
        border-radius: 4px;
        margin-left: 0.3rem;
    }

    .btn-add-gold-pill {
        background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
        color: #0f172a !important;
        font-size: 0.8125rem;
        font-weight: 800;
        border-radius: 9999px;
        padding: 0.45rem 1.15rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.35);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        text-decoration: none;
    }

    .btn-add-gold-pill:hover {
        background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 18px rgba(217, 119, 6, 0.45);
        color: #0f172a !important;
    }

    .btn-add-gold-pill:active {
        transform: scale(0.96);
    }

    .btn-sold-pill {
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 0.78rem;
        font-weight: 700;
        border-radius: 9999px;
        padding: 0.42rem 0.95rem;
        border: 1px solid #e2e8f0;
        cursor: not-allowed;
    }
</style>
@endsection

@section('content')
<div class="container pb-5">

    <!-- Page Header & Breadcrumb (Faithful to User's View) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catalog') }}" class="text-decoration-none text-muted">Mini Mart Catalog</a></li>
                    @if($selectedCategory)
                        <li class="breadcrumb-item active fw-bold" style="color: #ca8a04;">{{ $selectedCategory->name }}</li>
                    @endif
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-0">
                {{ $selectedCategory ? $selectedCategory->name : 'All Supermarket Groceries' }}
            </h1>
        </div>
        <div class="text-muted small mt-2 mt-md-0">
            Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> items
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="catalog-filter-card sticky-top" style="top: 90px;">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.05em;">Departments</span>
                    @if(request()->anyFilled(['category', 'search', 'in_stock', 'sort']))
                        <a href="{{ route('catalog') }}" class="small text-danger text-decoration-none fw-bold">Reset</a>
                    @endif
                </div>

                <!-- Category List -->
                <div class="d-flex flex-column gap-1 mb-4">
                    <a href="{{ route('catalog', array_merge(request()->except(['category', 'page']))) }}" 
                       class="catalog-category-link {{ !request('category') ? 'active' : '' }}">
                        <span><i class="bi bi-grid me-2"></i> All Departments</span>
                        <span class="badge bg-light text-muted border rounded-pill">{{ \App\Models\Product::count() }}</span>
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('catalog', array_merge(request()->except(['category', 'page']), ['category' => $cat->CatID])) }}" 
                           class="catalog-category-link {{ request('category') == $cat->CatID ? 'active' : '' }}">
                            <span class="text-truncate"><i class="bi {{ $cat->icon ?: 'bi-tag' }} me-2 text-muted"></i> {{ $cat->name }}</span>
                            <span class="badge bg-light text-muted border rounded-pill">{{ $cat->products_count }}</span>
                        </a>
                    @endforeach
                </div>

                <!-- Stock Filter -->
                <div class="pt-3 border-top">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="inStockCheck" 
                               {{ request('in_stock') == '1' ? 'checked' : '' }}
                               onchange="location.href='{{ route('catalog', array_merge(request()->except(['in_stock', 'page']), ['in_stock' => request('in_stock') == '1' ? null : '1'])) }}'">
                        <label class="form-check-label small text-secondary fw-bold" for="inStockCheck">
                            In-Stock items only
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Product Grid -->
        <div class="col-lg-9">
            <!-- Filter & Sort Bar -->
            <div class="catalog-top-bar">
                <div class="row g-2 align-items-center">
                    <div class="col-md-7">
                        <form action="{{ route('catalog') }}" method="GET" class="d-flex">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('in_stock'))
                                <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                            @endif
                            <input type="text" name="search" class="form-control form-control-sm me-2 rounded-pill px-3" 
                                   placeholder="Search products in view..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-fresh btn-sm px-3 rounded-pill">Search</button>
                        </form>
                    </div>

                    <div class="col-md-5 d-flex justify-content-md-end align-items-center gap-2">
                        <label class="small text-muted text-nowrap mb-0 fw-semibold">Sort By:</label>
                        <select class="form-select form-select-sm rounded-pill px-3" style="max-width: 180px;" 
                                onchange="location.href=this.value;">
                            <option value="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" {{ $sort == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" {{ $sort == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" {{ $sort == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => 'name'])) }}" {{ $sort == 'name' ? 'selected' : '' }}>Name: A to Z</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Showcase (Redesigned Modern Cards) -->
            @if($products->count() > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-4">
                    @foreach($products as $product)
                        <div class="col">
                            <!-- REDESIGNED PRODUCT CARD -->
                            <div class="product-modern-card" 
                                 onclick="if (!event.target.closest('form') && !event.target.closest('button') && !event.target.closest('a')) window.location='{{ route('product.detail', $product->PID) }}';">
                                
                                <!-- Studio Product Image Stage -->
                                <div class="card-image-stage">
                                    <!-- Category Micro Tag -->
                                    <span class="card-badge-category">
                                        <i class="bi bi-tag-fill" style="color: #eab308; font-size: 0.6rem;"></i>
                                        {{ $product->category->name ?? 'Grocery' }}
                                    </span>

                                    <!-- Stock Status Badge -->
                                    @if($product->Qty <= 0)
                                        <span class="card-badge-status badge-out-stock">
                                            <i class="bi bi-x-circle-fill"></i> Sold Out
                                        </span>
                                    @elseif($product->isLowStock())
                                        <span class="card-badge-status badge-low-stock">
                                            <i class="bi bi-fire"></i> Only {{ $product->Qty }} Left
                                        </span>
                                    @else
                                        <span class="card-badge-status badge-in-stock">
                                            <span class="status-pulse-dot"></span> In Stock
                                        </span>
                                    @endif

                                    <!-- Product Image with mix-blend-mode multiply & drop shadow -->
                                    <img src="{{ $product->image_url }}" alt="{{ $product->PName }}" loading="lazy">

                                    <!-- Quick View Icon Hover Trigger -->
                                    <a href="{{ route('product.detail', $product->PID) }}" class="card-quickview-btn" title="View {{ $product->PName }}" onclick="event.stopPropagation();">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>

                                <!-- Card Details Area -->
                                <div class="card-body-details">
                                    <div class="card-department-sub">
                                        <span>{{ $product->category->name ?? 'Mini Mart' }}</span>
                                        @if($product->Qty > 0 && !$product->isLowStock())
                                            <span class="text-success fw-bold" style="font-size: 0.65rem;">● Available</span>
                                        @endif
                                    </div>

                                    <h2 class="card-product-title" title="{{ $product->PName }}">
                                        {{ $product->PName }}
                                    </h2>

                                    <div class="card-micro-tags">
                                        <span class="card-micro-tag-express">
                                            <i class="bi bi-lightning-charge-fill text-warning"></i> 30-Min Fast Express
                                        </span>
                                        <span class="text-muted ms-auto" style="font-size: 0.68rem; font-weight: 600;">
                                            #{{ str_pad($product->PID, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>

                                    <!-- Price & Cart Button Row -->
                                    <div class="card-footer-row">
                                        <div>
                                            <div class="d-flex align-items-baseline">
                                                <span class="card-price-primary">${{ number_format($product->Price, 2) }}</span>
                                                <span class="card-price-struck">${{ number_format($product->Price * 1.15, 2) }}</span>
                                                <span class="card-save-badge">-15%</span>
                                            </div>
                                        </div>

                                        @if($product->Qty > 0)
                                            <form action="{{ route('cart.add', $product->PID) }}" method="POST" onclick="event.stopPropagation();">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn-add-gold-pill" title="Add to Basket">
                                                    <i class="bi bi-cart-plus-fill"></i>
                                                    <span>Add</span>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn-sold-pill" disabled>
                                                <i class="bi bi-slash-circle me-1"></i> Sold Out
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="catalog-filter-card p-5 text-center my-4">
                    <div class="rounded-circle bg-light d-inline-flex p-3 mx-auto mb-3 text-muted" style="width: 58px; height: 58px; align-items: center; justify-content: center;">
                        <i class="bi bi-search fs-3 text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark">No groceries found</h5>
                    <p class="text-muted small mb-4">Try checking your spelling or adjusting your filters.</p>
                    <div>
                        <a href="{{ route('catalog') }}" class="btn btn-fresh btn-sm px-4 rounded-pill">
                            Clear Filters
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
