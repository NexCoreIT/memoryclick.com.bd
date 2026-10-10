@extends('frontend.layout.app')
@php
    $seo_data = DB::table('custom_pages')->first();
    $home_page_content = DB::table('home_page_contents')->first();
@endphp

@section('title', $home_page_content->meta_title ?? $title ?? 'Home')


@section('content')
@include('frontend.components.fixed.hero')
<!-- About Start -->
<div class="about_sec pt-4 mt-4 pt-lg-5 mt-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="count_items bg-light p-2 p-lg-5 rounded text-center">
                            <h5 class="text-dark fs-6">Since</h5>
                            <h2 class="fs-1 fw-bold" data-toggle="counter-up">{{ $home_page_content->since_year ?? '2014' }}</h2>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="count_items bg-light p-2 p-lg-5 rounded text-center">
                            <h5 class="text-dark fs-6">Events</h5>
                            <h2 class="fs-1 fw-bold">
                                <span data-toggle="counter-up">{{ $home_page_content->events_count ?? '3000' }}</span> +
                            </h2>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="count_items bg-light p-2 p-lg-5 rounded text-center">
                            <h5 class="text-dark fs-6">Photos</h5>
                            <h2 class="fs-1 fw-bold">
                                <span data-toggle="counter-up">{{ $home_page_content->photos_count ?? '1000' }}</span> k+
                            </h2>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="count_items bg-light p-2 p-lg-5 rounded text-center">
                            <h5 class="text-dark fs-6">Clients</h5>
                            <h2 class="fs-1 fw-bold">
                                <span data-toggle="counter-up">{{ $home_page_content->clients_count ?? '999' }}</span> k+
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="h-100">
                    <p class="text-primary text-uppercase sub_title mb-2">About Us</p>
                    <h1 class="title mb-4">{{ $home_page_content->about_title ?? 'No Data Found' }}</h1>
                    <p class="mb-4">
                        {{ $home_page_content->about_content ?? 'No Data Found' }}
                    </p>

                    <a class="btn btn-primary py-2 px-4" href="{{ route('about.page') }}">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Services Start -->
<div class="service_sec pt-4 mt-4 pt-lg-4 mt-lg-4">
    <div class="container">
        <div class="text-center mx-auto mb-3">
            <p class="text-primary text-uppercase sub_title mb-2">{{ $home_page_content->service_subtitle ?? 'Our Services' }}</p>
            <h1 class="display-6 mb-5">{{ $home_page_content->service_title ?? 'Our Top Services' }}</h1>
        </div>

        <div class="owl-carousel service-carousel">
            @forelse ($service as $service)
                <div class="testimonial-item bg-white border border-light rounded shadow-sm p-2 p-md-3 text-center">
                    <img src="{{ asset($service->image) }}" class="img-fluid mb-3 rounded shadow-sm" alt="">
                    <div>
                        <h5 class="mb-3 fs-5 fw-bold"><strong>{{ $service->title }}</strong></h5>
                        <p class="m-0">
                            {{ Str::limit($service->description, 100) }}
                        </p>
                    </div>
                </div>
            @empty
                <strong class="text-danger">NO SERVICE FOUND</strong>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a class="btn btn-primary py-2 px-4" href="{{ route('topService.page') }}">View All Services</a>
        </div>

    </div>
</div>
<!-- Services End -->

<!-- Packages Start -->
<div class="package_sec py-5 mt-4 mt-lg-5 bg-white">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <p class="text-primary text-uppercase sub_title mb-2">Our Packages</p>
            <h1 class="display-6 mb-0">Explore Our Latest Packages</h1>
        </div>
        <div class="row gy-4 justify-content-center">
            @forelse ($latest_packages as $package)
                <div class="col-md-6 col-lg-4">
                    <div class="package_list text-center h-100 border p-2 rounded shape-sm">
                        <img src="{{ asset($package->image) }}" class="img-fluid mb-2 d-block rounded"
                            alt="">
                        <h4>{{ $package->package_name }}</h4>
                        <p class="m-0">
                            @php
                                $people = array_filter([
                                    $package->chief,
                                    $package->photographer,
                                    $package->cinematographer,
                                ]);
                            @endphp
                            {{ implode(' + ', $people) }}
                        </p>
                        <div class="d-flex mt-4 align-items-center justify-content-between">
                            <div><strong>TK. {{ $package->price }}</strong></div>
                            <div>
                                <button class="btn btn-primary p-2 px-3 btn-sm viewPackageDetails"
                                    data-id="{{ $package->id }}" data-bs-toggle="modal"
                                    data-bs-target="#packageDetails">
                                    Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <strong class="text-muted">NO PACKAGES FOUND</strong>
                </div>
            @endforelse
        </div>
        
        @if($latest_packages->count() > 0)
            <div class="text-center mt-5">
                <a class="btn btn-primary py-2 px-4" href="{{ route('package') }}">View All Packages</a>
            </div>
        @endif
    </div>
