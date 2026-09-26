@extends('layouts.app')

@section('title', 'Express Checkout - FreshMart')

@section('content')
<div class="container pb-5">
    <div class="mb-4 pb-2 border-bottom">
        <h2 class="fw-bold mb-0"><i class="bi bi-shield-check text-success me-2"></i> Express Checkout</h2>
        <span class="text-muted small">Please confirm your delivery address and preferred payment method</span>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Left: Delivery & Payment Details -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <span class="badge rounded-circle bg-success text-white" style="width: 26px; height: 26px; font-size: 0.8rem; display: inline-flex; align-items: center; justify-content: center;">1</span>
                        <span>Customer & Delivery Information</span>
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-secondary">Customer Name</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-secondary">Email Address</label>
                        <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly disabled>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold small text-secondary">Recipient Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control" 
                               value="{{ old('phone', $user->phone ?? '+1 (555) 234-5678') }}" required>
                        <div class="form-text small">Our delivery rider will call this number upon arrival.</div>
                    </div>

                    <div class="mb-3">
                        <label for="shipping_address" class="form-label fw-semibold small text-secondary">Delivery Address <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" class="form-control" 
                                  placeholder="House/Apt number, Street name, City, Zip code" required>{{ old('shipping_address', $user->address ?? '742 Evergreen Terrace, Springfield') }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label for="customer_notes" class="form-label fw-semibold small text-secondary">Order Notes (Optional)</label>
                        <textarea name="customer_notes" id="customer_notes" rows="2" class="form-control" 
                                  placeholder="Special delivery instructions, gate code, preferred delivery time...">{{ old('customer_notes') }}</textarea>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <span class="badge rounded-circle bg-success text-white" style="width: 26px; height: 26px; font-size: 0.8rem; display: inline-flex; align-items: center; justify-content: center;">2</span>
                        <span>Payment Method</span>
                    </h5>

                    <div class="form-check p-3 rounded-3 border mb-2 bg-light">
                        <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="pay_cod" value="Cash on Delivery" checked>
                        <label class="form-check-label fw-bold text-dark d-flex align-items-center justify-content-between w-100" for="pay_cod">
                            <span><i class="bi bi-cash-stack text-success me-2 fs-5"></i> Cash on Delivery (COD)</span>
                            <span class="badge bg-success-subtle text-success">Recommended</span>
                        </label>
                    </div>

                    <div class="form-check p-3 rounded-3 border mb-2">
                        <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="pay_card" value="Credit/Debit Card">
                        <label class="form-check-label fw-bold text-dark d-flex align-items-center justify-content-between w-100" for="pay_card">
                            <span><i class="bi bi-credit-card-2-front text-primary me-2 fs-5"></i> Credit or Debit Card</span>
                            <span class="text-muted small">Visa / Master</span>
                        </label>
                    </div>

                    <div class="form-check p-3 rounded-3 border">
                        <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="pay_bank" value="Online Banking">
                        <label class="form-check-label fw-bold text-dark d-flex align-items-center justify-content-between w-100" for="pay_bank">
                            <span><i class="bi bi-bank text-info-emphasis me-2 fs-5"></i> Instant Bank Transfer</span>
                            <span class="text-muted small">Direct Pay</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right: Order Review & Total -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 90px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Order Review</h5>
                        <a href="{{ route('cart.index') }}" class="small text-success text-decoration-none">Edit Cart</a>
                    </div>

                    <!-- Items list -->
                    <div class="mb-3" style="max-height: 280px; overflow-y: auto;">
                        @foreach($cart as $id => $item)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-dark border rounded-pill">{{ $item['quantity'] }}x</span>
                                    <div class="text-truncate" style="max-width: 200px;">
                                        <div class="fw-semibold text-dark text-truncate small">{{ $item['name'] }}</div>
                                        <div class="text-muted small">${{ number_format($item['price'], 2) }} each</div>
                                    </div>
                                </div>
                                <div class="fw-bold text-dark">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-secondary small">
                        <span>Items Subtotal:</span>
                        <span class="fw-semibold text-dark">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-secondary small">
                        <span>Sales Tax (5%):</span>
                        <span class="fw-semibold text-dark">${{ number_format($tax, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 text-secondary small">
                        <span>Standard Delivery:</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <span class="fw-bold text-dark">Total Payable:</span>
                        <span class="display-6 fw-extrabold text-success" style="font-weight: 800;">
                            ${{ number_format($total, 2) }}
                        </span>
                    </div>

                    <button type="submit" class="btn btn-fresh btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-bag-check-fill"></i>
                        <span>Confirm & Place Order</span>
                    </button>

                    <div class="d-flex align-items-center justify-content-center gap-2 text-muted small mt-3">
                        <i class="bi bi-lock-fill text-success"></i>
                        <span>Encrypted SSL 256-bit Secure Transaction</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
