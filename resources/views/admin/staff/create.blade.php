@extends('layouts.admin')

@section('title', 'Add New Staff - FreshMart SSMS')
@section('page-title', 'Create Staff Account')
@section('page-subtitle', 'Add an Administrator or Stock Controller to the system')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Staff Details</h5>
                <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="UserName" class="form-label fw-semibold small text-secondary">Username <span class="text-danger">*</span></label>
                    <input type="text" name="UserName" id="UserName" class="form-control" 
                           placeholder="e.g. jsmith or stock_alex" value="{{ old('UserName') }}" required autofocus>
                    <div class="form-text small">Used for staff authentication into the management portal.</div>
                </div>

                <div class="mb-3">
                    <label for="Role" class="form-label fw-semibold small text-secondary">Assign System Role <span class="text-danger">*</span></label>
                    <select name="Role" id="Role" class="form-select" required>
                        <option value="Stock" {{ old('Role') == 'Stock' ? 'selected' : '' }}>Stock Controller (Products & Categories Management)</option>
                        <option value="Admin" {{ old('Role') == 'Admin' ? 'selected' : '' }}>Administrator (Full Access & Staff Management)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="Password" class="form-label fw-semibold small text-secondary">Initial Security Password <span class="text-danger">*</span></label>
                    <input type="password" name="Password" id="Password" class="form-control" 
                           placeholder="Minimum 6 characters" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-check2-circle me-1"></i> Create Staff Member
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
