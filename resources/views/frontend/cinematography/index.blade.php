@extends('frontend.layout.app')

@section('title', $title ?? 'Cinematography | Memory Click')
@section('content')

  <!-- breadcrump start -->
  <div class="breadcrumb_sec bg-light py-4">
    <div class="container">
        <h4>Cinematography</h4>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cinematography</li>
            </ol>
        </nav>
    </div>
</div>
<!-- breadcrump end -->

<!-- Cinematography Start -->
<div class="cinematography_sec section_gap">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width:600px;">
            <p class="text-primary text-uppercase sub_title mb-2">Cinematography</p>
            <h1 class="display-6 mb-4">See our all Cinematography</h1>
        </div>
        <div class="row gy-4">
            @forelse ($cinematography as $video)
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="testimonial-item shadow-sm p-3 rounded bg-white text-center">
                    <div class="ratio ratio-16x9  mb-4">
                        <iframe width="100%" height="auto"
                                src="https://www.facebook.com/plugins/video.php?href={{ urlencode($video->youtube_url) }}&show_text=false&width=560"
                                title="Facebook video player" frameborder="0"
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                    </div>
                    <div>
                        <h5 class="mb-3 fs-5 fw-bold">
                            <strong>{{$video->title}}</strong>
                        </h5>
                        <p class="m-0">
                            Film Credits: {{$video->credit}}
                        </p>
                    </div>
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
<!-- Cinematography End -->

@endsection
