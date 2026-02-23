@extends('frontend.layout.app')
@section('title', $row->title )
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css" />
@endpush
@section('content')

<!-- Hero Section Start -->
<div class="hero-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <img src="{{ asset($row->image) }}" class="img-fluid rounded mb-4" alt="Main Image">
                <h1 class="display-5 my-5">{{ $row->title }}</h1>
                <p class="text-primary fw-bold mb-1">{{ $row->client_name ?? 'Photography' }}</p>
                <p class="mb-0">{{ $row->category?->name }}</p>
                <p class="mb-0 mt-1">Package: {{ $row->package_name }}</p>
            </div>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Gallery Section Start -->
<div class="cinematography_sec section_gap">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width:600px;">
            <h2 class="text-primary text-uppercase sub_title mb-2">Gallery</h2>
            <h3 class="display-6">View More Photos</h3>
        </div>

        <div id="lightgallery" class="row gy-4">
            @if(!empty($row->images))
                @foreach (json_decode($row->images) as $img)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <a href="{{ asset($img) }}" data-lg-size="1600-1067" class="gallery-item d-block mb-4">
                            <img src="{{ asset($img) }}" class="img-fluid rounded" alt="Gallery Image">
                        </a>
                    </div>
                @endforeach
            @else
                <div class="text-center">
                    <p class="text-danger fw-bold">No Gallery Images Found</p>
                </div>
            @endif
        </div>

    </div>
</div>
<!-- Gallery Section End -->

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.min.js"></script>
    <script>
        lightGallery(document.getElementById('lightgallery'), {
            selector: '.gallery-item',
            thumbnail: true,
            download: false
        });
    </script>

@endpush
