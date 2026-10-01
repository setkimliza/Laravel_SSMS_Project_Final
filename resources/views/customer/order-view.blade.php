@extends('layouts.app')

@section('title', 'Order Details #' . $order->OrderID . ' - FreshMart')

@section('content')
<div class="container pb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.history') }}" class="text-decoration-none text-muted">My Orders</a></li>
            <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Order #{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
                    <div>
                        <span class="badge fw-bold px-3 py-1 rounded-pill mb-2" style="background: #fef08a; color: #854d0e;">Order Invoice</span>
                        <h3 class="fw-bold mb-0">Order #{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}</h3>
                        <div class="text-muted small">Date: {{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, Y - h:i A') }}</div>
                    </div>
                    <div class="text-end">
                        <span class="badge {{ $order->status_badge }} rounded-pill px-3 py-2 fs-6 mb-2 d-inline-block">
                            {{ $order->Status }}
                        </span>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="window.print();">
                                <i class="bi bi-printer me-1"></i> Print Invoice
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4 bg-light p-3 rounded-4">
                    <div class="col-sm-6">
                        <div class="text-muted small">Recipient:</div>
                        <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                        <div class="small text-secondary">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Payment & Delivery:</div>
                        <div class="fw-semibold text-dark">{{ $order->payment_method }}</div>
                        <div class="small text-secondary">{{ $order->shipping_address }}</div>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $detail->product->PName ?? 'SKU #' . $detail->PID }}</div>
                                        <div class="badge-category">{{ $detail->product->category->name ?? 'General' }}</div>
                                    </td>
                                    <td class="text-center fw-semibold">{{ $detail->Quantity }}</td>
                                    <td class="text-end">${{ number_format($detail->Price, 2) }}</td>
                                    <td class="text-end fw-bold">${{ number_format($detail->Subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total Paid:</td>
                                <td class="text-end fw-bold fs-5" style="color: #ca8a04;">${{ number_format($order->TotalAmount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i> Back to Orders
                    </a>
                    <a href="{{ route('catalog') }}" class="btn btn-fresh rounded-pill px-4">
                        Shop Mini Mart Again
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
