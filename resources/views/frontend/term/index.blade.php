@extends('frontend.layout.app')
@section('title', $title ?? 'Terms and Condition | Memory Click')
@section('content')


<!-- breadcrump start -->
<div class="breadcrumb_sec bg-light py-4">
    <div class="container">
        <h4>{{$title}}</h4>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Terms and  Condition</li>
            </ol>
        </nav>
    </div>
</div>
<!-- breadcrump end -->

  <!-- About Start -->
  <div class="about_sec section_gap">
    <div class="container">
        {!!$page->body!!}
    </div>
</div>
<!-- About End -->





@endsection
