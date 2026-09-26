@extends('layouts.app')

@section('title', 'Shopping Cart - FreshMart')

@section('content')
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-cart3 text-success me-2"></i> Your Grocery Cart</h2>
            <span class="text-muted small">Review your chosen items before proceeding to checkout</span>
        </div>
        @if(count($cart) > 0)
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to empty your entire cart?');">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="bi bi-trash3 me-1"></i> Empty Cart
                </button>
            </form>
        @endif
    </div>

    @if(count($cart) > 0)
        <div class="row g-4">
            <!-- Left: Cart Items Table -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                                     class="rounded-3 border" style="width: 58px; height: 58px; object-fit: contain; background: #f8fafc;">
                                                <div>
                                                    <div class="badge-category">{{ $item['category'] }}</div>
                                                    <a href="{{ route('product.detail', $id) }}" class="fw-bold text-dark text-decoration-none">
                                                        {{ $item['name'] }}
                                                    </a>
                                                    <div class="text-muted small">SKU: #{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold">${{ number_format($item['price'], 2) }}</td>
                                        <td style="width: 170px;">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center gap-1">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                                       min="1" max="{{ $item['stock'] }}" 
                                                       class="form-control form-control-sm text-center" style="width: 65px;" required>
                                                <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill" title="Update Quantity">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                            <span class="text-muted small" style="font-size: 0.75rem;">Max: {{ $item['stock'] }}</span>
                                        </td>
                                        <td class="fw-bold text-dark">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle p-2" title="Remove Item">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('catalog') }}" class="btn btn-outline-fresh rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Continue Shopping Groceries
                    </a>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 90px;">
                    <h5 class="fw-bold text-dark mb-3">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-2 text-secondary">
                        <span>Items Subtotal:</span>
                        <span class="fw-semibold text-dark">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-secondary">
                        <span>Estimated Tax (5%):</span>
                        <span class="fw-semibold text-dark">${{ number_format($tax, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 text-secondary">
                        <span>Delivery Fee:</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <span class="fs-5 fw-bold text-dark">Total Amount:</span>
                        <span class="display-6 fw-extrabold text-success" style="font-weight: 800;">
                            ${{ number_format($total, 2) }}
                        </span>
                    </div>

                    @if(Auth::guard('web')->check())
                        <a href="{{ route('checkout.index') }}" class="btn btn-fresh btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <span>Proceed to Checkout</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-fresh btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <span>Sign In to Checkout</span>
                            <i class="bi bi-box-arrow-in-right"></i>
                        </a>
                        <p class="text-muted text-center small mt-2 mb-0">Customer sign in required for delivery address verification</p>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart State -->
        <div class="card border-0 shadow-sm rounded-5 p-5 text-center bg-white my-4">
            <div class="rounded-circle bg-light d-inline-flex p-4 mx-auto mb-3 text-muted">
                <i class="bi bi-cart-x fs-1 text-secondary"></i>
            </div>
            <h4 class="fw-bold mb-2">Your Shopping Cart is Empty</h4>
            <p class="text-muted small mb-4">You haven't added any fresh groceries or supermarket items to your cart yet.</p>
            <div>
                <a href="{{ route('catalog') }}" class="btn btn-fresh btn-lg rounded-pill px-5 shadow-sm">
                    <i class="bi bi-basket2-fill me-2"></i> Start Shopping Groceries
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
