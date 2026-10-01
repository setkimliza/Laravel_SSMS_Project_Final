@extends('layouts.admin')

@section('title', 'Edit Staff Member #' . $staff->Sid . ' - FreshMart SSMS')
@section('page-title', 'Edit Personnel Account')
@section('page-subtitle', 'Update access credentials, role permissions, or reset security password')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-9 col-lg-10">

        <!-- Top Back Navigation -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-white border rounded-pill px-3 py-2 fw-semibold text-secondary shadow-xs d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Back to Personnel Directory
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-slate-100 text-slate-700 border px-3 py-2 rounded-pill fw-bold font-monospace small">
                    ID #{{ str_pad($staff->Sid, 4, '0', STR_PAD_LEFT) }}
                </span>
                <span class="badge bg-amber-subtle text-amber-emphasis border border-warning-subtle px-3 py-2 rounded-pill fw-bold small">
                    <i class="bi bi-shield-lock-fill me-1 text-warning"></i> Admin Mode
                </span>
            </div>
        </div>

        <div class="row g-4">
            <!-- Form Column -->
            <div class="col-lg-8">
                <div class="admin-card p-4 p-md-5">
                    <div class="d-flex align-items-center gap-3 pb-3 mb-4 border-bottom border-slate-100">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(250, 204, 21, 0.15); color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.35rem;">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h5 class="fw-black text-slate-900 mb-0">Modify Account: {{ $staff->UserName }}</h5>
                            <p class="text-muted small mb-0">Adjust system permissions or regenerate credentials</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.staff.update', $staff->Sid) }}" method="POST" id="staffEditForm">
                        @csrf
                        @method('PUT')

                        <!-- Username Field -->
                        <div class="mb-4">
                            <label for="UserName" class="form-label fw-bold small text-slate-700">
                                Staff Username <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-slate-50 border-end-0 text-slate-400">
                                    <i class="bi bi-at"></i>
                                </span>
                                <input type="text" name="UserName" id="UserName" 
                                       class="form-control bg-slate-50 border-start-0 ps-0 @error('UserName') is-invalid @enderror" 
                                       placeholder="e.g. sarah_k or alex.stock" 
                                       value="{{ old('UserName', $staff->UserName) }}" required autofocus
                                       oninput="updatePreviewName(this.value)">
                            </div>
                            @error('UserName')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @else
                                <div class="text-muted small mt-1" style="font-size: 0.78rem;">
                                    Username for login into the FreshMart administration and stock console.
                                </div>
                            @enderror
                        </div>

                        <!-- Role Interactive Selector -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-slate-700 d-flex justify-content-between">
                                <span>Assigned Privilege Role <span class="text-danger">*</span></span>
                                <span class="text-muted fw-normal small">Toggle permission tier</span>
                            </label>

                            <input type="hidden" name="Role" id="RoleInput" value="{{ old('Role', $staff->Role) }}">

                            <div class="row g-3">
                                <!-- Option: Stock Controller -->
                                <div class="col-md-6">
                                    <div class="role-card p-3 border rounded-3 cursor-pointer position-relative {{ old('Role', $staff->Role) === 'Stock' ? 'role-selected' : '' }}" 
                                         id="roleStockCard" onclick="selectRole('Stock')">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(14, 165, 233, 0.12); color: #0284c7; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-boxes"></i>
                                                </div>
                                                <span class="fw-bold text-slate-900 small">Stock Controller</span>
                                            </div>
                                            <i class="bi bi-check-circle-fill text-success role-check-icon {{ old('Role', $staff->Role) === 'Stock' ? '' : 'd-none' }}" id="stockCheck"></i>
                                        </div>
                                        <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                            Product catalog, live inventory stocks, aisles, and shelf expiry alerts.
                                        </p>
                                    </div>
                                </div>

                                <!-- Option: Administrator -->
                                <div class="col-md-6">
                                    <div class="role-card p-3 border rounded-3 cursor-pointer position-relative {{ old('Role', $staff->Role) === 'Admin' ? 'role-selected' : '' }}" 
                                         id="roleAdminCard" onclick="selectRole('Admin')">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(250, 204, 21, 0.18); color: #b45309; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-shield-fill-check"></i>
                                                </div>
                                                <span class="fw-bold text-slate-900 small">Administrator</span>
                                            </div>
                                            <i class="bi bi-check-circle-fill text-success role-check-icon {{ old('Role', $staff->Role) === 'Admin' ? '' : 'd-none' }}" id="adminCheck"></i>
                                        </div>
                                        <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                            Full executive access: sales analytics, customer orders, tax invoices, and staff registry.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reset Password Field (Optional) -->
                        <div class="mb-4">
                            <label for="Password" class="form-label fw-bold small text-slate-700">
                                Reset Password <span class="text-muted fw-normal">(Optional)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-slate-50 border-end-0 text-slate-400">
                                    <i class="bi bi-key-fill"></i>
                                </span>
                                <input type="password" name="Password" id="Password" 
                                       class="form-control bg-slate-50 border-start-0 border-end-0 ps-0 @error('Password') is-invalid @enderror" 
                                       placeholder="Leave blank to keep existing password">
                                <button type="button" class="input-group-text bg-slate-50 border-start-0 text-slate-400" 
                                        onclick="togglePasswordVisibility('Password', this)" title="Show/Hide Password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('Password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @else
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <span class="text-muted small" style="font-size: 0.78rem;">Leave blank unless you wish to overwrite the current password.</span>
                                    <button type="button" class="btn btn-link p-0 text-decoration-none small fw-semibold text-warning" 
                                            style="font-size: 0.78rem;" onclick="generateRandomPassword()">
                                        <i class="bi bi-magic me-1"></i> Generate New Password
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <!-- Form Submission Actions -->
                        <div class="d-flex align-items-center gap-3 pt-3 border-top border-slate-100">
                            <button type="submit" class="btn btn-gold px-4 py-2 d-inline-flex align-items-center gap-2">
                                <i class="bi bi-save2-fill"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.staff.index') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold text-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Danger Zone (Delete Account if not current user) -->
                @if(Auth::guard('staff')->id() != $staff->Sid)
                    <div class="admin-card p-4 mt-4 border-danger border-opacity-25" style="background: #fffafa;">
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <div>
                                <h6 class="fw-bold text-danger mb-1">Revoke & Terminate Account</h6>
                                <p class="text-muted small mb-0">Permanently delete this staff member's credentials and revoke portal access.</p>
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 fw-bold text-nowrap"
                                    data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                                    data-action="{{ route('admin.staff.destroy', $staff->Sid) }}"
                                    data-name="{{ $staff->UserName }} ({{ $staff->Role }})"
                                    data-id="#{{ str_pad($staff->Sid, 4, '0', STR_PAD_LEFT) }}"
                                    data-type="Staff Account">
                                <i class="bi bi-trash3-fill me-1"></i> Delete Account
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Identity Card Live Preview Column -->
            <div class="col-lg-4">
                <div class="admin-card p-4">
                    <span class="text-muted text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.08em;">Live Identity Preview</span>
                    <h6 class="fw-bold text-slate-900 mt-1 mb-3">Staff Identity Badge</h6>

                    <div class="p-3 rounded-4 text-center border" style="background: linear-gradient(145deg, #090d16 0%, #172136 100%);">
                        <div class="avatar-preview mx-auto mb-3" id="previewAvatar" 
                             style="width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, #facc15 0%, #ca8a04 100%); color: #0f172a; font-size: 1.5rem; font-weight: 900; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(250, 204, 21, 0.35);">
                            {{ strtoupper(substr($staff->UserName, 0, 1)) }}
                        </div>
                        <h6 class="text-white fw-bold mb-1" id="previewUsername">{{ $staff->UserName }}</h6>
                        <div id="previewRoleBadge" class="d-inline-flex align-items-center gap-1 px-3 py-1 rounded-pill small fw-bold mt-1" 
                             style="{{ $staff->Role === 'Admin' ? 'background: rgba(250, 204, 21, 0.15); color: #fef08a; border: 1px solid rgba(250, 204, 21, 0.3);' : 'background: rgba(14, 165, 233, 0.15); color: #7dd3fc; border: 1px solid rgba(14, 165, 233, 0.3);' }} font-size: 0.75rem;">
                            <i class="bi {{ $staff->Role === 'Admin' ? 'bi-shield-fill-check' : 'bi-boxes' }}"></i> 
                            <span>{{ strtoupper($staff->Role === 'Admin' ? 'ADMINISTRATOR' : 'STOCK CONTROLLER') }}</span>
                        </div>
                        <div class="text-slate-400 small mt-3 pt-3 border-top border-secondary border-opacity-25" style="font-size: 0.72rem;">
                            FreshMart SSMS Supermarket Division
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded-3 bg-slate-50 border border-slate-100">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-shield-check text-success mt-1"></i>
                            <div class="small text-slate-600">
                                <strong>Active Account:</strong> Updates take effect immediately on next page navigation or re-login.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('styles')
