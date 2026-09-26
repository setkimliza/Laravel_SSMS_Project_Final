@extends('layouts.app')

@section('title', 'Order Confirmation #' . $order->OrderID . ' - FreshMart')

@section('content')
<div class="container py-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Confirmation Header Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 text-center bg-white mb-4">
                <div class="rounded-circle bg-success-subtle text-success d-inline-flex p-3 mx-auto mb-3">
                    <i class="bi bi-check-lg display-4"></i>
                </div>
                <h2 class="fw-extrabold text-dark mb-1">Thank You! Order Confirmed</h2>
                <p class="text-muted mb-3">Your grocery order has been received and stock has been automatically deducted.</p>

                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border mx-auto">
                    <span class="text-muted small">Order Number:</span>
                    <strong class="text-dark">#{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}</strong>
                    <span class="badge bg-success ms-2">{{ $order->Status }}</span>
                </div>
            </div>

            <!-- Receipt Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" id="printableInvoice">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Supermarket Sales Receipt</h5>
                        <div class="text-muted small">Placed on: {{ \Carbon\Carbon::parse($order->OrderDate)->format('F d, Y - h:i A') }}</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="window.print();">
                        <i class="bi bi-printer me-1"></i> Print Receipt
                    </button>
                </div>

                <!-- Customer Details Grid -->
                <div class="row g-3 mb-4 bg-light p-3 rounded-3">
                    <div class="col-sm-6">
                        <div class="text-muted small">Customer Name:</div>
                        <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                        <div class="text-muted small">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Payment Method:</div>
                        <div class="fw-bold text-dark">{{ $order->payment_method }}</div>
                        <div class="text-muted small">Delivery Address: {{ $order->shipping_address }}</div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $detail->product->PName ?? 'Product SKU #' . $detail->PID }}</div>
                                        <div class="text-muted small">Product ID: #{{ $detail->PID }}</div>
                                    </td>
                                    <td class="text-center fw-semibold">{{ $detail->Quantity }}</td>
                                    <td class="text-end">${{ number_format($detail->Price, 2) }}</td>
                                    <td class="text-end fw-bold text-dark">${{ number_format($detail->Subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Grand Total Paid:</td>
                                <td class="text-end display-6 fw-bold text-success fs-5">
                                    ${{ number_format($order->TotalAmount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->customer_notes)
                    <div class="p-3 bg-light rounded-3 text-muted small">
                        <strong>Delivery Notes:</strong> {{ $order->customer_notes }}
                    </div>
                @endif
            </div>

            <!-- Action buttons -->
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('orders.history') }}" class="btn btn-outline-fresh rounded-pill px-4">
                    <i class="bi bi-clock-history me-1"></i> View Order History
                </a>
                <a href="{{ route('catalog') }}" class="btn btn-fresh rounded-pill px-4">
                    <i class="bi bi-cart4 me-1"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
