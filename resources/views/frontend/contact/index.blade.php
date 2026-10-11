@extends('frontend.layout.app')
@php
$about_details = DB::table('home_page_contents')->find(1);
@endphp
@section('title', $title ?? 'Contact Us | Memory Click')
@section('content')
 <!-- breadcrump start -->
 <div class="breadcrumb_sec bg-light py-4">
    <div class="container">
        <h4>Contact Us</h4>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
            </ol>
        </nav>
    </div>
</div>
<!-- breadcrump end -->

<!-- contact Start -->
<div class="contact_sec section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 order-lg-2 mb-4 mb-lg-0">
                <div class="contact_info mb-4">
                    <div class="d-flex mb-4 align-items-center">
                        <div class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="">
                            {{$about_details->address ?? '_'}}
                        </div>
                    </div>
                    <div class="d-flex mb-4 align-items-center">
                        <div class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <div class="">
                            <a href="mailto:{{ $about_details->email ?? '#'}}">{{ $about_details->email ?? '_'}}</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-call-icon lucide-phone-call"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/><path d="M14.05 2a9 9 0 0 1 8 7.94"/><path d="M14.05 6A5 5 0 0 1 18 10"/></svg>
                        </div>
                        <div class="">
                            <a href="tel:{{ $about_details->phone }}">{{ $about_details->phone ?? '_' }}</a>
                        </div>
                    </div>
                </div>
                @if(!empty($about_details->google_map))
                    <div class="map p-0 mb-0">
                        @php
                            $contactMapSrc = $about_details->google_map;
                            if (preg_match('/src=["\']([^"\']+)["\']/', $contactMapSrc, $matches)) {
                                $contactMapSrc = $matches[1];
                            }
                        @endphp
                        @if(filter_var($contactMapSrc, FILTER_VALIDATE_URL) || \Illuminate\Support\Str::startsWith($contactMapSrc, ['http://', 'https://', '//']))
                            <iframe src="{{ $contactMapSrc }}" width="100%" height="350" class="border-0 p-0 rounded w-100" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            {!! $about_details->google_map !!}
                        @endif
                    </div>
                @endif
            </div>
            <div class="col-lg-7 order-lg-1">
                <h5 class="mb-4">If You Have Any Question? Please Contact Us</h5>
                <form method="post" action="{{route('contact.store')}}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control shadow-none" name="name" id="name" placeholder="Your Name" required>
                                <label for="name">Your Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control shadow-none" name="email" id="email" placeholder="Your Email" required>
                                <label for="email">Your Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="tel" class="form-control shadow-none"  name="subject" id="subject" placeholder="Subject" required>
                                <label for="subject">Phone</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control shadow-none" name="message" placeholder="Leave a message here" id="message" required
                                    style="height: 200px"></textarea>
                                <label for="message">Message</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary py-3 px-5" type="submit">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- contact End -->
@endsection