<style>
    .role-card {
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        border-color: #e2e8f0 !important;
    }
    .role-card:hover {
        border-color: #cbd5e1 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .role-card.role-selected {
        border-color: #facc15 !important;
        background: #fffbeb !important;
        box-shadow: 0 0 0 1.5px #facc15, 0 4px 12px rgba(250, 204, 21, 0.12);
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection

@section('scripts')
<script>
    function selectRole(role) {
        document.getElementById('RoleInput').value = role;
        
        const stockCard = document.getElementById('roleStockCard');
        const adminCard = document.getElementById('roleAdminCard');
        const stockCheck = document.getElementById('stockCheck');
        const adminCheck = document.getElementById('adminCheck');
        const previewRoleBadge = document.getElementById('previewRoleBadge');

        if (role === 'Admin') {
            adminCard.classList.add('role-selected');
            stockCard.classList.remove('role-selected');
            adminCheck.classList.remove('d-none');
            stockCheck.classList.add('d-none');

            previewRoleBadge.style.background = 'rgba(250, 204, 21, 0.15)';
            previewRoleBadge.style.color = '#fef08a';
            previewRoleBadge.style.borderColor = 'rgba(250, 204, 21, 0.3)';
            previewRoleBadge.innerHTML = '<i class="bi bi-shield-fill-check"></i> <span>ADMINISTRATOR</span>';
        } else {
            stockCard.classList.add('role-selected');
            adminCard.classList.remove('role-selected');
            stockCheck.classList.remove('d-none');
            adminCheck.classList.add('d-none');

            previewRoleBadge.style.background = 'rgba(14, 165, 233, 0.15)';
            previewRoleBadge.style.color = '#7dd3fc';
            previewRoleBadge.style.borderColor = 'rgba(14, 165, 233, 0.3)';
            previewRoleBadge.innerHTML = '<i class="bi bi-boxes"></i> <span>STOCK CONTROLLER</span>';
        }
    }

    function updatePreviewName(name) {
        const previewName = document.getElementById('previewUsername');
        const previewAvatar = document.getElementById('previewAvatar');
        
        if (name && name.trim().length > 0) {
            previewName.textContent = name;
            previewAvatar.textContent = name.trim().charAt(0).toUpperCase();
        } else {
            previewName.textContent = 'username';
            previewAvatar.textContent = '?';
        }
    }

    function togglePasswordVisibility(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            field.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    function generateRandomPassword() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#$%';
        let pass = '';
        for (let i = 0; i < 10; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        const pwdInput = document.getElementById('Password');
        pwdInput.value = pass;
        pwdInput.type = 'text';
        navigator.clipboard.writeText(pass).then(() => {
            alert('Generated new password: ' + pass + '\n(Copied to clipboard!)');
        }).catch(() => {
            alert('Generated new password: ' + pass);
        });
    }

    // Initialize with current value
    document.addEventListener('DOMContentLoaded', () => {
        const currentRole = document.getElementById('RoleInput').value;
        selectRole(currentRole);
    });
</script>
@endsection
