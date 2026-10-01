@extends('layouts.app')

@section('title', 'Create Customer Account - FreshMart Supermarket')

@section('styles')
<style>
    /* ========================================================
       MODERN CUSTOMER REGISTRATION - HARMONIZED WITH PORTAL
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

    .perks-badge {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
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
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h4 class="form-header-title">
                            Fresh<span style="color: #facc15;">Mart</span> Membership
                        </h4>
                        <p class="form-header-subtitle">
                            Create your customer account for fast grocery ordering & savings
                        </p>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 p-md-4">

                        <!-- Perks Pill -->
                        <div class="d-flex justify-content-center mb-3">
                            <span class="perks-badge">
                                <i class="bi bi-patch-check-fill text-success"></i> Instant Checkout & Order Tracking Included
                            </span>
                        </div>

                        <!-- Session Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 p-3 small mb-3" role="alert" style="background: #fef2f2; border: 1.5px solid #fecaca !important;">
                                <div class="d-flex align-items-center gap-2 mb-1 text-danger fw-bold">
                                    <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                                    <span>Registration Issues Found:</span>
                                </div>
                                <ul class="mb-0 ps-3 small text-secondary">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('register') }}" method="POST" id="customerRegisterForm">
                            @csrf

                            <!-- Full Name -->
                            <div class="mb-2">
                                <label for="name" class="form-label fw-bold text-dark small mb-1" style="font-size: 0.8rem;">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="modern-input-group">
                                    <span class="modern-input-icon"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="modern-input-field" 
                                           placeholder="e.g. Jane Doe" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autofocus>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="mb-2">
                                <label for="email" class="form-label fw-bold text-dark small mb-1" style="font-size: 0.8rem;">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="modern-input-group">
                                    <span class="modern-input-icon"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           class="modern-input-field" 
                                           placeholder="e.g. jane@example.com" 
                                           value="{{ old('email') }}" 
                                           required>
                                </div>
                            </div>

                            <!-- Phone and Delivery Address in 2 Columns -->
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-bold text-dark small mb-1" style="font-size: 0.8rem;">
                                        Phone Number
                                    </label>
                                    <div class="modern-input-group">
                                        <span class="modern-input-icon"><i class="bi bi-telephone-fill"></i></span>
                                        <input type="text" 
                                               name="phone" 
                                               id="phone" 
                                               class="modern-input-field" 
                                               placeholder="012 345 678" 
                                               value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label fw-bold text-dark small mb-1" style="font-size: 0.8rem;">
                                        Delivery Address
                                    </label>
                                    <div class="modern-input-group">
                                        <span class="modern-input-icon"><i class="bi bi-geo-alt-fill"></i></span>
                                        <input type="text" 
                                               name="address" 
                                               id="address" 
                                               class="modern-input-field" 
                                               placeholder="Street, City" 
                                               value="{{ old('address') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Password and Confirm Password in 2 Columns -->
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label for="reg_password" class="form-label fw-bold text-dark small mb-1" style="font-size: 0.8rem;">
                                        Password (Min 6) <span class="text-danger">*</span>
                                    </label>
                                    <div class="modern-input-group">
                                        <span class="modern-input-icon"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" 
                                               name="password" 
                                               id="reg_password" 
                                               class="modern-input-field" 
                                               placeholder="••••••" 
                                               required>
                                        <button type="button" class="btn-eye-toggle" onclick="togglePass('reg_password', 'eyeIcon1')" title="Show/Hide">
                                            <i class="bi bi-eye" id="eyeIcon1"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-bold text-dark small mb-1" style="font-size: 0.8rem;">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="modern-input-group">
                                        <span class="modern-input-icon"><i class="bi bi-shield-check"></i></span>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation" 
                                               class="modern-input-field" 
                                               placeholder="••••••" 
                                               required>
                                        <button type="button" class="btn-eye-toggle" onclick="togglePass('password_confirmation', 'eyeIcon2')" title="Show/Hide">
                                            <i class="bi bi-eye" id="eyeIcon2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-submit-portal mt-1">
                                <i class="bi bi-check2-circle"></i>
                                <span>Create Customer Account</span>
                            </button>
                        </form>

                        <!-- Sign In Link -->
                        <div class="text-center mt-3 pt-3 border-top">
                            <span class="text-muted small">Already have a FreshMart account?</span>
                            <a href="{{ route('login') }}" class="small fw-bold text-decoration-none ms-1" style="color: #ca8a04;">
                                Sign In &rarr;
                            </a>
                        </div>

                        <!-- Back to Storefront Link -->
                        <div class="text-center mt-2">
                            <a href="{{ route('home') }}" class="small text-secondary text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                <i class="bi bi-arrow-left"></i> Return to FreshMart Supermarket
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
    function togglePass(inputId, iconId) {
        const pass = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (pass.type === 'password') {
            pass.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            pass.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endsection
