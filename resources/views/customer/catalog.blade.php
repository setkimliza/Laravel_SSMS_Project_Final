@extends('layouts.app')

@section('title', 'Browse Groceries - FreshMart Supermarket')

@section('content')
<div class="container pb-5">

    <!-- Page Header & Breadcrumb -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Catalog</li>
                    @if($selectedCategory)
                        <li class="breadcrumb-item active fw-bold text-success">{{ $selectedCategory->name }}</li>
                    @endif
                </ol>
            </nav>
            <h2 class="fw-bold mb-0">
                {{ $selectedCategory ? $selectedCategory->name : 'All Supermarket Groceries' }}
            </h2>
        </div>
        <div class="text-muted small mt-2 mt-md-0">
            Showing <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> items
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-top" style="top: 90px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-funnel me-1 text-success"></i> Department Filter</h6>
                    @if(request()->anyFilled(['category', 'search', 'in_stock', 'sort']))
                        <a href="{{ route('catalog') }}" class="small text-danger text-decoration-none">Reset All</a>
                    @endif
                </div>

                <!-- Category List -->
                <div class="list-group list-group-flush mb-4">
                    <a href="{{ route('catalog', array_merge(request()->except(['category', 'page']))) }}" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-2 border-0 rounded-3 {{ !request('category') ? 'fw-bold bg-success-subtle text-success' : 'text-secondary' }}">
                        <span><i class="bi bi-grid me-2"></i> All Departments</span>
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('catalog', array_merge(request()->except(['category', 'page']), ['category' => $cat->CatID])) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-2 border-0 rounded-3 {{ request('category') == $cat->CatID ? 'fw-bold bg-success-subtle text-success' : 'text-secondary' }}">
                            <span class="text-truncate"><i class="bi {{ $cat->icon ?: 'bi-circle' }} me-2"></i> {{ $cat->name }}</span>
                            <span class="badge bg-light text-muted rounded-pill">{{ $cat->products_count }}</span>
                        </a>
                    @endforeach
                </div>

                <!-- Stock Filter -->
                <h6 class="fw-bold mb-2 small text-uppercase text-muted" style="letter-spacing: 0.5px;">Availability</h6>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="inStockCheck" 
                           {{ request('in_stock') == '1' ? 'checked' : '' }}
                           onchange="location.href='{{ route('catalog', array_merge(request()->except(['in_stock', 'page']), ['in_stock' => request('in_stock') == '1' ? null : '1'])) }}'">
                    <label class="form-check-label small" for="inStockCheck">
                        In-Stock items only
                    </label>
                </div>
            </div>
        </div>

        <!-- Main Product Grid -->
        <div class="col-lg-9">
            <!-- Filter & Sort Bar -->
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-md-7">
                        <form action="{{ route('catalog') }}" method="GET" class="d-flex">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('in_stock'))
                                <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                            @endif
                            <input type="text" name="search" class="form-control rounded-pill me-2 ps-3" 
                                   placeholder="Search products in this view..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-fresh btn-sm rounded-pill px-3">Search</button>
                        </form>
                    </div>

                    <div class="col-md-5 d-flex justify-content-md-end align-items-center gap-2">
                        <label class="small text-muted text-nowrap mb-0">Sort By:</label>
                        <select class="form-select form-select-sm rounded-pill" style="max-width: 190px;" 
                                onchange="location.href=this.value;">
                            <option value="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" {{ $sort == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" {{ $sort == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" {{ $sort == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => 'name'])) }}" {{ $sort == 'name' ? 'selected' : '' }}>Name: A to Z</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products -->
            @if($products->count() > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-4">
                    @foreach($products as $product)
                        <div class="col">
                            <div class="product-card position-relative" style="cursor: pointer;" 
                                 onclick="if (!event.target.closest('form') && !event.target.closest('button')) window.location='{{ route('product.detail', $product->PID) }}';">
                                <a href="{{ route('product.detail', $product->PID) }}" class="product-img-wrap text-decoration-none d-flex">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->PName }}" loading="lazy">
                                    
                                    @if($product->Qty <= 0)
                                        <span class="badge badge-stock bg-danger">
                                            <i class="bi bi-x-circle me-1"></i> Out of Stock
                                        </span>
                                    @elseif($product->isLowStock())
                                        <span class="badge badge-stock bg-warning text-dark">
                                            <i class="bi bi-exclamation-circle-fill me-1"></i> Only {{ $product->Qty }} Left
                                        </span>
                                    @else
                                        <span class="badge badge-stock bg-success">
                                            <i class="bi bi-check-circle me-1"></i> In Stock
                                        </span>
                                    @endif
                                </a>

                                <div class="card-body p-3 d-flex flex-column flex-grow-1">
                                    <div class="badge-category mb-1">{{ $product->category->name ?? 'General' }}</div>
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

                                        @if($product->Qty > 0)
                                            <form action="{{ route('cart.add', $product->PID) }}" method="POST" onclick="event.stopPropagation();">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-fresh btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-1">
                                                    <i class="bi bi-cart-plus"></i> Add
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm rounded-pill px-3" disabled>
                                                Sold Out
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
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                    <div class="rounded-circle bg-light d-inline-flex p-4 mx-auto mb-3 text-muted">
                        <i class="bi bi-search fs-1"></i>
                    </div>
                    <h5 class="fw-bold">No groceries found matching your search</h5>
                    <p class="text-muted small mb-4">Try checking your spelling or adjusting your category and filter selections.</p>
                    <div>
                        <a href="{{ route('catalog') }}" class="btn btn-fresh rounded-pill px-4">
                            Clear Filters & View All
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
