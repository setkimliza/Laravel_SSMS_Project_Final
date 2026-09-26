@extends('layouts.admin')

@section('title', 'Manage Orders - FreshMart SSMS')
@section('page-title', 'Customer Orders Management')
@section('page-subtitle', 'Monitor live order queues, delivery statuses, and invoices')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <!-- Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex flex-wrap gap-2">
            <input type="text" name="search" class="form-control form-control-sm rounded-pill ps-3" 
                   placeholder="Search Order # or Customer..." value="{{ request('search') }}" style="min-width: 240px;">
            <select name="status" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-sm btn-secondary rounded-pill px-3">Filter</button>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Order #</th>
                    <th>Customer</th>
                    <th>Date & Time</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th class="pe-3 text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="ps-3 fw-bold text-dark">#{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $order->user->name ?? 'Guest User' }}</div>
                            <div class="text-muted small">{{ $order->user->email ?? '' }}</div>
                        </td>
                        <td class="small text-secondary">
                            {{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, Y - h:i A') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border rounded-pill">
                                {{ $order->orderDetails->sum('Quantity') }} items
                            </span>
                        </td>
                        <td class="fw-bold text-dark">${{ number_format($order->TotalAmount, 2) }}</td>
                        <td class="small">{{ $order->payment_method }}</td>
                        <td>
                            <span class="badge {{ $order->status_badge }} rounded-pill px-3 py-1">
                                {{ $order->Status }}
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('admin.orders.show', $order->OrderID) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                <i class="bi bi-receipt me-1"></i> Invoice
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No supermarket orders found matching criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
