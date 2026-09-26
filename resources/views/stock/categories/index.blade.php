@extends('layouts.admin')

@section('title', 'Categories Management - FreshMart SSMS')
@section('page-title', 'Supermarket Departments & Categories')
@section('page-subtitle', 'Organize and manage grocery classifications and departments')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <!-- Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <form action="{{ route('stock.categories.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm rounded-pill ps-3" 
                   placeholder="Search department..." value="{{ request('search') }}" style="min-width: 240px;">
            <button type="submit" class="btn btn-sm btn-secondary rounded-pill px-3">Search</button>
            @if(request('search'))
                <a href="{{ route('stock.categories.index') }}" class="btn btn-sm btn-light rounded-pill px-2">Clear</a>
            @endif
        </form>

        <a href="{{ route('stock.categories.create') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold d-flex align-items-center gap-1">
            <i class="bi bi-plus-circle"></i> Add New Category
        </a>
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

                                <form action="{{ route('stock.categories.destroy', $category->CatID) }}" method="POST" onsubmit="return confirm('Delete category {{ $category->name }}?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Delete Category" {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
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
