@extends('layouts.admin')

@section('title', 'Staff Management - FreshMart Supermarket')
@section('page-title', 'Staff Accounts & Access Controls')
@section('page-subtitle', 'Manage supermarket administrators and inventory stock controllers')

@section('content')

<!-- Staff Overview Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-2">
                <div>
                    <span class="bento-stat-label">Total Personnel</span>
                    <div class="bento-stat-num mt-1" style="color: #0f172a;">{{ $staffList->total() }}</div>
                </div>
                <div class="bento-icon-wrapper bento-icon-gold">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="text-muted small border-top pt-2">Active portal operators</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-2">
                <div>
                    <span class="bento-stat-label">Administrators</span>
                    <div class="bento-stat-num mt-1" style="color: #ca8a04;">
                        {{ \App\Models\Staff::where('Role', 'Admin')->count() }}
                    </div>
                </div>
                <div class="bento-icon-wrapper bento-icon-gold">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
            </div>
            <div class="text-muted small border-top pt-2">Full executive authorization</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card-bento-kpi">
            <div class="d-flex align-items-start justify-content-between mb-2">
                <div>
                    <span class="bento-stat-label">Stock Controllers</span>
                    <div class="bento-stat-num mt-1" style="color: #0369a1;">
                        {{ \App\Models\Staff::where('Role', 'Stock')->count() }}
                    </div>
                </div>
                <div class="bento-icon-wrapper bento-icon-blue">
                    <i class="bi bi-boxes"></i>
                </div>
            </div>
            <div class="text-muted small border-top pt-2">Inventory & product CRUD</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 d-flex flex-column justify-content-center align-items-start">
            <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">Quick Provision</span>
            <h6 class="fw-black text-dark mt-1 mb-2">New Team Member</h6>
            <a href="{{ route('admin.staff.create') }}" class="btn-gold btn-sm d-inline-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i>
                <span>Add Staff Member</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Staff List Table Card -->
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <!-- Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom border-light-subtle">
        <div>
            <h5 class="fw-black text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-person-badge-fill text-warning"></i> Authorized Personnel Registry
            </h5>
            <span class="text-muted small">Manage authentication access and operational roles</span>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('admin.staff.index') }}" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm" style="min-width: 220px;">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" 
                           placeholder="Search username..." value="{{ request('search') }}">
                </div>
                <select name="role" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Stock" {{ request('role') == 'Stock' ? 'selected' : '' }}>Stock</option>
                </select>
                <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3 fw-bold">Filter</button>
            </form>

            <a href="{{ route('admin.staff.create') }}" class="btn btn-sm btn-warning rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-person-plus-fill"></i> Add Staff
            </a>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="table-responsive">
        <table class="table-executive">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Personnel Identity</th>
                    <th>Assigned Role</th>
                    <th>Account Created</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffList as $staff)
                    <tr>
                        <td class="fw-black text-dark">
                            <span class="badge bg-light text-dark border px-2 py-1">
                                #{{ str_pad($staff->Sid, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-black shadow-sm" style="width: 36px; height: 36px; {{ $staff->isAdmin() ? 'background: linear-gradient(135deg, #facc15 0%, #ca8a04 100%); color: #0f172a;' : 'background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%); color: #ffffff;' }}">
                                    {{ strtoupper(substr($staff->UserName, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6 d-flex align-items-center gap-2">
                                        <span>{{ $staff->UserName }}</span>
                                        @if(Auth::guard('staff')->id() == $staff->Sid)
                                            <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill" style="font-size: 0.68rem;">You</span>
                                        @endif
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.72rem;">Portal Operator</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($staff->isAdmin())
                                <span class="sidebar-user-role-admin">
                                    <i class="bi bi-shield-fill-check"></i> Administrator
                                </span>
                            @else
                                <span class="sidebar-user-role-stock">
                                    <i class="bi bi-boxes"></i> Stock Controller
                                </span>
                            @endif
                        </td>
                        <td class="small text-secondary">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $staff->created_at ? $staff->created_at->format('M d, Y') : 'System Initialized' }}
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.staff.edit', $staff->Sid) }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" title="Edit Staff Member">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Edit</span>
                                </a>

                                @if(Auth::guard('staff')->id() != $staff->Sid)
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2" 
                                            data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                                            data-action="{{ route('admin.staff.destroy', $staff->Sid) }}"
                                            data-name="{{ $staff->UserName }} ({{ $staff->Role }})"
                                            data-id="#{{ str_pad($staff->Sid, 4, '0', STR_PAD_LEFT) }}"
                                            data-type="Staff Account"
                                            title="Revoke and Delete Staff Account">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">No staff members found matching criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4 pt-3 border-top border-light-subtle">
        <span class="text-muted small">Showing {{ $staffList->count() }} accounts</span>
        <div>
            {{ $staffList->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
