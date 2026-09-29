@extends('backend.layout.app')

@section('content')
    <div class="container-xl py-4">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title text-dark fw-bold mb-0">Blog Categories</h2>
                <div class="text-muted small mt-1">Manage blog post categories</div>
            </div>
            <div class="col-auto ms-auto">
                <button type="button" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Category
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('blog.category.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-9">
                        <input type="text" name="search" class="form-control" placeholder="Search blog category by name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Search</button>
                        <a href="{{ route('blog.category.index') }}" class="btn btn-outline-secondary" title="Reset">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Categories Table Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header py-3 px-3">
                <h3 class="card-title mb-0 fs-4 fw-bold">Category Directory</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter table-striped card-table">
                    <thead>
                        <tr>
                            <th width="5%">SN</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th class="text-center">Posts Count</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $key }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $category->name }}</span>
                                </td>
                                <td><code class="text-muted">{{ $category->slug }}</code></td>
                                <td class="text-center">
                                    <span class="badge bg-secondary-lt text-secondary fw-bold px-2 py-1">
                                        {{ $category->posts_count }} Posts
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($category->status == 1)
                                        <span class="badge bg-success text-white fw-bold px-2 py-1">Active</span>
                                    @else
                                        <span class="badge bg-danger text-white fw-bold px-2 py-1">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal{{ $category->id }}"
                                            title="Edit Category">
                                            Edit
                                        </button>
                                        <form action="{{ route('blog.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Category Modal -->
                            <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('blog.category.update', $category->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header border-bottom py-3">
                                                <h5 class="modal-title fw-bold">Edit Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 text-start">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-muted">Category Name *</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-muted">Status *</label>
                                                    <select name="status" class="form-select">
                                                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top py-3">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary fw-bold">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="card-footer border-top p-3 d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create Category Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('blog.category.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom py-3">
                        <h5 class="modal-title fw-bold">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Category Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Photography Tips, Weddings, Cinematography" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Status *</label>
                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-3">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-bold">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
