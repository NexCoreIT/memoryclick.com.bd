@extends('frontend.layout.app')
@section('title', $page->meta_title ?? $title ?? 'About Us | Memory Click')
@php
    $home_page_content = DB::table('home_page_contents')->first();
@endphp
@section('seo')
    <meta name="description" content="{{ $page->meta_description ?? 'Learn more about Memory Click - your trusted wedding photography partner in Bangladesh.' }}">
    <meta name="keywords" content="{{ $page->meta_keywords ?? 'memory click, about us, wedding photography' }}">
    <meta property="og:title" content="{{ $page->meta_title ?? $title ?? 'About Us | Memory Click' }}">
    <meta property="og:description" content="{{ $page->meta_description ?? '' }}">
    <meta property="og:image" content="{{ asset($home_page_content->image ?? 'fav.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="robots" content="index, follow">
@endsection
@section('content')
    <style>
        .mt-5 {
            margin-top: 3rem !important;
            /* 48px */
        }

        .mb-5 {
            margin-bottom: 3rem !important;
            /* 48px */
        }
    </style>
    <!-- breadcrump start -->
    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>About Us</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrump end -->



    <!-- Founder Start -->
    <div class="founder_sec bg-white section_gap py-5">
        <div class="container py-lg-4">
            <div class="row d-flex align-items-center">
                <!-- Image Right -->
                <div class="col-lg-6 mb-4 mb-lg-0 order-lg-2">
                    <div class="about_bx text-center text-lg-end position-relative">
                        <img src="{{ $page && $page->ceo_image ? asset($page->ceo_image) : asset('default.jpg') }}" class="img-fluid rounded shadow"
                            alt="CEO" style="width: 100%; max-height: 550px; object-fit: cover; object-position: top;">
                    </div>
                </div>
                <!-- Content Left -->
                <div class="col-lg-6 order-lg-1">
                    <div class="pe-lg-5">
                        <p class="text-primary text-uppercase sub_title mb-2 fw-bold" style="letter-spacing: 1px;">{{ optional($page)->ceo_designation ?? 'CEO' }}</p>
                        <h2 class="display-6 mb-4 fw-bold text-dark">{{ optional($page)->ceo_name ?? 'Founder & CEO' }}</h2>
                        <div class="mb-4 text-muted" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! nl2br(e(optional($page)->body ?? 'Memory Click started with a vision to capture life\'s most beautiful moments. We have grown into a trusted name in wedding photography and cinematography across Bangladesh.')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Founder End -->

    <!-- About Memoryclick Start -->
    <div class="about_memoryclick section_gap bg-light py-5">
        <div class="container py-lg-4">
            <!-- Title Header -->
            <div class="text-center mx-auto mb-5 pb-3" style="max-width: 600px;">
                <h2 class="display-6 fw-bold text-dark mb-3">{{ optional($page)->title_2 ?? 'About MemoryClick' }}</h2>
                <div class="mx-auto bg-primary rounded" style="height: 3px; width: 60px;"></div>
            </div>

            <div class="row d-flex align-items-center">
                <!-- Image Left -->
                <div class="col-lg-6 mb-4 mb-lg-0 order-lg-1">
                    <div class="about_bx text-center text-lg-start position-relative">
                        <img src="{{ $page && $page->memoryclick_image ? asset($page->memoryclick_image) : asset('default.jpg') }}" class="img-fluid rounded shadow"
                            alt="Memoryclick Story" style="width: 100%; max-height: 550px; object-fit: cover;">
                    </div>
                </div>
                <!-- Content Right -->
                <div class="col-lg-6 order-lg-2">
                    <div class="ps-lg-5">
                        <p class="text-primary text-uppercase sub_title mb-2 fw-bold" style="letter-spacing: 1px;">Our Journey</p>
                        <h2 class="mb-4 fw-bold text-dark">Memoryclick Story</h2>
                        <div class="mb-4 text-muted" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! nl2br(e(optional($page)->about_memoryclick ?? 'Memory Click started with a vision to capture life\'s most beautiful moments. We have grown into a trusted name in wedding photography and cinematography across Bangladesh.')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Memoryclick End -->

    <!-- Team Start -->
    <div class="team_sec section_gap bg-white">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:600px;">
                <p class="text-primary text-uppercase sub_title mb-2">Team Member</p>
                <h1 class="display-6 mb-4">Meet with our Team Member</h1>
            </div>
            <div class="row">
                @forelse ($teams as $team)
                    <div class="col-sm-6 col-xl-3 my-3">
                        <div class="team-membem shadow-sm bg-light p-3 p-lg-4 rounded text-center h-100">
                            <img src="{{ asset($team->image) }}" class="img-fluid rounded mb-3" alt="Photographer" style="width: 100%; height: 280px; object-fit: cover; object-position: top;">
                            <h4>{{ $team->name }}</h4>
                            <p class="m-0 small">{{ $team->designation }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <strong class="text-danger">NO DATA FOUND</strong>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Team End -->

@endsection
