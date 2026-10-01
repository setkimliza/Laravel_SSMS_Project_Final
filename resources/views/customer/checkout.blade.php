@extends('layouts.app')

@section('title', 'Checkout - FreshMart')

@section('styles')
<style>
    .checkout-card {
        background: #ffffff;
        border: 1.5px solid #fef08a;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 14px rgba(250, 204, 21, 0.08);
    }
    .checkout-section-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .payment-option-card {
        border: 1.5px solid #fef08a;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        background: #ffffff;
        cursor: pointer;
        transition: border-color 0.15s ease, background-color 0.15s ease;
    }
    .payment-option-card:hover {
        border-color: #facc15;
        background: #fffdf5;
    }
    .payment-option-card.active {
        border-color: #facc15;
        background: #fefce8;
    }
    .form-control:focus {
        border-color: #facc15;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.25);
    }
</style>
@endsection

@section('content')
<div class="container pb-5" style="max-width: 1140px;">
    <!-- Page Header -->
    <div class="mb-4 pb-2 border-bottom">
        <h1 class="h3 fw-bold text-dark mb-1">Checkout</h1>
        <p class="text-muted small mb-0">Confirm your delivery details and choose your preferred payment option.</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Left: Delivery & Payment Details -->
            <div class="col-lg-7">
                <!-- Delivery Details Card -->
                <div class="checkout-card mb-4">
                    <div class="checkout-section-title">
                        <i class="bi bi-geo-alt" style="color: #ca8a04;"></i>
                        <span>Delivery Information</span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary mb-1">Customer Name</label>
                            <input type="text" class="form-control form-control-sm bg-light text-muted" value="{{ $user->name }}" readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary mb-1">Email Address</label>
                            <input type="email" class="form-control form-control-sm bg-light text-muted" value="{{ $user->email }}" readonly disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label small fw-semibold text-secondary mb-1">
                            Contact Phone <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="phone" id="phone" class="form-control" 
                               value="{{ old('phone', $user->phone ?? '+1 (555) 234-5678') }}" required
                               placeholder="e.g. +1 555-0192">
                        <div class="form-text small text-muted">Used by our courier for delivery arrival updates.</div>
                    </div>

                    <div class="mb-3">
                        <label for="shipping_address" class="form-label small fw-semibold text-secondary mb-1">
                            Delivery Address <span class="text-danger">*</span>
                        </label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" class="form-control" 
                                  placeholder="House/Apartment #, Street, City, Postal Code" required>{{ old('shipping_address', $user->address ?? '742 Evergreen Terrace, Springfield') }}</textarea>
                    </div>

                    <div>
                        <label for="customer_notes" class="form-label small fw-semibold text-secondary mb-1">
                            Delivery Instructions (Optional)
                        </label>
                        <textarea name="customer_notes" id="customer_notes" rows="2" class="form-control" 
                                  placeholder="Gate code, drop-off location, preferred drop time...">{{ old('customer_notes') }}</textarea>
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="checkout-card">
                    <div class="checkout-section-title">
                        <i class="bi bi-credit-card" style="color: #ca8a04;"></i>
                        <span>Payment Method</span>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <label class="payment-option-card d-flex align-items-center justify-content-between active" for="pay_cod">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input mt-0" type="radio" name="payment_method" id="pay_cod" value="Cash on Delivery" checked>
                                <div>
                                    <div class="fw-semibold text-dark small">Cash on Delivery (COD)</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Pay in cash upon doorstep delivery</div>
                                </div>
                            </div>
                            <span class="badge bg-light text-secondary border small">Default</span>
                        </label>

                        <label class="payment-option-card d-flex align-items-center justify-content-between" for="pay_card">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input mt-0" type="radio" name="payment_method" id="pay_card" value="Credit/Debit Card">
                                <div>
                                    <div class="fw-semibold text-dark small">Credit or Debit Card</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Visa, MasterCard, or American Express</div>
                                </div>
                            </div>
                            <span class="text-muted small"><i class="bi bi-credit-card-2-front"></i></span>
                        </label>

                        <label class="payment-option-card d-flex align-items-center justify-content-between" for="pay_bank">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input mt-0" type="radio" name="payment_method" id="pay_bank" value="Online Banking">
                                <div>
                                    <div class="fw-semibold text-dark small">Instant Online Banking</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Direct bank transfer via secure gateway</div>
                                </div>
                            </div>
                            <span class="text-muted small"><i class="bi bi-bank"></i></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right: Order Review & Total -->
            <div class="col-lg-5">
                <div class="checkout-card sticky-top" style="top: 90px;">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="fw-bold text-dark">Order Review</span>
                        <a href="{{ route('cart.index') }}" class="small text-muted text-decoration-none">Edit Cart</a>
                    </div>

                    <!-- Items list -->
                    <div class="mb-3" style="max-height: 240px; overflow-y: auto;">
                        @foreach($cart as $id => $item)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-muted border" style="font-size: 0.75rem;">{{ $item['quantity'] }}×</span>
                                    <div class="text-truncate" style="max-width: 190px;">
                                        <div class="fw-medium text-dark text-truncate small">{{ $item['name'] }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">${{ number_format($item['price'], 2) }} each</div>
                                    </div>
                                </div>
                                <span class="fw-semibold text-dark small">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-secondary small">
                        <span>Items Subtotal</span>
                        <span class="fw-semibold text-dark">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-secondary small">
                        <span>Estimated Tax (5%)</span>
                        <span class="fw-semibold text-dark">${{ number_format($tax, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 text-secondary small">
                        <span>Delivery</span>
                        <span class="fw-bold" style="color: #ca8a04;">Free Express</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-baseline pt-3 border-top mb-4">
                        <div>
                            <span class="fw-bold text-dark">Total</span>
                            <div class="text-muted" style="font-size: 0.72rem;">Including taxes</div>
                        </div>
                        <span class="h4 fw-bold text-dark mb-0">
                            ${{ number_format($total, 2) }}
                        </span>
                    </div>

                    <button type="submit" class="btn btn-fresh w-100 py-3 fw-bold d-flex align-items-center justify-content-center gap-2">
                        <span>Confirm & Place Order</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>

                    <div class="text-center text-muted small mt-3" style="font-size: 0.78rem;">
                        <i class="bi bi-shield-check me-1" style="color: #ca8a04;"></i> 256-bit encrypted checkout guarantee
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