</div>
<!-- Packages End -->


    <!-- reviews Start -->
    <div class="bg-light reviews py-5  mt-4 mt-lg-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:600px;">
                <p class="text-primary text-uppercase sub_title mb-2">Client Reviews</p>
                <h1 class="display-6 mb-4">{{ $home_page_content->homepage_title ?? 'No Data Found' }}</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                @forelse ($testimonials as $testimonial)
                    <div class="testimonial-item bg-white p-3 p-lg-4 rounded shadow-sm border h-100 d-flex flex-column">
                        <div class="d-flex align-items-center mb-4">
                            <img class="flex-shrink-0 rounded-circle border p-1" width="100" height="100"
                                src="{{ asset($testimonial->image) }}" alt="" style="object-fit: cover;">
                            <div class="ms-2 ms-lg-4">
                                <h5 class="mb-1 fw-bold text-dark">{{ $testimonial->name }}</h5>
                                <span class="text-muted">{{ $testimonial->designation }}</span>
                            </div>
                        </div>
                        <div class="start mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $testimonial->rating)
                                    <i class="fa fa-star text-primary small"></i>
                                @else
                                    <i class="fa fa-star text-light small"></i>
                                @endif
                            @endfor
                        </div>
                        @php
                            $isLong = strlen($testimonial->description) > 150;
                            $shortDesc = Str::limit($testimonial->description, 150, '...');
                        @endphp
                        <div class="testimonial-text-wrapper flex-grow-1">
                            <p class="mb-0 text-muted text-justify" id="review-short-{{$testimonial->id}}" style="line-height: 1.6;">
                                {{ $shortDesc }}
                                @if($isLong)
                                    <a href="javascript:void(0)" onclick="toggleReview({{$testimonial->id}})" class="text-primary fw-bold text-decoration-none ms-1">Learn more</a>
                                @endif
                            </p>
                            @if($isLong)
                                <p class="mb-0 text-muted text-justify d-none" id="review-full-{{$testimonial->id}}" style="line-height: 1.6;">
                                    {{ $testimonial->description }}
                                    <a href="javascript:void(0)" onclick="toggleReview({{$testimonial->id}})" class="text-primary fw-bold text-decoration-none ms-1">Show less</a>
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <strong class="text-danger">NO DATA FOUND</strong>
                @endforelse

            </div>

        </div>
    </div>
    <!-- reviews End -->


    <!-- Recent Work Start -->
    <div class="recent_work_sec pb-5 pt-4 mt-4 pt-lg-4 mt-lg-4">
        <div class="container">
            <div class="text-center mx-auto mb-5 pb-4" style="max-width:600px;">
                <p class="text-primary text-uppercase sub_title mb-2">{{ $home_page_content->recent_work_subtitle ?? 'Recent Work' }}</p>
                <h1 class="display-6 mb-0">{{ $home_page_content->recent_work_title ?? 'Our recent stunning wedding photography' }}</h1>
            </div>
            <div class="row gy-2 gy-xl-5">
                @forelse ($recent_work as $work)
                    <div class="col-lg-6">
                        <div class="row g-0 flex-sm-row">
                            <div class="col-sm-6">
                                <div class="team-img position-relative">
                                    <a href="{{ route('photography.details', $work->slug) }}">
                                        <img class="img-fluid rounded mb-3 mb-sm-0" src="{{ asset($work->image) }}"
                                            alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div
                                    class="recent_work_item h-100 p-2 p-md-3 p-xl-5 d-flex flex-column justify-content-between">
                                    <div class="mb-3">
                                        <h6><a
                                                href="{{ route('photography.details', $work->slug) }}">{{ $work->title }}</a>
                                        </h6>
                                        <span>Package : <small>{{ $work->package_name }}</small></span>
                                    </div>
                                    <p>
                                        {{ $work->client_name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <strong class="text-danger">NO DATA FOUND</strong>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Recent Work End -->


    <!-- Cinematography Start -->
    <div class="cinematography_sec pb-5 mb-4 pt-0 mt-0 pt-lg-4 mt-lg-4">
        <div class="container">
            <div class="text-center mx-auto mb-3" style="max-width: 600px;">
                <p class="text-primary text-uppercase sub_title mb-2">{{ $home_page_content->cinematography_subtitle ?? 'Cinematography' }}</p>
                <h1 class="display-6 mb-5">{{ $home_page_content->cinematography_title ?? 'Take a peek at our recent stunning wedding photography' }}</h1>
            </div>
            <div class="owl-carousel cinematography-carousel">

                @forelse ($cinematography as $video)
                    <div class="testimonial-item bg-white text-center">
                        <div class="ratio ratio-16x9 mb-4">
                            <iframe width="100%" height="auto"
                                src="https://www.facebook.com/plugins/video.php?href={{ urlencode($video->youtube_url) }}&show_text=false&width=560"
                                title="Facebook video player" frameborder="0"
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                        <div>
                            <h5 class="mb-3 fs-5 fw-bold">
                                <strong>{{ $video->title }}</strong>
                            </h5>
                            <p class="m-0">
                                Film Credits: {{ $video->credit }}
                            </p>
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
    <!-- Cinematography  End -->

    <!-- Blog Section Start -->
    <div class="blog_sec py-5 mt-4 mt-lg-5 bg-light">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <p class="text-primary text-uppercase sub_title mb-2">Blog & Insights</p>
                <h1 class="display-6 mb-3 fw-bold text-dark">Wedding & Photography Insights</h1>
                <p class="text-muted small">Advice and guides to help you capture every precious moment timelessly.</p>
            </div>

            <div class="row g-4">
                @forelse ($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border rounded-3 shadow-sm bg-white blog-card-item">
                            @if(!empty($blog->image) && file_exists(public_path($blog->image)))
                                <a href="{{ route('blog.details', $blog->slug) }}" class="d-block overflow-hidden rounded-top-3">
                                    <img src="{{ asset($blog->image) }}" class="card-img-top w-100 blog-img" alt="{{ $blog->title }}">
                                </a>
                            @else
                                <a href="{{ route('blog.details', $blog->slug) }}" class="d-block bg-light text-center rounded-top-3 border-bottom d-flex align-items-center justify-content-center" style="height: 220px;">
                                    <img src="{{ asset('fav.png') }}" alt="{{ $blog->title }}" style="max-height: 90px; max-width: 75%; object-fit: contain;">
                                </a>
                            @endif

                            <div class="card-body p-4 d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2">
                                    <a href="{{ route('blog.details', $blog->slug) }}" class="text-dark text-decoration-none blog-title-link">
                                        {{ Str::limit($blog->title, 65, '...') }}
                                    </a>
                                </h5>

                                <p class="text-muted small mb-3 fw-semibold">
                                    {{ $blog->category->name ?? 'Wedding Photography' }}
                                </p>

                                <p class="card-text text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                                    {{ Str::limit(strip_tags($blog->short_description ?? $blog->description), 130) }}
                                </p>

                                <div class="mt-auto">
                                    <a href="{{ route('blog.details', $blog->slug) }}" class="text-dark fw-bold text-decoration-underline read-more-btn">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <strong class="text-muted">NO BLOG POSTS FOUND</strong>
                    </div>
                @endforelse
            </div>

            @if(isset($blogs) && count($blogs) > 0)
                <div class="text-center mt-5">
                    <a class="btn btn-primary py-2 px-4" href="{{ route('blog.index') }}">View All Blogs</a>
                </div>
            @endif
        </div>
    </div>
    <!-- Blog Section End -->

    <!-- Contact Section Start -->
    <div class="contact_sec py-5 mt-4 mt-lg-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <p class="text-primary text-uppercase sub_title mb-2">Contact Us</p>
                <h1 class="display-6 mb-3 fw-bold text-dark">Get In Touch</h1>
                <p class="text-muted small">We'd love to hear from you. Leave us a message!</p>
            </div>
            
            <div class="row">
                <div class="col-lg-5 order-lg-2 mb-4 mb-lg-0">
                    <div class="contact_info mb-4 bg-light p-4 rounded shadow-sm h-100 d-flex flex-column">
                        <div class="d-flex mb-4 align-items-center">
                            <div class="me-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div class="">
                                {{ $home_page_content->address ?? '_' }}
                            </div>
                        </div>
                        <div class="d-flex mb-4 align-items-center">
                            <div class="me-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </div>
                            <div class="">
                                <a href="mailto:{{ $home_page_content->email ?? '#'}}">{{ $home_page_content->email ?? '_'}}</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-call-icon lucide-phone-call"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/><path d="M14.05 2a9 9 0 0 1 8 7.94"/><path d="M14.05 6A5 5 0 0 1 18 10"/></svg>
                            </div>
                            <div class="">
                                <a href="tel:{{ $home_page_content->phone ?? '#' }}">{{ $home_page_content->phone ?? '_' }}</a>
                            </div>
                        </div>
                        <div class="map p-0 mb-0 mt-4 flex-grow-1">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52872517.59607392!2d-161.691169406869!3d36.018281840171966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2z4Kau4Ka-4Kaw4KeN4KaV4Ka_4KaoIOCmr-CngeCmleCnjeCmpOCmsOCmvuCmt-CnjeCmn-CnjeCmsA!5e0!3m2!1sbn!2sbd!4v1745556191423!5m2!1sbn!2sbd" width="100%" height="250" class="border-0 p-0 rounded w-100" style="min-height: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 order-lg-1">
                    <div class="bg-light p-4 rounded shadow-sm h-100">
                        <h5 class="mb-4 fw-bold">Send Us a Message</h5>
                        <form method="post" action="{{route('contact.store')}}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-none border-0" name="name" id="name" placeholder="Your Name" required>
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control shadow-none border-0" name="email" id="email" placeholder="Your Email" required>
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-none border-0"  name="subject" id="subject" placeholder="Subject" required>
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control shadow-none border-0" name="message" placeholder="Leave a message here" id="message" required
                                            style="height: 200px"></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button class="btn btn-primary py-3 px-5 w-100 fw-bold" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section End -->

    <!-- Modal -->
    <div class="modal fade" id="packageDetails" tabindex="-1" aria-labelledby="packageDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div id="packageDetailsContent">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
<style>
    /* Make owl carousel items equal height */
    .testimonial-carousel .owl-stage {
        display: flex;
        align-items: stretch;
    }
    .testimonial-carousel .owl-item {
        display: flex;
    }
    .testimonial-carousel .owl-item > div {
        width: 100%;
    }
    .blog-card-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .blog-card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important;
    }
    .blog-img {
        height: 220px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .blog-card-item:hover .blog-img {
        transform: scale(1.05);
    }
    .blog-title-link:hover,
    .read-more-btn:hover {
        color: #d4a373 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleReview(id) {
        var short = document.getElementById('review-short-' + id);
        var full = document.getElementById('review-full-' + id);
        if (short.classList.contains('d-none')) {
            // Show short, hide full
            short.classList.remove('d-none');
            full.classList.add('d-none');
        } else {
            // Hide short, show full
            short.classList.add('d-none');
            full.classList.remove('d-none');
        }
        
        // Let Owl Carousel recalculate height after content change
        setTimeout(function() {
            $('.testimonial-carousel').trigger('refresh.owl.carousel');
        }, 50);
    }
</script>
<script>
    $(document).ready(function() {
        $('.viewPackageDetails').click(function() {
            var packageId = $(this).data('id');
            $.ajax({
                url: "{{ route('package.details') }}",
                type: "GET",
                data: {
                    id: packageId
                },
                success: function(response) {
                    $('#packageDetailsContent').html(response);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    $('#packageDetailsContent').html(
                        '<div class="p-4 text-center">Something went wrong. Please try again later.</div>'
                    );
                }
            });
        });
    });
</script>
@endpush
