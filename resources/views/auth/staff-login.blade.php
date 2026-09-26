@extends('layouts.app')

@section('title', 'Staff Portal Login - FreshMart SSMS')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white p-4 text-center border-0">
                    <div class="d-inline-flex p-3 rounded-circle bg-white text-dark mb-2">
                        <i class="bi bi-shield-lock-fill fs-3 text-success"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Staff Management Portal</h4>
                    <p class="text-white-50 small mb-0">Authorized Admin and Stock Controllers Only</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('staff.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="UserName" class="form-label fw-semibold small text-secondary">Staff Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-badge"></i></span>
                                <input type="text" name="UserName" id="UserName" class="form-control bg-light border-start-0 ps-0" 
                                       placeholder="e.g. admin or stock" value="{{ old('UserName', 'admin') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="Password" class="form-label fw-semibold small text-secondary">Security Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key-fill"></i></span>
                                <input type="password" name="Password" id="Password" class="form-control bg-light border-start-0 ps-0" 
                                       placeholder="••••••••" value="password123" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-box-arrow-in-right text-success"></i> Access Management Console
                        </button>
                    </form>

                    <!-- Quick Demo Credential Selectors -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="small fw-bold text-muted mb-2 text-center text-uppercase" style="letter-spacing: 0.5px; font-size: 0.75rem;">
                            Quick Demo Login Helper
                        </div>
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" 
                                    onclick="document.getElementById('UserName').value='admin'; document.getElementById('Password').value='password123';">
                                <i class="bi bi-shield-shaded me-1"></i> Admin Login
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-3" 
                                    onclick="document.getElementById('UserName').value='stock'; document.getElementById('Password').value='password123';">
                                <i class="bi bi-boxes me-1"></i> Stock Controller
                            </button>
                        </div>
                        <div class="text-center text-muted small mt-2">
                            Both roles share the default password: <code>password123</code>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="small text-muted text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Back to Public Storefront
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
