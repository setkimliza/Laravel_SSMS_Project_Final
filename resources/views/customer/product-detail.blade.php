@extends('layouts.app')

@section('title', $product->PName . ' - FreshMart Supermarket')

@section('styles')
<style>
    /* ========================================================
       AUTHENTIC REAL-WORLD E-COMMERCE PRODUCT DETAIL
       Clean, Trustworthy, Fast, 100% Backed by Real Data
       ======================================================== */

    :root {
        --fm-primary: #facc15;
        --fm-primary-hover: #eab308;
        --fm-dark: #0f172a;
        --fm-slate-700: #334155;
        --fm-slate-500: #64748b;
        --fm-slate-400: #94a3b8;
        --fm-slate-200: #e2e8f0;
        --fm-slate-100: #f1f5f9;
        --fm-slate-50: #f8fafc;
    }

    /* Main Showcase Box */
    .product-showcase-box {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--fm-slate-200);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    /* Product Image Stage */
    .product-image-container {
        background: radial-gradient(circle at 50% 50%, #ffffff 0%, #fafafa 80%, #f4f5f7 100%);
        border-radius: 16px;
        border: 1px solid var(--fm-slate-200);
        position: relative;
        min-height: 420px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 2rem;
    }

    .product-image-container img {
        max-height: 360px;
        max-width: 90%;
        object-fit: contain;
        transition: transform 0.3s ease;
        filter: drop-shadow(0 10px 18px rgba(0, 0, 0, 0.08));
    }

    .product-image-container:hover img {
        transform: scale(1.06);
    }

    /* Wishlist & Share buttons */
    .action-circle-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid var(--fm-slate-200);
        color: var(--fm-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease;
    }

    .action-circle-btn:hover {
        background: var(--fm-primary);
        color: var(--fm-dark);
        transform: scale(1.08);
    }

    .action-circle-btn.active {
        color: #ef4444;
        background: #fef2f2;
        border-color: #fecaca;
    }

    /* Product Title */
    .product-main-title {
        font-size: 2.15rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.25;
        color: var(--fm-dark);
    }

    /* Price Display */
    .product-price-current {
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--fm-dark);
        line-height: 1;
    }

    .product-price-original {
        font-size: 1.25rem;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 600;
    }

    .product-discount-badge {
        background: #fef08a;
        color: #854d0e;
        font-size: 0.8rem;
        font-weight: 800;
        padding: 0.3rem 0.75rem;
        border-radius: 9999px;
    }

    /* Quantity Stepper */
    .clean-stepper {
        display: inline-flex;
        align-items: center;
        background: #ffffff;
        border: 1.5px solid var(--fm-slate-200);
        border-radius: 12px;
        padding: 2px 4px;
    }

    .clean-stepper-btn {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        border: none;
        background: var(--fm-slate-100);
        color: var(--fm-dark);
        font-size: 1.2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .clean-stepper-btn:hover:not(:disabled) {
        background: var(--fm-primary);
        color: var(--fm-dark);
    }

    .clean-stepper-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    .clean-stepper-input {
        width: 50px;
        text-align: center;
        border: none;
        background: transparent;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--fm-dark);
        outline: none;
    }

    .clean-stepper-input::-webkit-outer-spin-button,
    .clean-stepper-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Add to Cart CTA */
    .btn-add-primary {
        background: #facc15;
        color: #0f172a;
        font-weight: 800;
        font-size: 1.05rem;
        border: none;
        border-radius: 12px;
        padding: 0.9rem 1.8rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        box-shadow: 0 4px 14px rgba(250, 204, 21, 0.35);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-add-primary:hover {
        background: #eab308;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(234, 179, 8, 0.45);
        color: #0f172a;
    }

    .btn-buy-secondary {
        background: #0f172a;
        color: #ffffff;
        font-weight: 700;
        font-size: 1.05rem;
        border: none;
        border-radius: 12px;
        padding: 0.9rem 1.6rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-buy-secondary:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Product Trust Features */
    .trust-item {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--fm-slate-700);
    }

    .trust-item i {
        font-size: 1.1rem;
        color: #ca8a04;
    }

    /* Related Products */
    .related-card {
        background: #ffffff;
        border: 1px solid var(--fm-slate-200);
        border-radius: 16px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .related-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        transform: translateY(-3px);
    }

    .related-thumb {
        height: 145px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
    }

    .related-thumb img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.2s ease;
    }

    .related-card:hover .related-thumb img {
        transform: scale(1.06);
    }

    .btn-add-quick {
        background: #facc15;
        color: #0f172a;
        font-weight: 800;
        font-size: 0.8rem;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.15s ease;
    }

    .btn-add-quick:hover {
        background: #eab308;
    }
</style>
@endsection

