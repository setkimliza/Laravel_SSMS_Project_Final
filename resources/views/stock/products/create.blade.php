@extends('layouts.admin')

@section('title', 'Add Product - FreshMart SSMS')
@section('page-title', 'Create Supermarket Product')
@section('page-subtitle', 'Register a new grocery item into the supermarket inventory')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">New Product Specifications</h5>
                <a href="{{ route('stock.products.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back to Products
                </a>
            </div>

            <form action="{{ route('stock.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label for="PName" class="form-label fw-semibold small text-secondary">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="PName" id="PName" class="form-control" 
                               placeholder="e.g. Organic Almond Milk 1L" value="{{ old('PName') }}" required autofocus>
                    </div>

                    <div class="col-md-4">
                        <label for="CatID" class="form-label fw-semibold small text-secondary">Department / Category <span class="text-danger">*</span></label>
                        <select name="CatID" id="CatID" class="form-select" required>
                            <option value="">Select Department</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->CatID }}" {{ old('CatID') == $category->CatID ? 'selected' : '' }}>
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
                                   placeholder="0.00" value="{{ old('Price') }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="Qty" class="form-label fw-semibold small text-secondary">Current Quantity (Qty) <span class="text-danger">*</span></label>
                        <input type="number" min="0" name="Qty" id="Qty" class="form-control" 
                               placeholder="Initial shelf count" value="{{ old('Qty', 20) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="MinStock" class="form-label fw-semibold small text-secondary">Minimum Safe Stock (MinStock) <span class="text-danger">*</span></label>
                        <input type="number" min="0" name="MinStock" id="MinStock" class="form-control" 
                               placeholder="Threshold for alerts" value="{{ old('MinStock', 10) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="ExpiredDate" class="form-label fw-semibold small text-secondary">Shelf Expiration Date</label>
                        <input type="date" name="ExpiredDate" id="ExpiredDate" class="form-control" 
                               value="{{ old('ExpiredDate') }}">
                        <div class="form-text small">Used for automatic shelf freshness tracking and warnings.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label fw-semibold small text-secondary">Product Photo (Optional)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div class="form-text small">JPG, PNG, or WebP up to 2MB. Default image provided if omitted.</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold small text-secondary">Product Description / Nutritional Notes</label>
                    <textarea name="description" id="description" rows="3" class="form-control" 
                              placeholder="Ingredients, brand info, pack size, storage temperature...">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                        <i class="bi bi-check2-circle me-1"></i> Register Product
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
