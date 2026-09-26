@extends('layouts.admin')

@section('title', 'Edit Staff Member - FreshMart SSMS')
@section('page-title', 'Edit Staff Account #' . $staff->Sid)
@section('page-subtitle', 'Modify username, role, or reset password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Update Staff Credentials</h5>
                <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <form action="{{ route('admin.staff.update', $staff->Sid) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="UserName" class="form-label fw-semibold small text-secondary">Username <span class="text-danger">*</span></label>
                    <input type="text" name="UserName" id="UserName" class="form-control" 
                           value="{{ old('UserName', $staff->UserName) }}" required>
                </div>

                <div class="mb-3">
                    <label for="Role" class="form-label fw-semibold small text-secondary">Assign System Role <span class="text-danger">*</span></label>
                    <select name="Role" id="Role" class="form-select" required>
                        <option value="Stock" {{ old('Role', $staff->Role) == 'Stock' ? 'selected' : '' }}>Stock Controller (Products & Categories Management)</option>
                        <option value="Admin" {{ old('Role', $staff->Role) == 'Admin' ? 'selected' : '' }}>Administrator (Full Access & Staff Management)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="Password" class="form-label fw-semibold small text-secondary">Reset Password</label>
                    <input type="password" name="Password" id="Password" class="form-control" 
                           placeholder="Leave blank to keep existing password">
                    <div class="form-text small">Only fill this if you want to overwrite this staff member's password.</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-light rounded-pill px-3">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
