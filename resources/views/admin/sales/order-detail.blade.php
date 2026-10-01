@extends('layouts.admin')

@section('title', 'Order Invoice #' . $order->OrderID . ' - FreshMart Supermarket')
@section('page-title', 'Order #' . str_pad($order->OrderID, 5, '0', STR_PAD_LEFT))
@section('page-subtitle', 'Supermarket customer transaction details and printable commercial invoice')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        <!-- Top Order Management Action Bar -->
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    @php
                        $statusClass = match(strtolower($order->Status)) {
                            'completed' => 'badge-status-completed',
                            'processing' => 'badge-status-processing',
                            'pending' => 'badge-status-pending',
                            default => 'badge-status-cancelled',
                        };
                    @endphp
                    <span class="{{ $statusClass }} fs-6 px-3 py-1">
                        {{ $order->Status }}
                    </span>
                    <span class="text-muted small">
                        <i class="bi bi-clock me-1"></i> Recorded {{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, Y - h:i A') }}
                    </span>
                </div>

                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <!-- Update Status Form -->
                    <form action="{{ route('admin.orders.status', $order->OrderID) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <select name="status" class="form-select form-select-sm rounded-pill" style="min-width: 140px;">
                            <option value="Completed" {{ $order->Status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Processing" {{ $order->Status == 'Processing' ? 'selected' : '' }}>Processing</option>
                            <option value="Pending" {{ $order->Status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Cancelled" {{ $order->Status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3 fw-bold text-nowrap">Update</button>
                    </form>

                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" onclick="window.print();">
                        <i class="bi bi-printer me-1"></i> Print Invoice
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold">
                        Back to Queue
                    </a>
                </div>
            </div>
        </div>

        <!-- Luxury Printable Invoice Container -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-4" id="printableInvoice">
            <!-- Invoice Header -->
            <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-warning d-flex align-items-center justify-content-center text-dark" style="width: 54px; height: 54px; font-size: 1.8rem; box-shadow: 0 4px 12px rgba(250, 204, 21, 0.35);">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <div>
                        <h4 class="fw-black text-dark mb-0 tracking-tight">Fresh<span class="text-warning">Mart</span>™ Supermarket</h4>
                        <div class="text-muted small">Neighborhood Storefront & Express Fulfillment</div>
                        <div class="text-muted small">100 Sunrise Blvd, Metro City &bull; Phone: (555) 019-2834</div>
                    </div>
                </div>

                <div class="text-md-end">
                    <span class="badge bg-light text-dark border px-3 py-1 rounded-pill small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Commercial Tax Invoice</span>
                    <h3 class="fw-black text-dark mt-2 mb-0">#{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}</h3>
                    <div class="text-muted small mt-1">{{ \Carbon\Carbon::parse($order->OrderDate)->format('F d, Y - h:i A') }}</div>
                </div>
            </div>

            <!-- Customer & Delivery Bento Strip -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light border border-light-subtle h-100">
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.05em;">Customer Account Details</span>
                        <div class="fw-black text-dark fs-6 mt-1">{{ $order->user->name ?? 'Direct Walk-In Shopper' }}</div>
                        <div class="text-secondary small mt-1"><i class="bi bi-envelope me-1"></i> {{ $order->user->email ?? 'No email on record' }}</div>
                        <div class="text-secondary small mt-1"><i class="bi bi-telephone me-1"></i> {{ $order->user->phone ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light border border-light-subtle h-100">
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.05em;">Fulfillment & Payment</span>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-white border text-dark fw-bold">
                                <i class="bi {{ str_contains(strtolower($order->payment_method), 'cash') ? 'bi-cash-coin text-success' : 'bi-credit-card-fill text-primary' }} me-1"></i>
                                {{ $order->payment_method }}
                            </span>
                            <span class="{{ $statusClass }}">
                                {{ $order->Status }}
                            </span>
                        </div>
                        <div class="text-secondary small mt-2">
                            <i class="bi bi-geo-alt me-1 text-danger"></i>
                            <strong>Destination:</strong> {{ $order->shipping_address ?? 'Store pickup' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items Table -->
            <div class="table-responsive mb-4">
                <table class="table-executive">
                    <thead>
                        <tr>
                            <th class="ps-3">Item SKU</th>
                            <th>Description</th>
                            <th>Aisle Department</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end pe-3">Line Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $detail)
                            <tr>
                                <td class="ps-3 text-muted fw-bold">#{{ str_pad($detail->PID, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="fw-black text-dark">{{ $detail->product->PName ?? 'Grocery Item #' . $detail->PID }}</td>
                                <td>
                                    <span class="badge bg-light text-secondary border">
                                        {{ $detail->product->category->name ?? 'General Grocery' }}
                                    </span>
                                </td>
                                <td class="text-center fw-black fs-6">{{ $detail->Quantity }}</td>
                                <td class="text-end">${{ number_format($detail->Price, 2) }}</td>
                                <td class="text-end pe-3 fw-black text-dark">${{ number_format($detail->Subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals & Calculations -->
            <div class="row justify-content-end pt-3 border-top border-light-subtle">
                <div class="col-md-5">
                    <div class="d-flex justify-content-between align-items-center py-1 text-secondary small">
                        <span>Items Subtotal:</span>
                        <span class="fw-bold">${{ number_format($order->TotalAmount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-1 text-secondary small">
                        <span>Supermarket Express Delivery:</span>
                        <span class="text-success fw-bold">FREE ($0.00)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-1 text-secondary small">
                        <span>Applicable Taxes & Bottle Deposits:</span>
                        <span class="fw-bold">Included</span>
                    </div>
                    <hr class="my-2 border-light-subtle">
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="fw-black text-dark fs-5">Total Paid:</span>
                        <span class="fw-black text-dark fs-4" style="color: #0f172a;">
                            ${{ number_format($order->TotalAmount, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Receipt Footer Note -->
            <div class="text-center text-muted small pt-4 mt-4 border-top border-light-subtle">
                <div>Thank you for shopping at FreshMart™ Supermarket. All grocery items are backed by our 100% Quality & Freshness Guarantee.</div>
                <div class="mt-1" style="font-size: 0.72rem;">Customer Support: support@freshmart.local &bull; Keep this receipt for return or refund requests.</div>
            </div>
        </div>

    </div>
</div>
@endsection
