@extends('layouts.app')

@section('title', 'Order History - FreshMart')

@section('content')
<div class="container pb-5" style="max-width: 1140px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Order History</h1>
            <p class="text-muted small mb-0">Track and review your past mini mart orders and receipts.</p>
        </div>
        <a href="{{ route('catalog') }}" class="btn btn-outline-fresh btn-sm">
            Browse Mini Mart
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="card border rounded-4 overflow-hidden bg-white mb-4" style="border: 1.5px solid #fef08a !important; box-shadow: 0 4px 14px rgba(250, 204, 21, 0.08);">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 0.04em;">
                            <th class="ps-4">Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-dark">
                                    #{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="text-secondary small">
                                    {{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, Y · h:i A') }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border">
                                        {{ $order->orderDetails->sum('Quantity') }} items
                                    </span>
                                </td>
                                <td class="small text-secondary">{{ $order->payment_method }}</td>
                                <td class="fw-bold text-dark">${{ number_format($order->TotalAmount, 2) }}</td>
                                <td>
                                    <span class="badge {{ $order->status_badge }} rounded-1 px-2 py-1 small">
                                        {{ $order->Status }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('orders.detail', $order->OrderID) }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">
                                        View Receipt
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
        <div class="card border rounded-3 p-5 text-center bg-white my-4">
            <div class="rounded-circle bg-light d-inline-flex p-3 mx-auto mb-3 text-secondary" style="width: 64px; height: 64px; align-items: center; justify-content: center;">
                <i class="bi bi-receipt fs-3 text-muted"></i>
            </div>
            <h2 class="h5 fw-bold text-dark mb-2">No Past Orders Found</h2>
            <p class="text-muted small mb-4" style="max-width: 400px; margin: 0 auto;">
                You haven't placed any grocery orders yet. Discover our fresh catalog today.
            </p>
            <div>
                <a href="{{ route('catalog') }}" class="btn btn-fresh btn-sm px-4">
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