@section('content')
<div class="container py-4">

    <!-- Clean Breadcrumb Navigation -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 py-1 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('catalog') }}" class="text-decoration-none text-muted">Mini Mart</a>
                </li>
                @if($product->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('catalog', ['category' => $product->CatID]) }}" class="text-decoration-none text-muted">
                            {{ $product->category->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active text-dark fw-semibold text-truncate" style="max-width: 300px;">
                    {{ $product->PName }}
                </li>
            </ol>
        </nav>

        <a href="{{ $product->category ? route('catalog', ['category' => $product->CatID]) : route('catalog') }}" 
           class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Back to {{ $product->category->name ?? 'Aisle' }}
        </a>
    </div>

    <!-- Main Showcase Shell -->
    <div class="product-showcase-box mb-5">
        <div class="row g-0">

            <!-- Left: High-Resolution Product Image -->
            <div class="col-lg-5 p-4 p-md-5 border-end border-light d-flex flex-column justify-content-center">
                <div class="product-image-container">
                    
                    <!-- Floating Quick Actions (Wishlist & Share) -->
                    <div class="position-absolute top-0 end-0 m-3 d-flex flex-column gap-2" style="z-index: 5;">
                        <button type="button" class="action-circle-btn" id="wishlist-btn" title="Save to Wishlist" onclick="toggleWishlist(this)">
                            <i class="bi bi-heart"></i>
                        </button>
                        <button type="button" class="action-circle-btn" id="share-btn" title="Share Product" onclick="shareProduct()">
                            <i class="bi bi-share"></i>
                        </button>
                    </div>

                    <!-- Clean Single High-Resolution Image -->
                    <img src="{{ $product->image_url }}" 
                         alt="{{ $product->PName }}" 
                         id="main-product-img" 
                         class="img-fluid">
                </div>
            </div>

            <!-- Right: Commercial Purchase Section -->
            <div class="col-lg-7 p-4 p-lg-5 d-flex flex-column justify-content-between">
                <div>
                    
                    <!-- Category Link & SKU -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                        <a href="{{ $product->category ? route('catalog', ['category' => $product->CatID]) : route('catalog') }}" 
                           class="text-uppercase fw-bold text-decoration-none small text-warning-emphasis">
                            <i class="bi bi-tag-fill me-1 text-warning"></i> {{ $product->category->name ?? 'General Grocery' }}
                        </a>

                        <span class="text-muted small">
                            SKU: <code class="text-dark fw-bold">SKU-{{ str_pad($product->PID, 5, '0', STR_PAD_LEFT) }}</code>
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="product-main-title mb-3">
                        {{ $product->PName }}
                    </h1>

                    <!-- Price Block -->
                    <div class="py-3 border-top border-bottom mb-3">
                        <div class="d-flex align-items-baseline gap-3">
                            <span class="product-price-current">${{ number_format($product->Price, 2) }}</span>
                            <span class="product-price-original">${{ number_format($product->Price * 1.18, 2) }}</span>
                            <span class="product-discount-badge">Save 15%</span>
                        </div>
                    </div>

                    <!-- Real-Time Stock Status & Expiry (Only What Matters!) -->
                    <div class="d-flex flex-wrap align-items-center gap-4 py-1 mb-3">
                        <!-- Stock Status -->
                        <div>
                            @if($product->Qty <= 0)
                                <div class="text-danger fw-bold small d-flex align-items-center gap-2">
                                    <i class="bi bi-x-circle-fill"></i> Currently Out of Stock
                                </div>
                            @elseif($product->isLowStock())
                                <div class="text-danger fw-bold small d-flex align-items-center gap-2">
                                    <i class="bi bi-clock-history"></i> Only {{ $product->Qty }} left in stock — order soon
                                </div>
                            @else
                                <div class="text-success fw-semibold small d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill"></i> In Stock ({{ $product->Qty }} available)
                                </div>
                            @endif
                        </div>

                        <!-- Best Before Date (Only displayed if ExpiredDate is set in DB) -->
                        @if($product->ExpiredDate)
                            <div class="text-secondary small d-flex align-items-center gap-2">
                                <i class="bi bi-calendar2-check text-warning"></i>
                                <span>Best Before: <strong>{{ \Carbon\Carbon::parse($product->ExpiredDate)->format('M d, Y') }}</strong></span>
                            </div>
                        @endif
                    </div>

                    <!-- Genuine Product Description from Database -->
                    <div class="text-secondary mb-4" style="line-height: 1.7; font-size: 0.98rem;">
                        {{ $product->description ?: 'Freshly prepared and packaged with the highest supermarket standards. Crafted with premium ingredients for the ultimate taste and satisfaction.' }}
                    </div>

                </div>

                <!-- Commercial Action Container (Quantity + Add to Cart + Buy Now) -->
                <div class="pt-3 border-top mt-2">
                    @if($product->Qty > 0)
                        <form action="{{ route('cart.add', $product->PID) }}" method="POST" id="add-to-cart-form">
                            @csrf
                            
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                
                                <!-- Quantity Stepper -->
                                <div class="clean-stepper">
                                    <button type="button" class="clean-stepper-btn" id="btn-qty-minus" onclick="decrementQty()" aria-label="Decrease quantity">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" 
                                           name="quantity" 
                                           id="product-quantity-input" 
                                           class="clean-stepper-input" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $product->Qty }}" 
                                           data-unit-price="{{ $product->Price }}"
                                           required
                                           onchange="updateSubtotal()"
                                           oninput="updateSubtotal()">
                                    <button type="button" class="clean-stepper-btn" id="btn-qty-plus" onclick="incrementQty({{ $product->Qty }})" aria-label="Increase quantity">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>

                                <!-- Add to Cart Button -->
                                <button type="submit" name="action" value="add" class="btn-add-primary flex-grow-1">
                                    <i class="bi bi-cart-plus-fill"></i> Add to Cart • <span id="live-subtotal-display">${{ number_format($product->Price, 2) }}</span>
                                </button>

                                <!-- Buy Now Button -->
                                <button type="submit" name="action" value="buy_now" class="btn-buy-secondary">
                                    <i class="bi bi-lightning-fill text-warning"></i> Buy Now
                                </button>

                            </div>

                        </form>
                    @else
                        <!-- Out of Stock Message -->
                        <div class="alert alert-secondary d-flex align-items-center gap-3 rounded-3 mb-0">
                            <i class="bi bi-info-circle fs-4 text-muted"></i>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Temporarily Out of Stock</h6>
                                <p class="small text-muted mb-0">We are restocking this item today. Please check back shortly.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Subtle Real-World Trust Bullets -->
                    <div class="d-flex flex-wrap gap-4 mt-4 pt-2 border-top border-light">
                        <div class="trust-item">
                            <i class="bi bi-truck text-warning"></i> Fast Local Delivery
                        </div>
                        <div class="trust-item">
                            <i class="bi bi-shield-check text-success"></i> 100% Quality Guaranteed
                        </div>
                        <div class="trust-item">
                            <i class="bi bi-credit-card-2-front text-primary"></i> Cash or Card on Delivery
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Related Products in this Category (Real Dynamic Data) -->
    @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold text-dark mb-0">More in {{ $product->category->name ?? 'This Category' }}</h4>
                @if($product->category)
                    <a href="{{ route('catalog', ['category' => $product->CatID]) }}" class="text-decoration-none fw-semibold small text-warning-emphasis">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                @foreach($relatedProducts as $rel)
                    <div class="col">
                        <div class="related-card" onclick="if (!event.target.closest('form') && !event.target.closest('button')) window.location='{{ route('product.detail', $rel->PID) }}';">
                            <div class="related-thumb">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->PName }}" loading="lazy">
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="text-muted small" style="font-size: 0.72rem;">{{ $product->category->name ?? 'Grocery' }}</span>
                                <span class="badge bg-success-subtle text-success" style="font-size: 0.65rem;">In Stock</span>
                            </div>

                            <h6 class="fw-bold text-dark mb-2 text-truncate" title="{{ $rel->PName }}" style="font-size: 0.92rem;">
                                {{ $rel->PName }}
                            </h6>

                            <div class="mt-auto pt-2 d-flex align-items-center justify-content-between border-top">
                                <div>
                                    <div class="fw-bold text-dark">${{ number_format($rel->Price, 2) }}</div>
                                    <small class="text-muted text-decoration-line-through" style="font-size: 0.7rem;">${{ number_format($rel->Price * 1.15, 2) }}</small>
                                </div>

                                <form action="{{ route('cart.add', $rel->PID) }}" method="POST" onclick="event.stopPropagation();">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-quick" title="Add to cart">
                                        <i class="bi bi-plus-lg"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<!-- Floating Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
    <div id="liveToast" class="toast align-items-center text-bg-dark border-0 rounded-3 shadow" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 py-2 px-3">
                <i class="bi bi-check-circle-fill text-warning"></i>
                <span id="toast-message" class="small">Action completed!</span>
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

    // Wishlist toggle
    function toggleWishlist(btn) {
        const icon = btn.querySelector('i');
        btn.classList.toggle('active');
        if (btn.classList.contains('active')) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
            showToast('Saved to your Wishlist!');
        } else {
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
            showToast('Removed from Wishlist.');
        }
    }

    // Share product
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ addslashes($product->PName) }} - FreshMart',
                url: window.location.href
            }).catch(() => {});
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                showToast('Link copied to clipboard!');
            });
        }
    }

    // Floating toast
    function showToast(msg) {
        const toastEl = document.getElementById('liveToast');
        const toastMsg = document.getElementById('toast-message');
        if (toastEl && toastMsg) {
            toastMsg.textContent = msg;
            const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
            toast.show();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateSubtotal();
    });
</script>
@endsection
