@extends('layouts.admin')

@section('title', 'Manage Customer Orders - FreshMart Supermarket')
@section('page-title', 'Customer Orders Management')
@section('page-subtitle', 'Track live checkout queues, update order fulfillment statuses, and issue invoices')

@section('content')

@php
    $allCount = \App\Models\Order::count();
    $pendingCount = \App\Models\Order::where('Status', 'Pending')->count();
    $processingCount = \App\Models\Order::where('Status', 'Processing')->count();
    $completedCount = \App\Models\Order::where('Status', 'Completed')->count();
    $cancelledCount = \App\Models\Order::where('Status', 'Cancelled')->count();
@endphp

<!-- Order Status Quick Filter Tabs -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.orders.index') }}" 
       class="btn btn-sm rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-2 {{ !request('status') ? 'btn-dark' : 'btn-white bg-white border text-dark' }}">
        <span>All Orders</span>
        <span class="badge {{ !request('status') ? 'bg-light text-dark' : 'bg-light border text-muted' }} rounded-pill">{{ $allCount }}</span>
    </a>
    <a href="{{ route('admin.orders.index') }}?status=Pending" 
       class="btn btn-sm rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-2 {{ request('status') == 'Pending' ? 'btn-warning text-dark' : 'btn-white bg-white border text-dark' }}">
        <span>Pending</span>
        <span class="badge {{ request('status') == 'Pending' ? 'bg-dark text-warning' : 'bg-warning-subtle text-warning-emphasis' }} rounded-pill">{{ $pendingCount }}</span>
    </a>
    <a href="{{ route('admin.orders.index') }}?status=Processing" 
       class="btn btn-sm rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-2 {{ request('status') == 'Processing' ? 'btn-info text-white' : 'btn-white bg-white border text-dark' }}">
        <span>Processing</span>
        <span class="badge {{ request('status') == 'Processing' ? 'bg-white text-info' : 'bg-info-subtle text-info-emphasis' }} rounded-pill">{{ $processingCount }}</span>
    </a>
    <a href="{{ route('admin.orders.index') }}?status=Completed" 
       class="btn btn-sm rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-2 {{ request('status') == 'Completed' ? 'btn-success text-white' : 'btn-white bg-white border text-dark' }}">
        <span>Completed</span>
        <span class="badge {{ request('status') == 'Completed' ? 'bg-white text-success' : 'bg-success-subtle text-success' }} rounded-pill">{{ $completedCount }}</span>
    </a>
    <a href="{{ route('admin.orders.index') }}?status=Cancelled" 
       class="btn btn-sm rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-2 {{ request('status') == 'Cancelled' ? 'btn-danger text-white' : 'btn-white bg-white border text-dark' }}">
        <span>Cancelled</span>
        <span class="badge {{ request('status') == 'Cancelled' ? 'bg-white text-danger' : 'bg-danger-subtle text-danger' }} rounded-pill">{{ $cancelledCount }}</span>
    </a>
</div>

<!-- Main Orders Card & Table -->
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <!-- Search & Filter Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom border-light-subtle">
        <div>
            <h5 class="fw-black text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-receipt-cutoff text-warning"></i> Customer Transaction Queue
            </h5>
            <span class="text-muted small">Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} records</span>
        </div>

        <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex flex-wrap gap-2">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <div class="input-group input-group-sm" style="min-width: 260px;">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" 
                       placeholder="Search Order # or Customer..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3 fw-bold">Search</button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">Reset</a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table-executive">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer Name</th>
                    <th>Date & Time</th>
                    <th>Cart Items</th>
                    <th>Total Price</th>
                    <th>Payment Details</th>
                    <th>Current Status</th>
                    <th class="text-end">Invoice Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="fw-black text-dark">
                            <span class="badge bg-light text-dark border px-2 py-1">
                                #{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-light border text-dark fw-black d-flex align-items-center justify-content-center small" style="width: 34px; height: 34px;">
                                    {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $order->user->name ?? 'Guest User' }}</div>
                                    <div class="text-muted small" style="font-size: 0.72rem;">{{ $order->user->email ?? 'Direct Order' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small text-secondary">
                            <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, Y') }}</div>
                            <div class="text-muted" style="font-size: 0.72rem;">{{ \Carbon\Carbon::parse($order->OrderDate)->format('h:i A') }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small">
                                <i class="bi bi-box-seam me-1 text-warning"></i>
                                {{ $order->orderDetails->sum('Quantity') }} items
                            </span>
                        </td>
                        <td class="fw-black text-dark fs-6">
                            ${{ number_format($order->TotalAmount, 2) }}
                        </td>
                        <td class="small">
                            <span class="d-inline-flex align-items-center gap-1 badge bg-light text-dark border rounded-pill px-2 py-1">
                                <i class="bi {{ str_contains(strtolower($order->payment_method), 'cash') ? 'bi-cash-coin text-success' : 'bi-credit-card-fill text-primary' }}"></i>
                                <span>{{ $order->payment_method }}</span>
                            </span>
                        </td>
                        <td>
                            @php
                                $statusBadgeClass = match(strtolower($order->Status)) {
                                    'completed' => 'badge-status-completed',
                                    'processing' => 'badge-status-processing',
                                    'pending' => 'badge-status-pending',
                                    default => 'badge-status-cancelled',
                                };
                            @endphp
                            <span class="{{ $statusBadgeClass }}">
                                {{ $order->Status }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order->OrderID) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1">
                                <i class="bi bi-receipt"></i>
                                <span>Details</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 text-secondary d-block mb-2"></i>
                            No supermarket customer orders found matching criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4 pt-3 border-top border-light-subtle">
        <span class="text-muted small">Displaying up to 12 orders per page</span>
        <div>
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
