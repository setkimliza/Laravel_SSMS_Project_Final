@extends('layouts.app')

@section('title', 'Customer Sign In - FreshMart Supermarket')

@section('styles')
<style>
    /* ========================================================
       MODERN CUSTOMER SIGN IN - HARMONIZED WITH STAFF PORTAL
       Identical 550px Bento Card Size & Executive Obsidian Header
       ======================================================== */

    .auth-portal-canvas {
        background: linear-gradient(180deg, #fffdf2 0%, #f8fafc 100%);
        min-height: auto;
        display: flex;
        align-items: center;
        padding: 1.5rem 0 2.5rem 0;
    }

    /* Exact Same 550px Card Width */
    .auth-form-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 16px 36px -10px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(15, 23, 42, 0.03);
        overflow: hidden;
        width: 100%;
        max-width: 550px;
        margin: 0 auto;
    }

    /* Top Golden Accent Line */
    .form-top-accent {
        height: 4px;
        background: linear-gradient(90deg, #f59e0b, #facc15, #fbbf24);
        width: 100%;
    }

    /* Obsidian Dark Header Box */
    .form-header-box {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 1.25rem 2rem 1rem 2rem;
        text-align: center;
        color: #ffffff;
        position: relative;
    }

    .form-brand-emblem {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(250, 204, 21, 0.15);
        border: 1.5px solid rgba(250, 204, 21, 0.4);
        color: #facc15;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        margin: 0 auto 0.5rem auto;
        box-shadow: 0 4px 14px rgba(250, 204, 21, 0.2);
    }

    .form-header-title {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        margin-bottom: 0.15rem;
    }

    .form-header-subtitle {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-bottom: 0;
    }

    /* Quick Demo Account Switcher */
    .demo-switcher-container {
        display: flex;
        background: #f1f5f9;
        border-radius: 10px;
        padding: 3px;
        gap: 4px;
        margin-bottom: 1.15rem;
    }

    .demo-btn {
        flex: 1;
        padding: 0.45rem;
        border: none;
        background: transparent;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .demo-btn:hover {
        color: #0f172a;
    }

    .demo-btn.active {
        background: #ffffff;
        color: #0f172a;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    /* Sleek Input Fields */
    .modern-input-group {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: #f8fafc;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .modern-input-group:focus-within {
        border-color: #facc15;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.25);
    }

    .modern-input-icon {
        padding: 0 0.85rem;
        color: #94a3b8;
        font-size: 1rem;
        display: flex;
        align-items: center;
    }

    .modern-input-group:focus-within .modern-input-icon {
        color: #ca8a04;
    }

    .modern-input-field {
        border: none;
        background: transparent;
        padding: 0.65rem 0.75rem 0.65rem 0;
        font-size: 0.92rem;
        font-weight: 600;
        color: #0f172a;
        width: 100%;
        outline: none;
    }

    .modern-input-field::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    .btn-eye-toggle {
        background: transparent;
        border: none;
        color: #94a3b8;
        padding: 0 0.85rem;
        cursor: pointer;
        transition: color 0.15s ease;
    }

    .btn-eye-toggle:hover {
        color: #0f172a;
    }

    /* Golden Submit Button */
    .btn-submit-portal {
        background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
        color: #0f172a;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        font-weight: 800;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 14px rgba(250, 204, 21, 0.35);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
    }

    .btn-submit-portal:hover {
        background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(234, 179, 8, 0.45);
        color: #0f172a;
    }

    .default-pass-pill {
        background: #fefce8;
        border: 1px solid #fef08a;
        color: #854d0e;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 9999px;
    }
</style>
@endsection

@section('content')
<div class="auth-portal-canvas">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center">

                <!-- Wider, Height-Optimized Form Card matching Staff Login -->
                <div class="auth-form-card">
                    <!-- Golden Top Accent Line -->
                    <div class="form-top-accent"></div>

                    <!-- Obsidian Header Box -->
                    <div class="form-header-box">
                        <div class="form-brand-emblem">
                            <i class="bi bi-basket2-fill"></i>
                        </div>
                        <h4 class="form-header-title">
                            Fresh<span style="color: #facc15;">Mart</span> Customer Portal
                        </h4>
                        <p class="form-header-subtitle">
                            Sign in to track orders, manage cart, & access member perks
                        </p>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 p-md-4">
                        
                        <!-- 1-Click Demo Customer Switcher -->
                        <div class="demo-switcher-container">
                            <button type="button" class="demo-btn active" id="btn-demo-john" onclick="fillCustomerCreds('john@example.com', '123', this)">
                                <i class="bi bi-person-fill text-warning"></i> Demo: John Doe
                            </button>
                            <button type="button" class="demo-btn" id="btn-demo-sarah" onclick="fillCustomerCreds('sarah@example.com', '123', this)">
                                <i class="bi bi-person-heart text-info"></i> Demo: Sarah C.
                            </button>
                        </div>

                        <!-- Session Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 p-3 small mb-3" role="alert" style="background: #fef2f2; border: 1.5px solid #fecaca !important;">
                                <div class="d-flex align-items-center gap-2 mb-1 text-danger fw-bold">
                                    <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                                    <span>Sign In Failed</span>
                                </div>
                                <p class="text-secondary small mb-0">
                                    {{ $errors->first() }}
                                </p>
                            </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('login') }}" method="POST" id="customerLoginForm">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-2">
                                <label for="email" class="form-label fw-bold text-dark small mb-1" style="font-size: 0.8rem;">
                                    Email Address
                                </label>
                                <div class="modern-input-group">
                                    <span class="modern-input-icon"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           class="modern-input-field" 
                                           placeholder="e.g. john@example.com" 
                                           value="{{ old('email', 'john@example.com') }}" 
                                           required 
                                           autofocus>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-bold text-dark small mb-0" style="font-size: 0.8rem;">
                                        Account Password
                                    </label>
                                    <span class="default-pass-pill">
                                        Demo Password: <strong>123</strong>
                                    </span>
                                </div>
                                <div class="modern-input-group">
                                    <span class="modern-input-icon"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="modern-input-field" 
                                           placeholder="Enter your password" 
                                           value="123" 
                                           required>
                                    <button type="button" class="btn-eye-toggle" onclick="toggleCustomerPassVisibility()" title="Show/Hide Password">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Keep Me Logged In Checkbox -->
                            <div class="d-flex justify-content-between align-items-center mb-3 small text-muted">
                                <label class="d-flex align-items-center gap-2 cursor-pointer mb-0">
                                    <input type="checkbox" name="remember" value="1" checked class="form-check-input mt-0">
                                    <span>Keep me signed in</span>
                                </label>
                                <span class="d-flex align-items-center gap-1 text-success fw-semibold">
                                    <span style="width: 7px; height: 7px; background: #22c55e; border-radius: 50%; display: inline-block;"></span>
                                    Storefront Active
                                </span>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-submit-portal">
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span>Sign In to Customer Account</span>
                            </button>
                        </form>

                        <!-- Create Account Link -->
                        <div class="text-center mt-3 pt-3 border-top">
                            <span class="text-muted small">New to FreshMart?</span>
                            <a href="{{ route('register') }}" class="small fw-bold text-decoration-none ms-1" style="color: #ca8a04;">
                                Create an Account &rarr;
                            </a>
                        </div>

                        <!-- Staff Portal Link -->
                        <div class="text-center mt-2">
                            <a href="{{ route('staff.login') }}" class="small text-secondary text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                <i class="bi bi-shield-lock-fill text-warning"></i> Supermarket Staff & Admin Portal &rarr;
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleCustomerPassVisibility() {
        const pass = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (pass.type === 'password') {
            pass.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            pass.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    function fillCustomerCreds(email, pass, btnElement) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = pass;

        document.querySelectorAll('.demo-btn').forEach(btn => btn.classList.remove('active'));
        if (btnElement) {
            btnElement.classList.add('active');
        }
    }

    // If page is restored from back-forward cache (bfcache), reload to ensure fresh CSRF token
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
@endsection
