@extends('layouts.app')

@section('title', 'Sign In - FreshMart Supermarket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex p-3 rounded-circle bg-success-subtle text-success mb-2">
                            <i class="bi bi-person-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Customer Sign In</h4>
                        <p class="text-muted small">Access your grocery cart, order history, and express checkout</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control bg-light border-start-0 ps-0" 
                                       placeholder="name@example.com" value="{{ old('email', 'john@example.com') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label fw-semibold small text-secondary mb-0">Password</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control bg-light border-start-0 ps-0" 
                                       placeholder="••••••••" value="password123" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                                <label class="form-check-label small text-muted" for="remember">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-fresh w-100 py-2 fw-bold shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Sign In to Account
                        </button>
                    </form>

                    <!-- Demo Credentials Pill -->
                    <div class="mt-4 p-3 bg-light rounded-3 border text-center">
                        <span class="badge bg-secondary mb-1">Demo Customer Account</span>
                        <div class="small text-muted">Email: <code>john@example.com</code> | Password: <code>password123</code></div>
                    </div>

                    <div class="text-center mt-4 pt-2 border-top">
                        <span class="text-muted small">New to FreshMart?</span>
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-success ms-1">Create an Account</a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('staff.login') }}" class="small text-muted text-decoration-none">
                            <i class="bi bi-shield-lock me-1"></i> Are you a supermarket staff member? Log in here
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
