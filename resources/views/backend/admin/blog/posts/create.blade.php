@extends('backend.layout.app')

@push('styles')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 250px;
        }
        .ck-content .image {
            max-width: 80%;
            margin: 20px auto;
        }
    </style>
@endpush

@section('content')
    <div class="container-xl py-4">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title text-dark fw-bold mb-0">Add New Blog Post</h2>
                <div class="text-muted small mt-1">Create and publish a new blog article</div>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('blog.post.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                    Back to Posts
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('blog.post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Post Title *</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter post title" value="{{ old('title') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="3" placeholder="Brief summary of the post...">{{ old('short_description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Full Content / Description</label>
                                <textarea name="description" id="editor" class="form-control" rows="12" placeholder="Write full article content here...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-transparent border-bottom fw-bold py-3">Publish Settings</div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Category *</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Author Name</label>
                                <input type="text" name="author_name" class="form-control" placeholder="e.g. MemoryClick Studio" value="{{ old('author_name', 'MemoryClick Studio') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Featured Image <small>(Recommended size: 800 x 500 px)</small></label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <div class="form-text">JPG, PNG, WEBP (Max 2MB)</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Status *</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Draft / Pending</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ old('is_featured') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold small text-dark" for="isFeatured">Mark as Featured Post</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                Save Post
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        if (document.querySelector('#editor')) {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
@endpush
