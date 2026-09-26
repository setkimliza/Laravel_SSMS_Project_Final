@extends('layouts.admin')

@section('title', 'Staff Management - FreshMart SSMS')
@section('page-title', 'Staff Accounts & Roles')
@section('page-subtitle', 'Manage supermarket administrators and stock controllers')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <!-- Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <form action="{{ route('admin.staff.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm rounded-pill ps-3" 
                   placeholder="Search username..." value="{{ request('search') }}" style="min-width: 220px;">
            <select name="role" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                <option value="">All Roles</option>
                <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Stock" {{ request('role') == 'Stock' ? 'selected' : '' }}>Stock</option>
            </select>
            <button type="submit" class="btn btn-sm btn-secondary rounded-pill px-3">Filter</button>
        </form>

        <a href="{{ route('admin.staff.create') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold d-flex align-items-center gap-1">
            <i class="bi bi-person-plus-fill"></i> Add New Staff
        </a>
    </div>

    <!-- Staff Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Staff ID (Sid)</th>
                    <th>Username</th>
                    <th>Assigned Role</th>
                    <th>Created At</th>
                    <th class="pe-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffList as $staff)
                    <tr>
                        <td class="ps-3 fw-bold text-dark">#{{ str_pad($staff->Sid, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-light border text-dark d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">
                                    {{ strtoupper(substr($staff->UserName, 0, 1)) }}
                                </div>
                                <span class="fw-bold">{{ $staff->UserName }}</span>
                                @if(Auth::guard('staff')->id() == $staff->Sid)
                                    <span class="badge bg-secondary-subtle text-secondary small">(You)</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($staff->isAdmin())
                                <span class="badge bg-purple-subtle text-purple border" style="background: #ede9fe; color: #6d28d9; padding: 0.35rem 0.75rem; border-radius: 9999px;">
                                    <i class="bi bi-shield-check me-1"></i> Admin
                                </span>
                            @else
                                <span class="badge bg-info-subtle text-info-emphasis border" style="background: #e0f2fe; color: #0369a1; padding: 0.35rem 0.75rem; border-radius: 9999px;">
                                    <i class="bi bi-boxes me-1"></i> Stock
                                </span>
                            @endif
                        </td>
                        <td class="small text-secondary">{{ $staff->created_at ? $staff->created_at->format('M d, Y') : 'N/A' }}</td>
                        <td class="pe-3 text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.staff.edit', $staff->Sid) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="Edit Staff">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if(Auth::guard('staff')->id() != $staff->Sid)
                                    <form action="{{ route('admin.staff.destroy', $staff->Sid) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete staff account {{ $staff->UserName }}?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Delete Staff">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No staff members found matching criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $staffList->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
