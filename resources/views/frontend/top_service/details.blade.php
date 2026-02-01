@extends('frontend.layout.app')
@section('title', $service->title ?? 'Service Details | Memory Click')
@section('content')


 <!-- breadcrump start -->
 <div class="breadcrumb_sec bg-light py-4">
    <div class="container">
        <h4>All Services</h4>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('service.page')}}">Service</a></li>
                <li class="breadcrumb-item active">Wedding Cinematography</li>
            </ol>
        </nav>
    </div>
</div>
<!-- breadcrump end -->

<!-- service start -->
<div class="service_sec section_gap">
    <div class="container">
        <div class="text-center mx-auto" style="max-width: 800px;">
            <h1 class="display-6 mb-4">{{$service->title}}</h1>
            <img src="{{asset($service->image)}}" class="img-fluid mb-4 rounded" alt="">
            <p>
               {{$service->description}}
            </p>
        </div>

    </div>
</div>
<!-- service end -->

@endsection
