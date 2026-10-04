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
                <h2 class="page-title text-dark fw-bold mb-0">Edit Blog Post</h2>
                <div class="text-muted small mt-1">Update blog post details</div>
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

        <form action="{{ route('blog.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Post Title *</label>
                                <input type="text" name="title" id="titleInput" class="form-control" placeholder="Enter post title" value="{{ old('title', $post->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">URL Slug *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted small">{{ url('/blog') }}/</span>
                                    <input type="text" name="slug" id="slugInput" class="form-control @error('slug') is-invalid @enderror" placeholder="custom-post-url-slug" value="{{ old('slug', $post->slug) }}" required>
                                </div>
                                @error('slug')
                                    <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                                @enderror
                                <div class="form-text small text-muted">Must be unique. Automatically converts spaces to hyphens and strips special characters.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="3" placeholder="Brief summary of the post...">{{ old('short_description', $post->short_description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Full Content / Description</label>
                                <textarea name="description" id="editor" class="form-control" rows="12" placeholder="Write full article content here...">{{ old('description', $post->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings Card -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-transparent border-bottom fw-bold py-3 text-primary d-flex align-items-center justify-content-between">
                            <span class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                SEO Settings
                            </span>
                            <span class="badge bg-success text-white">Google Rank Ready</span>
                        </div>
                        <div class="card-body p-4">
                            <!-- Live Google Search Preview Box -->
                            <div class="p-3 mb-4 rounded border bg-light">
                                <div class="small text-muted fw-bold mb-2 text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">Google Search Result Preview</div>
                                <div class="bg-white p-3 rounded border">
                                    <div class="text-truncate text-primary fw-semibold fs-5 mb-1" id="seoPreviewTitle">
                                        {{ $post->meta_title ?: $post->title }}
                                    </div>
                                    <div class="text-success small text-truncate mb-1" id="seoPreviewUrl">
                                        {{ url('/blog/' . $post->slug) }}
                                    </div>
                                    <div class="text-muted small" id="seoPreviewDesc" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $post->meta_description ?: Str::limit(strip_tags($post->short_description ?? $post->description), 160) }}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Meta Title</label>
                                <input type="text" name="meta_title" id="metaTitleInput" class="form-control" placeholder="Meta title for Google" value="{{ old('meta_title', $post->meta_title) }}">
                                <div class="form-text small text-muted">Leave empty to default to Post Title.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Meta Description</label>
                                <textarea name="meta_description" id="metaDescInput" class="form-control" rows="3" placeholder="Meta description for search engines...">{{ old('meta_description', $post->meta_description) }}</textarea>
                                <div class="form-text small text-muted">Leave empty to default to post short description.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" placeholder="e.g. photography, wedding, event, memory click" value="{{ old('meta_keywords', $post->meta_keywords) }}">
                                <div class="form-text small text-muted">Comma-separated target keywords.</div>
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
                                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Author Name</label>
                                <input type="text" name="author_name" class="form-control" placeholder="e.g. MemoryClick Studio" value="{{ old('author_name', $post->author_name) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Featured Image</label>
                                @if($post->image)
                                    <div class="mb-2">
                                        <img src="{{ asset($post->image) }}" alt="Current Image" class="img-thumbnail rounded" style="max-height: 120px;">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <div class="form-text">Upload new image to replace current one (Max 2MB)</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Views Count</label>
                                <input type="number" name="views" class="form-control" value="{{ old('views', $post->views) }}" min="0">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Status *</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ old('status', $post->status) == 1 ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ old('status', $post->status) == 0 ? 'selected' : '' }}>Draft / Pending</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ old('is_featured', $post->is_featured) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold small text-dark" for="isFeatured">Mark as Featured Post</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                Update Post
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
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        const data = new FormData();
                        data.append('upload', file);
                        data.append('_token', '{{ csrf_token() }}');

                        fetch('{{ route("blog.post.upload-image") }}', {
                            method: 'POST',
                            body: data
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.url) {
                                resolve({ default: result.url });
                            } else if (result.uploaded && result.url) {
                                resolve({ default: result.url });
                            } else {
                                reject(result.error ? result.error.message : 'Image upload failed.');
                            }
                        })
                        .catch(error => {
                            reject('Image upload failed: ' + error);
                        });
                    }));
            }

            abort() {
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        if (document.querySelector('#editor')) {
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    removePlugins: ['MediaEmbed', 'Table', 'TableToolbar'],
                    ckfinder: {
                        uploadUrl: '{{ route("blog.post.upload-image") }}?_token={{ csrf_token() }}'
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }

        const titleInput = document.querySelector('input[name="title"]');
        const slugInput = document.getElementById('slugInput');
        const seoPreviewUrl = document.getElementById('seoPreviewUrl');
        const metaTitleInput = document.getElementById('metaTitleInput');
        const seoPreviewTitle = document.getElementById('seoPreviewTitle');

        const shortDescInput = document.querySelector('textarea[name="short_description"]');
        const metaDescInput = document.getElementById('metaDescInput');
        const seoPreviewDesc = document.getElementById('seoPreviewDesc');

        const baseUrl = '{{ url("/blog") }}/';

        if (slugInput && seoPreviewUrl) {
            slugInput.addEventListener('input', function() {
                const cleanedSlug = this.value.toLowerCase().trim().replace(/[\s\W-]+/g, '-').replace(/^-+|-+$/g, '');
                seoPreviewUrl.textContent = baseUrl + (cleanedSlug || 'post-slug');
            });
        }

        if (metaTitleInput && seoPreviewTitle) {
            metaTitleInput.addEventListener('input', function() {
                seoPreviewTitle.textContent = this.value.trim() || titleInput.value.trim() || 'Post Title';
            });
            if (titleInput) {
                titleInput.addEventListener('input', function() {
                    if (!metaTitleInput.value.trim()) {
                        seoPreviewTitle.textContent = this.value.trim() || 'Post Title';
                    }
                });
            }
        }

        if (metaDescInput && seoPreviewDesc) {
            metaDescInput.addEventListener('input', function() {
                seoPreviewDesc.textContent = this.value.trim() || shortDescInput.value.trim() || 'Post short summary description...';
            });
            if (shortDescInput) {
                shortDescInput.addEventListener('input', function() {
                    if (!metaDescInput.value.trim()) {
                        seoPreviewDesc.textContent = this.value.trim() || 'Post short summary description...';
                    }
                });
            }
        }
    </script>
@endpush
