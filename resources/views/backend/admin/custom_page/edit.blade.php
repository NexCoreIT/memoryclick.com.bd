@extends('backend.layout.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom fw-bold py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0 fw-bold">Edit Custom Page</h3>
                    <a href="{{ route('custom.page.index') }}" class="btn btn-secondary text-white btn-sm fw-bold">Back</a>
                </div>
                <form action="{{ route('custom.page.update',$item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Title & Meta Title Side by Side -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Title"
                                           value="{{ old('title', $item->title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Meta Title <span class="text-danger">*</span></label>
                                    <input type="text" name="meta_title" class="form-control" placeholder="Meta Title"
                                           value="{{ old('meta_title', $item->meta_title) }}" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Meta Description <span class="text-danger">*</span></label>
                                    <textarea name="meta_description" class="form-control" placeholder="Meta Description"
                                              rows="3" required>{{ old('meta_description', $item->meta_description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Meta Keywords <span class="text-danger">*</span></label>
                                    <input type="text" name="meta_keywords" class="form-control" placeholder="Meta Keywords"
                                           value="{{ old('meta_keywords', $item->meta_keywords) }}" required>
                                </div>
                            </div>

                            @if($item->id !== 1)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Body <span class="text-danger">*</span></label>
                                    <textarea name="body" id="summernote" class="form-control" rows="5"
                                              placeholder="Body" required>{{ old('body', $item->body) }}</textarea>
                                </div>
                            </div>
                            @endif

                            {{-- ✅ Extra Fields show only if id == 1 --}}
                            @if($item->id == 1)
                            <hr class="my-4">
                            <h4 class="mt-2 mb-3 fw-bold text-primary">Extra About Section</h4>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-bold">Title</label>
                                            <input type="text" name="title_1" class="form-control" placeholder="About Our CEO"
                                                value="{{ old('title_1', $item->title_1) }}">
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-bold">Name</label>
                                            <input type="text" name="ceo_name" class="form-control" placeholder="CEO Name"
                                                value="{{ old('ceo_name', $item->ceo_name) }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-bold">Designation</label>
                                            <input type="text" name="ceo_designation" class="form-control" placeholder="CEO Designation"
                                                value="{{ old('ceo_designation', $item->ceo_designation) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- About CEO -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">About CEO</label>
                                    <textarea name="body" class="form-control" rows="4"
                                              placeholder="Write about CEO">{{ old('body', $item->body ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- CEO Image -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">CEO Image</label>
                                    <input type="file" name="ceo_image" class="form-control">
                                    @if(!empty($item->ceo_image))
                                        <img src="{{ asset($item->ceo_image) }}" alt="CEO Image" class="img-thumbnail mt-2" width="150">
                                    @endif
                                </div>
                            </div>

                            <h4 class="mt-4 mb-3 fw-bold text-primary">MemoryClick About Section</h4>

                            <!-- Memoryclick Section -->
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" name="title_2" class="form-control" placeholder="Memoryclick Title"
                                        value="{{ old('title_2', $item->title_2) }}">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-bold">Memoryclick Image</label>
                                    <input type="file" name="memoryclick_image" class="form-control">
                                    @if(!empty($item->memoryclick_image))
                                        <img src="{{ asset($item->memoryclick_image) }}" alt="Memoryclick Image" class="img-thumbnail mt-2" width="150">
                                    @endif
                                </div>
                            </div>

                            <!-- About Memoryclick -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">About Memoryclick</label>
                                    <textarea name="about_memoryclick" class="form-control" rows="4"
                                              placeholder="Write about Memoryclick">{{ old('about_memoryclick', $item->about_memoryclick ?? '') }}</textarea>
                                </div>
                            </div>
                            @endif
                            {{-- ✅ End Extra Fields --}}

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status', $item->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $item->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top text-end p-3">
                        <button type="submit" class="btn btn-primary text-white fw-bold">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script>
    $('#summernote').summernote({
      placeholder: 'Hello Bootstrap 4',
      tabsize: 4,
      height: 100
    });
</script>
@endpush
