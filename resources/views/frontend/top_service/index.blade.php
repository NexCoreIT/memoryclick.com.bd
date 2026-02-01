@extends('frontend.layout.app')
@section('title', $title ?? 'All Services | Memory Click')
@section('content')


     <!-- breadcrump start -->
     <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>All Services</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Services</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrump end -->

    <!-- service start -->
    <div class="service_sec section_gap">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:600px;">
                <p class="text-primary text-uppercase sub_title mb-2">Services</p>
                <h1 class="display-6 mb-4">See our all services</h1>
            </div>
            <div class="row g-4">

                @forelse ($service as $service)
                <div class="col-sm-6 col-lg-4 col-xl-4">
                    <div class="bg-white border border-light h-100 rounded shadow-sm p-2 p-md-3 text-center">
                        <img src="{{asset($service->image)}}" class="img-fluid mb-3 rounded shadow-sm" alt="">
                        <div>
                            <h5 class="mb-3 fs-5 fw-bold"><strong>{{$service->title}}</strong></h5>
                            <p class="m-0">
                                {{Str::limit($service->description, 100) }}
                            </p>
                            <a class="d-inline-block mt-4 bg-primary py-2 px-4 text-white rounded" href="{{route('topService.details',$service->slug)}}">Read More</a>
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
    <!-- service end -->

@endsection
