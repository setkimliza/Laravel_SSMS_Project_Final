@extends('layouts.admin')

@section('title', 'Order Invoice #' . $order->OrderID . ' - FreshMart SSMS')
@section('page-title', 'Order #' . str_pad($order->OrderID, 5, '0', STR_PAD_LEFT))
@section('page-subtitle', 'Supermarket customer transaction details and printable invoice')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Status Bar -->
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="badge {{ $order->status_badge }} rounded-pill px-3 py-2 fs-6">
                        {{ $order->Status }}
                    </span>
                    <span class="text-muted small">
                        Recorded on {{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, Y - h:i A') }}
                    </span>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    <!-- Update Status Form -->
                    <form action="{{ route('admin.orders.status', $order->OrderID) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <select name="status" class="form-select form-select-sm rounded-pill" style="min-width: 140px;">
                            <option value="Completed" {{ $order->Status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Processing" {{ $order->Status == 'Processing' ? 'selected' : '' }}>Processing</option>
                            <option value="Pending" {{ $order->Status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Cancelled" {{ $order->Status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill text-nowrap">Update Status</button>
                    </form>

                    <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3" onclick="window.print();">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Printable Invoice -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-4" id="printableArea">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
                <div>
                    <h3 class="fw-extrabold text-success mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-basket2-fill"></i> FreshMart Supermarket
                    </h3>
                    <div class="text-muted small">Store Management & Point of Sale System</div>
                    <div class="text-muted small">100 Sunrise Blvd, Metro City &bull; Phone: (555) 019-2834</div>
                </div>
                <div class="text-end">
                    <h4 class="fw-bold mb-0">TAX INVOICE</h4>
                    <div class="text-dark fw-bold">#{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-muted small">{{ \Carbon\Carbon::parse($order->OrderDate)->format('M d, Y - h:i A') }}</div>
                </div>
            </div>

            <div class="row g-3 mb-4 bg-light p-3 rounded-4">
                <div class="col-sm-6">
                    <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Customer Details:</span>
                    <div class="fw-bold text-dark fs-6 mt-1">{{ $order->user->name ?? 'Shopper' }}</div>
                    <div class="text-secondary small">{{ $order->user->email ?? 'No email' }}</div>
                    <div class="text-secondary small">Phone: {{ $order->user->phone ?? 'N/A' }}</div>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Delivery & Payment:</span>
                    <div class="fw-semibold text-dark mt-1">Payment Method: {{ $order->payment_method }}</div>
                    <div class="text-secondary small mt-1">Address: {{ $order->shipping_address ?? 'In-store pickup' }}</div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive mb-4">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">PID</th>
                            <th>Item Description</th>
                            <th>Department</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end pe-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $detail)
                            <tr>
                                <td class="ps-3 text-muted">#{{ $detail->PID }}</td>
                                <td class="fw-bold text-dark">{{ $detail->product->PName ?? 'SKU #' . $detail->PID }}</td>
                                <td>{{ $detail->product->category->name ?? 'General' }}</td>
                                <td class="text-center fw-bold">{{ $detail->Quantity }}</td>
                                <td class="text-end">${{ number_format($detail->Price, 2) }}</td>
                                <td class="text-end pe-3 fw-bold">${{ number_format($detail->Subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="5" class="text-end fw-bold">Total Invoice Amount:</td>
                            <td class="text-end pe-3 fw-extrabold text-success fs-5">
                                ${{ number_format($order->TotalAmount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->customer_notes)
                <div class="p-3 bg-light rounded-3 text-muted small">
                    <strong>Customer Order Note:</strong> {{ $order->customer_notes }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
