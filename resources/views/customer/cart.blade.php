@extends('layouts.app')

@section('title', 'Shopping Cart - FreshMart')

@section('styles')
<style>
    /* Clean Cart Design System */
    .cart-container {
        max-width: 1140px;
    }

    .cart-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }

    .cart-table th {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--slate-500);
        background: #f8fafc;
        border-bottom: 1px solid var(--border-color);
        padding: 0.85rem 1.25rem;
    }

    .cart-table td {
        padding: 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .cart-table tr:last-child td {
        border-bottom: none;
    }

    /* Product Thumbnail */
    .cart-item-thumb {
        width: 72px;
        height: 72px;
        min-width: 72px;
        border-radius: 10px;
        background: #ffffff;
        border: 1.5px solid #fef08a;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
        overflow: hidden;
    }
    .cart-item-thumb img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .cart-item-title {
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--dark);
        text-decoration: none;
        line-height: 1.4;
        display: block;
        margin-bottom: 0.25rem;
    }
    .cart-item-title:hover {
        color: #ca8a04;
    }

    .cart-item-cat {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #ca8a04;
    }

    .cart-item-meta {
        font-size: 0.75rem;
        color: var(--slate-400);
    }

    /* Minimalist Stepper */
    .stepper {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid #fef08a;
        border-radius: 9999px;
        background: #ffffff;
        overflow: hidden;
    }
    .stepper-btn {
        width: 30px;
        height: 30px;
        border: none;
        background: #fefce8;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 800;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
    }
    .stepper-btn:hover:not(:disabled) {
        background: #fde047;
        color: #0f172a;
    }
    .stepper-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }
    .stepper-input {
        width: 38px;
        height: 30px;
        border: none;
        border-left: 1px solid #fef08a;
        border-right: 1px solid #fef08a;
        text-align: center;
        font-weight: 800;
        font-size: 0.875rem;
        color: var(--dark);
        background: #ffffff;
        outline: none;
        -moz-appearance: textfield;
    }
    .stepper-input::-webkit-outer-spin-button,
    .stepper-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Remove Button */
    .btn-remove-item {
        color: var(--slate-400);
        background: transparent;
        border: none;
        padding: 0.4rem;
        border-radius: 6px;
        cursor: pointer;
        transition: color 0.15s ease, background 0.15s ease;
    }
    .btn-remove-item:hover {
        color: #ef4444;
        background: #fef2f2;
    }

    /* Free Shipping Progress Strip */
    .shipping-notice-strip {
        background: #ffffff;
        border: 1.5px solid #fef08a;
        border-radius: 12px;
        padding: 0.85rem 1.25rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.08);
    }
    .shipping-bar-track {
        height: 5px;
        background: #fef9c3;
        border-radius: 9999px;
        overflow: hidden;
        margin-top: 0.5rem;
    }
    .shipping-bar-fill {
        height: 100%;
        background: #facc15;
        border-radius: 9999px;
        transition: width 0.4s ease;
    }

    /* Summary Card */
    .summary-card {
        background: #ffffff;
        border: 1.5px solid #fef08a;
        border-radius: 16px;
        padding: 1.5rem;
        position: sticky;
        top: 90px;
        box-shadow: 0 4px 16px rgba(250, 204, 21, 0.1);
    }
    .summary-header {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 1.25rem;
        padding-bottom: 0.85rem;
        border-bottom: 1.5px solid #fef08a;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9375rem;
        color: var(--slate-600);
        margin-bottom: 0.75rem;
    }
    .summary-row.total {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1.5px solid #fef08a;
        margin-bottom: 1.25rem;
    }
    .summary-row.total .total-label {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dark);
    }
    .summary-row.total .total-value {
        font-size: 1.55rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .btn-checkout {
        background: #facc15;
        color: #0f172a !important;
        font-weight: 800;
        font-size: 1rem;
        border-radius: 9999px;
        padding: 0.85rem 1.25rem;
        border: none;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 14px rgba(250, 204, 21, 0.4);
        transition: all 0.15s ease;
    }
    .btn-checkout:hover {
        background: #eab308;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(234, 179, 8, 0.5);
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .cart-table thead {
            display: none;
        }
        .cart-table tr {
            display: flex;
            flex-direction: column;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        .cart-table td {
            padding: 0.35rem 1rem;
            border: none;
        }
    }
</style>
@endsection

@section('content')
<div class="container cart-container pb-5">

    <!-- Clean Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Shopping Cart</h1>
            <p class="text-muted small mb-0">
                @if(count($cart) > 0)
                    {{ count($cart) }} {{ Str::plural('item', count($cart)) }} currently in your basket
                @else
                    Your basket is currently empty
                @endif
            </p>
        </div>

        @if(count($cart) > 0)
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Empty all items from your cart?');">
                @csrf
                <button type="submit" class="btn btn-sm btn-link text-muted text-decoration-none p-0">
                    <i class="bi bi-trash3 me-1"></i> Clear cart
                </button>
            </form>
        @endif
    </div>

    @if(count($cart) > 0)
        @php
            $freeShippingThreshold = 35.00;
            $freeShippingDiff = max(0, $freeShippingThreshold - $subtotal);
            $freeShippingPercent = min(100, round(($subtotal / $freeShippingThreshold) * 100));
        @endphp

        <div class="row g-4">
            <!-- Left: Cart Items -->
            <div class="col-lg-8">

                <!-- Clean Free Shipping Notice Strip -->
                <div class="shipping-notice-strip">
                    <div class="d-flex justify-content-between align-items-center small">
                        <span class="text-dark">
                            @if($freeShippingDiff > 0)
                                <i class="bi bi-truck me-1" style="color: #ca8a04;"></i> Add <strong>${{ number_format($freeShippingDiff, 2) }}</strong> more to qualify for <strong>Free Express Delivery</strong>
                            @else
                                <i class="bi bi-check-circle-fill me-1" style="color: #ca8a04;"></i> This order qualifies for <strong>Free Express Delivery</strong>
                            @endif
                        </span>
                        <span class="text-muted fw-semibold">{{ $freeShippingPercent }}%</span>
                    </div>
                    <div class="shipping-bar-track">
                        <div class="shipping-bar-fill" style="width: {{ $freeShippingPercent }}%;"></div>
                    </div>
                </div>

                <!-- Cart Items Table Card -->
                <div class="cart-card mb-3">
                    <div class="table-responsive">
                        <table class="table cart-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 48%;">Item</th>
                                    <th style="width: 15%;">Price</th>
                                    <th style="width: 20%;">Quantity</th>
                                    <th style="width: 12%;">Subtotal</th>
                                    <th style="width: 5%;" class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr>
                                        <!-- Item info -->
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="cart-item-thumb">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="cart-item-cat">{{ $item['category'] }}</span>
                                                    <a href="{{ route('product.detail', $id) }}" class="cart-item-title">
                                                        {{ $item['name'] }}
                                                    </a>
                                                    <div class="cart-item-meta">
                                                        <span>SKU: #{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</span>
                                                        <span class="mx-1">·</span>
                                                        <span class="fw-medium" style="color: #854d0e;"><i class="bi bi-check2"></i> In stock</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Unit Price -->
                                        <td>
                                            <span class="text-dark fw-medium">${{ number_format($item['price'], 2) }}</span>
                                        </td>

                                        <!-- Quantity Stepper -->
                                        <td>
                                            <form id="form-update-{{ $id }}" action="{{ route('cart.update', $id) }}" method="POST">
                                                @csrf
                                                <div class="stepper">
                                                    <button type="button" class="stepper-btn" 
                                                            onclick="changeQuantity('{{ $id }}', -1, 1, {{ $item['stock'] }})" 
                                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }} 
                                                            title="Decrease">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" id="qty-input-{{ $id }}" name="quantity" 
                                                           value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" 
                                                           class="stepper-input" 
                                                           onchange="this.form.submit()" 
                                                           aria-label="Quantity">
                                                    <button type="button" class="stepper-btn" 
                                                            onclick="changeQuantity('{{ $id }}', 1, 1, {{ $item['stock'] }})" 
                                                            {{ $item['quantity'] >= $item['stock'] ? 'disabled' : '' }} 
                                                            title="Increase">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>

                                        <!-- Line Subtotal -->
                                        <td>
                                            <span class="fw-bold text-dark">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </td>

                                        <!-- Remove Item -->
                                        <td class="text-end">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-remove-item" title="Remove item">
                                                    <i class="bi bi-trash3 fs-6"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Navigation link -->
                <div class="d-flex justify-content-between align-items-center pt-2">
                    <a href="{{ route('catalog') }}" class="text-decoration-none text-muted small fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                    </a>
                    <span class="text-muted small">
                        <i class="bi bi-check2 me-1" style="color: #ca8a04;"></i> Freshness & Quality Guaranteed
                    </span>
                </div>

            </div>

            <!-- Right: Order Summary Sidebar -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <div class="summary-header d-flex justify-content-between align-items-center">
                        <span>Order Summary</span>
                        <span class="text-muted small fw-normal">{{ count($cart) }} {{ Str::plural('item', count($cart)) }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span class="fw-semibold text-dark">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Estimated Tax (5%)</span>
                        <span class="fw-semibold text-dark">${{ number_format($tax, 2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Shipping</span>
                        <span class="fw-semibold" style="color: #ca8a04;">Free</span>
                    </div>

                    <div class="summary-row total">
                        <div>
                            <div class="total-label">Total</div>
                            <span class="text-muted" style="font-size: 0.75rem;">Including taxes</span>
                        </div>
                        <div class="total-value">${{ number_format($total, 2) }}</div>
                    </div>

                    @if(Auth::guard('web')->check())
                        <a href="{{ route('checkout.index') }}" class="btn-checkout">
                            <span>Proceed to Checkout</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-checkout">
                            <span>Sign In to Checkout</span>
                            <i class="bi bi-box-arrow-in-right"></i>
                        </a>
                        <p class="text-center text-muted small mt-2 mb-0" style="font-size: 0.78rem;">
                            Sign in required to confirm delivery address
                        </p>
                    @endif

                    <div class="mt-4 pt-3 border-top text-center">
                        <div class="text-muted small mb-2 d-flex align-items-center justify-content-center gap-1" style="font-size: 0.8rem;">
                            <i class="bi bi-shield-lock" style="color: #ca8a04;"></i>
                            <span>Secure 256-bit SSL encrypted checkout</span>
                        </div>
                        <div class="d-flex justify-content-center gap-2 small text-secondary">
                            <span>Cash on Delivery</span>
                            <span>·</span>
                            <span>Cards</span>
                            <span>·</span>
                            <span>Direct Transfer</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart State -->
        <div class="cart-card p-5 text-center my-4">
            <div class="rounded-circle bg-light d-inline-flex p-4 mx-auto mb-3 text-secondary" style="width: 80px; height: 80px; align-items: center; justify-content: center;">
                <i class="bi bi-cart3 fs-2 text-muted"></i>
            </div>
            <h2 class="h5 fw-bold text-dark mb-2">Your shopping cart is empty</h2>
            <p class="text-muted small mb-4" style="max-width: 440px; margin: 0 auto;">
                You haven't added any fresh groceries or essentials yet. Browse our selection and fill your basket.
            </p>
            <div>
                <a href="{{ route('catalog') }}" class="btn btn-fresh px-4">
                    Explore Groceries
                </a>
            </div>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    function changeQuantity(id, delta, min, max) {
        const input = document.getElementById('qty-input-' + id);
        const form = document.getElementById('form-update-' + id);
        if (!input || !form) return;

        let currentVal = parseInt(input.value) || 1;
        let newVal = currentVal + delta;

        if (newVal < min) {
            newVal = min;
        } else if (newVal > max) {
            newVal = max;
            alert('Maximum available stock is ' + max + ' units.');
            return;
        }

        if (newVal !== currentVal) {
            input.value = newVal;
            form.submit();
        }
    }
</script>
@endsection
