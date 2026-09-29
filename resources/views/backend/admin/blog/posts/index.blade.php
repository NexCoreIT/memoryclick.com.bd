@extends('backend.layout.app')

@push('styles')
    <style>
        .nav-pills .nav-link {
            color: #ffffff !important;
            border-radius: 6px;
            padding: 8px 16px;
        }
        .btn-primary,
        .btn-success,
        .btn-warning,
        .btn-danger,
        .btn-info,
        .btn-secondary {
            color: #ffffff !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-xl py-4">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title text-dark fw-bold mb-0">
                    {{ request('status') === 'pending' ? 'Pending Blog Posts' : 'Blog Posts' }}
                </h2>
                <div class="text-muted small mt-1">Manage and publish blog articles</div>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('blog.post.create') }}" class="btn btn-primary text-white d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Blog Post
                </a>
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
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body p-3">
                <form action="{{ route('blog.post.index') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted mb-1">Search Post</label>
                        <input type="text" name="search" class="form-control" placeholder="Search title..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted mb-1">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted mb-1">Status</label>
                        <select name="status" class="form-select">
                            <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary text-white w-100 fw-bold">Filter</button>
                        <a href="{{ route('blog.post.index') }}" class="btn btn-secondary text-white" title="Reset">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Status Filter Tabs -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item me-2">
                        <a class="nav-link {{ !request('status') || request('status') == 'all' ? 'active bg-primary' : 'bg-secondary' }} text-white fw-bold" href="{{ route('blog.post.index') }}">
                            All Posts <span class="badge {{ !request('status') || request('status') == 'all' ? 'bg-white text-primary' : 'bg-white text-dark' }} ms-1">{{ $allCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link {{ request('status') == 'pending' ? 'active bg-warning' : 'bg-secondary' }} text-white fw-bold" href="{{ route('blog.post.index', ['status' => 'pending']) }}">
                            Pending
                            @if($pendingCount > 0)
                                <span class="badge bg-danger text-white ms-1 fw-bold">{{ $pendingCount }}</span>
                            @else
                                <span class="badge bg-white text-dark ms-1">0</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'published' ? 'active bg-success' : 'bg-secondary' }} text-white fw-bold" href="{{ route('blog.post.index', ['status' => 'published']) }}">
                            Published <span class="badge {{ request('status') == 'published' ? 'bg-white text-success' : 'bg-white text-dark' }} ms-1">{{ $publishedCount }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Posts Table Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header py-3 px-3 d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0 fs-4 fw-bold">Posts Directory</h3>
                <span class="text-muted small">{{ $posts->total() }} Posts Found</span>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter table-striped card-table">
                    <thead>
                        <tr>
                            <th width="5%">SN</th>
                            <th width="8%">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th class="text-center">Featured</th>
                            <th class="text-center">Status</th>
                            <th>Created At</th>
                            <th class="text-center" width="18%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $key => $post)
                            <tr>
                                <td>{{ $posts->firstItem() + $key }}</td>
                                <td>
                                    @if($post->image)
                                        <img src="{{ asset($post->image) }}" alt="Post image" class="rounded border" style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <span class="badge bg-light text-muted p-2 rounded border">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $post->title }}</div>
                                    <div class="text-muted small">{{ Str::limit($post->short_description, 60) }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-info text-white fw-bold px-2 py-1">
                                        {{ $post->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($post->is_featured == 1)
                                        <span class="badge bg-warning text-white fw-bold px-2 py-1">Featured</span>
                                    @else
                                        <span class="badge bg-secondary text-white fw-bold px-2 py-1">Standard</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($post->status == 1)
                                        <span class="badge bg-success text-white fw-bold px-2 py-1">Published</span>
                                    @else
                                        <span class="badge bg-warning text-white fw-bold px-2 py-1">Pending</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $post->created_at ? $post->created_at->format('d M, Y') : 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @if($post->status == 0)
                                            <a href="{{ route('blog.post.toggle-status', $post->id) }}" class="btn btn-sm btn-success text-white fw-bold px-2" title="Approve & Publish">
                                                Approve
                                            </a>
                                        @else
                                            <a href="{{ route('blog.post.toggle-status', $post->id) }}" class="btn btn-sm btn-secondary text-white px-2" title="Unpublish">
                                                Unpublish
                                            </a>
                                        @endif
                                        <a href="{{ route('blog.post.edit', $post->id) }}" class="btn btn-sm btn-warning text-white fw-bold">Edit</a>
                                        <form action="{{ route('blog.post.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white fw-bold">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No blog posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($posts->hasPages())
                <div class="card-footer border-top p-3 d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
