@extends('layouts.admin')

@section('title', 'Add Category - FreshMart SSMS')
@section('page-title', 'Create Supermarket Category')
@section('page-subtitle', 'Add a new product category or department')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Category Information</h5>
                <a href="{{ route('stock.categories.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <form action="{{ route('stock.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold small text-secondary">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" 
                           placeholder="e.g. Organic Produce, Delicatessen" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label fw-semibold small text-secondary">Bootstrap Icon Class (Optional)</label>
                    <input type="text" name="icon" id="icon" class="form-control" 
                           placeholder="e.g. bi-basket, bi-egg-fried, bi-cup-straw" value="{{ old('icon', 'bi-basket2') }}">
                    <div class="form-text small">Any valid Bootstrap Icon class (e.g. <code>bi-cookie</code>, <code>bi-cart4</code>).</div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold small text-secondary">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control" 
                              placeholder="Brief summary of items in this department...">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-check2-circle me-1"></i> Save Category
                    </button>
                    <a href="{{ route('stock.categories.index') }}" class="btn btn-light rounded-pill px-3">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
