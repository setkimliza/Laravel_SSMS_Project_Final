@extends('layouts.app')

@section('title', 'Register - FreshMart Supermarket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex p-3 rounded-circle bg-success-subtle text-success mb-2">
                            <i class="bi bi-person-plus-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Create Customer Account</h4>
                        <p class="text-muted small">Join FreshMart for express delivery, fresh supermarket deals and loyalty rewards</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small text-secondary">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control bg-light" 
                                   placeholder="e.g. Jane Doe" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control bg-light" 
                                   placeholder="name@example.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold small text-secondary">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control bg-light" 
                                       placeholder="+1 (555) 000-0000" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label fw-semibold small text-secondary">Delivery Address</label>
                                <input type="text" name="address" id="address" class="form-control bg-light" 
                                       placeholder="Street address, City" value="{{ old('address') }}">
                            </div>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
                                <input type="password" name="password" id="password" class="form-control bg-light" 
                                       placeholder="At least 6 characters" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control bg-light" 
                                       placeholder="Repeat password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-fresh w-100 py-2 fw-bold shadow-sm">
                            <i class="bi bi-check2-circle me-1"></i> Complete Registration
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-2 border-top">
                        <span class="text-muted small">Already have an account?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-success ms-1">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
