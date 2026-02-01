@extends('frontend.layout.app')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css" />
@endpush
@section('title', $title ?? 'Photography | Memory Click')
@section('content')
    <!-- breadcrump start -->
    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>Photography</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Photography</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrump end -->

    <!-- Photography Start -->
    <div class="cinematography_sec section_gap">
        <div class="container">
            <div class="text-center mx-auto mb-4" style="max-width:600px;">
                <p class="text-primary text-uppercase sub_title mb-2">Photography</p>
                <h1 class="display-6 mb-4">See our all Photography</h1>
            </div>

            <div align="center" class="mb-5">
                <button class="btn btn-default shadow-none active border-0 bg-transparent filter-button"
                    data-filter="all">All</button>
                @foreach ($categories as $category)
                    <button class="btn btn-default shadow-none border-0 bg-transparent filter-button"
                        data-filter="{{ $category->slug }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <div id="lightgallery" class="gallery row gy-4">
                @foreach ($rows as $item)
                    <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter {{ $item->category?->slug }}">
                        <div class="photograpy_item text-center">

                                {{-- Fallback to single main image --}}
                                <a href="{{ asset($item->image) }}" data-lg-size="1600-1067" class="gallery-item">
                                    <img src="{{ asset($item->image) }}" class="img-fluid mb-3 rounded" alt="">
                                </a>

                            <h4><a href="{{route('photography.details',$item->slug)}}">{{ $item->title ?? 'Photography' }}</a></h4>
                            <p class="m-0">{{ $item->category?->name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
    <!-- Photography End -->
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
