@extends('layouts.admin')

@section('title', 'Edit Product - FreshMart SSMS')
@section('page-title', 'Edit Product #' . str_pad($product->PID, 4, '0', STR_PAD_LEFT))
@section('page-subtitle', 'Modify pricing, stock quantities, or shelf expiry date')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Update Product Details</h5>
                <a href="{{ route('stock.products.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back to Products
                </a>
            </div>

            <form action="{{ route('stock.products.update', $product->PID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label for="PName" class="form-label fw-semibold small text-secondary">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="PName" id="PName" class="form-control" 
                               value="{{ old('PName', $product->PName) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="CatID" class="form-label fw-semibold small text-secondary">Department / Category <span class="text-danger">*</span></label>
                        <select name="CatID" id="CatID" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->CatID }}" {{ old('CatID', $product->CatID) == $category->CatID ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="Price" class="form-label fw-semibold small text-secondary">Unit Price ($) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0.01" name="Price" id="Price" class="form-control" 
                                   value="{{ old('Price', $product->Price) }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="Qty" class="form-label fw-semibold small text-secondary">Current Quantity (Qty) <span class="text-danger">*</span></label>
                        <input type="number" min="0" name="Qty" id="Qty" class="form-control" 
                               value="{{ old('Qty', $product->Qty) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="MinStock" class="form-label fw-semibold small text-secondary">Minimum Safe Stock (MinStock) <span class="text-danger">*</span></label>
                        <input type="number" min="0" name="MinStock" id="MinStock" class="form-control" 
                               value="{{ old('MinStock', $product->MinStock) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="ExpiredDate" class="form-label fw-semibold small text-secondary">Shelf Expiration Date</label>
                        <input type="date" name="ExpiredDate" id="ExpiredDate" class="form-control" 
                               value="{{ old('ExpiredDate', $product->ExpiredDate ? \Carbon\Carbon::parse($product->ExpiredDate)->format('Y-m-d') : '') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label fw-semibold small text-secondary">Replace Product Photo</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div class="form-text small">Leave empty to keep existing image.</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold small text-secondary">Product Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                    <a href="{{ route('stock.products.index') }}" class="btn btn-light rounded-pill px-3">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
