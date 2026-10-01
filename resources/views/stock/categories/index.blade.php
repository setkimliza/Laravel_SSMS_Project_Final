@extends('layouts.admin')

@section('title', 'Categories Management - FreshMart SSMS')
@section('page-title', 'Supermarket Departments & Categories')
@section('page-subtitle', 'Organize and manage grocery classifications and departments')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <!-- Toolbar -->
    <div class="card bg-light border-0 rounded-4 p-3 mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <form action="{{ route('stock.categories.index') }}" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm" style="min-width: 260px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 rounded-end-pill ps-0" 
                           placeholder="Search department..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3">Search</button>
                @if(request('search'))
                    <a href="{{ route('stock.categories.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2">Clear</a>
                @endif
            </form>

            <a href="{{ route('stock.categories.create') }}" class="btn btn-sm btn-success rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 text-nowrap">
                <i class="bi bi-plus-lg"></i> Add New Category
            </a>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">CatID</th>
                    <th>Icon</th>
                    <th>Category / Department Name</th>
                    <th>Description</th>
                    <th class="text-center">Products Count</th>
                    <th class="pe-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="ps-3 fw-bold text-muted">#{{ str_pad($category->CatID, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="rounded-circle bg-light border text-success d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 1.2rem;">
                                <i class="bi {{ $category->icon ?: 'bi-basket2' }}"></i>
                            </div>
                        </td>
                        <td class="fw-bold text-dark">{{ $category->name }}</td>
                        <td class="text-muted small" style="max-width: 320px;">
                            {{ $category->description ?: 'No description entered.' }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('stock.products.index', ['category' => $category->CatID]) }}" class="badge bg-light text-dark border rounded-pill px-3 py-1 text-decoration-none">
                                {{ $category->products_count }} Products &rarr;
                            </a>
                        </td>
                        <td class="pe-3 text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('stock.categories.edit', $category->CatID) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="Edit Category">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2" 
                                        data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                                        data-action="{{ route('stock.categories.destroy', $category->CatID) }}"
                                        data-name="{{ $category->name }}"
                                        data-id="#{{ str_pad($category->CatID, 3, '0', STR_PAD_LEFT) }}"
                                        data-type="Category"
                                        title="{{ $category->products_count > 0 ? 'Cannot delete: category has ' . $category->products_count . ' active product(s)' : 'Delete Category' }}" 
                                        {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No supermarket categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
