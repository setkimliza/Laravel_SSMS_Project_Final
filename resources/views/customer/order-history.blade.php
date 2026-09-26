@extends('layouts.app')

@section('title', 'My Order History - FreshMart')

@section('content')
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-clock-history text-success me-2"></i> My Order History</h2>
            <span class="text-muted small">Track your previous grocery purchases and view past receipts</span>
        </div>
        <a href="{{ route('catalog') }}" class="btn btn-sm btn-outline-fresh">
            <i class="bi bi-cart4 me-1"></i> Order Groceries
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Order #</th>
                            <th>Date & Time</th>
                            <th>Items Purchased</th>
                            <th>Payment</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-dark">
                                    #{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="text-secondary small">
                                    {{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, Y - h:i A') }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border rounded-pill">
                                        {{ $order->orderDetails->sum('Quantity') }} items
                                    </span>
                                </td>
                                <td class="small text-secondary">{{ $order->payment_method }}</td>
                                <td class="fw-bold text-dark">${{ number_format($order->TotalAmount, 2) }}</td>
                                <td>
                                    <span class="badge {{ $order->status_badge }} rounded-pill px-3 py-1">
                                        {{ $order->Status }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('orders.detail', $order->OrderID) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="bi bi-eye me-1"></i> View Receipt
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-5 p-5 text-center bg-white my-4">
            <div class="rounded-circle bg-light d-inline-flex p-4 mx-auto mb-3 text-muted">
                <i class="bi bi-receipt fs-1 text-secondary"></i>
            </div>
            <h4 class="fw-bold mb-2">No Past Orders Found</h4>
            <p class="text-muted small mb-4">You have not completed any grocery orders with FreshMart yet.</p>
            <div>
                <a href="{{ route('catalog') }}" class="btn btn-fresh rounded-pill px-4">
                    Explore Groceries & Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
