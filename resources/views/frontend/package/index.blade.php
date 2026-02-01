@extends('frontend.layout.app')
@section('title', $title ?? 'Packages | Memory Click')
@php
    $about_details = DB::table('home_page_contents')->find(1);
@endphp
@section('content')
    <!-- breadcrump start -->
    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>{{ $title }}</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrump end -->

    <!-- contact Start -->
    <div class="section_gap">
        <div class="container">
            <!-- package start -->
            <div class="package_sec section_gap">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8">
                            <div class="row gy-4">
                                @foreach ($divisions as $division)
                                <div class="col-md-6">
                                    <div class="package_wrap h-100 text-center position-relative overflow-hidden border rounded shadow-lg">
                                        <img src="{{ asset($division->image) }}" class="img-fluid rounded-top mb-3" alt="{{ $division->name }}">
                                        <h4><a href="{{ route('division.package', $division->slug) }}" class="stretched-link text-decoration-none text-dark">{{ $division->name }} Packages</a></h4>
                                    </div>
                                </div>
                            @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- package end -->

        </div>
    </div>
    <!-- contact End -->
@endsection
