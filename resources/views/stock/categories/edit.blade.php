@extends('layouts.admin')

@section('title', 'Edit Category - FreshMart SSMS')
@section('page-title', 'Edit Category #' . $category->CatID)
@section('page-subtitle', 'Update department details and icon')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Edit Category Details</h5>
                <a href="{{ route('stock.categories.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <form action="{{ route('stock.categories.update', $category->CatID) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold small text-secondary">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label fw-semibold small text-secondary">Bootstrap Icon Class</label>
                    <input type="text" name="icon" id="icon" class="form-control" 
                           value="{{ old('icon', $category->icon) }}">
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold small text-secondary">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> Save Changes
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
