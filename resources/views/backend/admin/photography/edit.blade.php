@extends('backend.layout.app')

@section('content')
<div class="container d-flex justify-content-center mt-4">
    <div class="card shadow-lg w-100" style="max-width: 800px;">
        <div class="card-header">
            <h3 class="card-title mb-0">Edit Photography</h3>
        </div>
        <form action="{{ route('photography.update', $photography->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="row">
                {{-- Current Thumbnail --}}
                <div class="mb-3">
                    <label class="form-label">Current Image</label><br>
                    <img src="{{ asset($photography->image) }}" width="100" class="img-thumbnail mb-2">
                </div>

                {{-- Change Thumbnail --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Change Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Additional Images</label>
                    <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" multiple>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Additional Images --}}
                @if ($photography->images && is_array(json_decode($photography->images, true)))
                <div class="mb-3">
                    <label class="form-label">Current Additional Images</label><br>
                    @foreach (json_decode($photography->images, true) as $img)
                        <img src="{{ asset($img) }}" style="width: 60px;" class="img-thumbnail me-1 mb-2">
                    @endforeach
                </div>
                @endif
            </div>
                {{-- Title & Client Name --}}
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" value="{{ old('title', $photography->title) }}"
                            class="form-control @error('title') is-invalid @enderror" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Package Name</label>
                        <input type="text" name="package_name" class="form-control @error('package_name') is-invalid @enderror"
                        value="{{ old('package_name', $photography->package_name) }}" required>
                        @error('package_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Client Name</label>
                        <input type="text" name="client_name" value="{{ old('client_name', $photography->client_name) }}"
                            class="form-control @error('client_name') is-invalid @enderror" required>
                        @error('client_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Status & Category --}}
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="1" {{ $photography->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $photography->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $photography->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('photography.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
