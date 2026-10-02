@extends('layouts.app')

@section('title', 'Staff Portal Login - FreshMart SSMS')

@section('styles')
<style>
    /* ========================================================
       MODERN STAFF PORTAL LOGIN FORM REDESIGN
       Optimized Height & Generous Width for Effortless Viewing
       ======================================================== */

    .staff-portal-canvas {
        background: linear-gradient(180deg, #fffdf2 0%, #f8fafc 100%);
        min-height: auto;
        display: flex;
        align-items: center;
        padding: 1.5rem 0 2rem 0;
    }

    /* Wider, Substantial Card */
    .staff-form-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 16px 36px -10px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(15, 23, 42, 0.03);
        overflow: hidden;
        width: 100%;
        max-width: 550px;
        margin: 0 auto;
    }

    /* Top Accent Line */
    .form-top-accent {
        height: 4px;
        background: linear-gradient(90deg, #f59e0b, #facc15, #fbbf24);
        width: 100%;
    }

    /* Compact, Elegant Header */
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

    /* Quick Role Switcher */
    .role-switcher-container {
        display: flex;
        background: #f1f5f9;
        border-radius: 10px;
        padding: 3px;
        gap: 4px;
        margin-bottom: 1.15rem;
    }

    .role-btn {
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

    .role-btn:hover {
        color: #0f172a;
    }

    .role-btn.active {
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

    /* Submit Button */
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
<div class="staff-portal-canvas">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center">

                <!-- Wider, Height-Optimized Form Card -->
                <div class="staff-form-card">
                    <!-- Golden Accent Line -->
                    <div class="form-top-accent"></div>

                    <!-- Compact Card Header -->
                    <div class="form-header-box">
                        <div class="form-brand-emblem">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h4 class="form-header-title">
                            Fresh<span style="color: #facc15;">Mart</span> Console
                        </h4>
                        <p class="form-header-subtitle">
                            Supermarket Staff & Management Portal
                        </p>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 p-md-4">
                        
                        <!-- 1-Click Role Switcher -->
                        <div class="role-switcher-container">
                            <button type="button" class="role-btn active" id="btn-role-admin" onclick="selectRole('admin', '123', this)">
                                <i class="bi bi-shield-shaded"></i> Administrator
                            </button>
                            <button type="button" class="role-btn" id="btn-role-stock" onclick="selectRole('stock', '123', this)">
                                <i class="bi bi-boxes"></i> Stock Controller
                            </button>
                        </div>

                        <!-- Error Message Alert with Username & Password Hint -->
                        @if(session('error') || $errors->any())
                            <div class="alert alert-danger border-0 rounded-3 p-3 small mb-3" role="alert" style="background: #fef2f2; border: 1.5px solid #fecaca !important;">
                                <div class="d-flex align-items-center gap-2 mb-2 text-danger fw-bold">
                                    <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                                    <span>Incorrect Login Credentials!</span>
                                </div>
                                <p class="text-secondary small mb-2">
                                    {{ session('error') ?? $errors->first() }}
                                </p>
                                <div class="p-2 bg-white rounded-2 border border-danger-subtle small">
                                    <div class="fw-bold text-dark mb-1" style="font-size: 0.78rem;">
                                        <i class="bi bi-key-fill text-warning me-1"></i> Valid Staff Credentials:
                                    </div>
                                    <div class="d-flex flex-column gap-1 text-muted" style="font-size: 0.78rem;">
                                        <div>• <strong>Administrator:</strong> Username: <code class="text-dark fw-bold bg-light px-1 rounded">admin</code> | Password: <code class="text-danger fw-bold bg-light px-1 rounded">123</code></div>
                                        <div>• <strong>Stock Manager:</strong> Username: <code class="text-dark fw-bold bg-light px-1 rounded">stock</code> | Password: <code class="text-danger fw-bold bg-light px-1 rounded">123</code></div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('staff.login') }}" method="POST" id="staffLoginForm">
                            @csrf

                            <!-- Staff Username -->
                            <div class="mb-2">
                                <label for="UserName" class="form-label fw-bold text-dark small mb-1" style="font-size: 0.8rem;">
                                    Staff Username
                                </label>
                                <div class="modern-input-group">
                                    <span class="modern-input-icon"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" 
                                           name="UserName" 
                                           id="UserName" 
                                           class="modern-input-field" 
                                           placeholder="e.g. admin or stock" 
                                           value="{{ old('UserName', 'admin') }}" 
                                           required 
                                           autofocus>
                                </div>
                            </div>

                            <!-- Security Password -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="Password" class="form-label fw-bold text-dark small mb-0" style="font-size: 0.8rem;">
                                        Security Password
                                    </label>
                                    <span class="default-pass-pill">
                                        Password: <strong>123</strong>
                                    </span>
                                </div>
                                <div class="modern-input-group">
                                    <span class="modern-input-icon"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" 
                                           name="Password" 
                                           id="Password" 
                                           class="modern-input-field" 
                                           placeholder="Enter password" 
                                           value="123" 
                                           required>
                                    <button type="button" class="btn-eye-toggle" onclick="togglePassVisibility()" title="Show/Hide Password">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me Checkbox -->
                            <div class="d-flex justify-content-between align-items-center mb-3 small text-muted">
                                <label class="d-flex align-items-center gap-2 cursor-pointer mb-0">
                                    <input type="checkbox" name="remember" value="1" checked class="form-check-input mt-0">
                                    <span>Keep me logged in</span>
                                </label>
                                <span class="d-flex align-items-center gap-1 text-success fw-semibold">
                                    <span style="width: 7px; height: 7px; background: #22c55e; border-radius: 50%; display: inline-block;"></span>
                                    Online
                                </span>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-submit-portal">
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span>Sign In to Control Center</span>
                            </button>

                        </form>

                        <!-- Back to Storefront Link -->
                        <div class="text-center mt-3 pt-2 border-top">
                            <a href="{{ route('home') }}" class="small text-secondary text-decoration-none fw-semibold d-inline-flex align-items-center gap-1">
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
    // Quick role switcher
    function selectRole(username, password, btn) {
        document.getElementById('UserName').value = username;
        document.getElementById('Password').value = password;

        document.querySelectorAll('.role-btn').forEach(el => el.classList.remove('active'));
        if (btn) btn.classList.add('active');
    }

    // Toggle password visibility
    function togglePassVisibility() {
        const pass = document.getElementById('Password');
        const icon = document.getElementById('eyeIcon');
        if (!pass || !icon) return;

        if (pass.type === 'password') {
            pass.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            pass.type = 'password';
            icon.className = 'bi bi-eye';
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
