@extends('frontend.layout.app')
@section('title', $title ?? 'About Us | Memory Click')
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

    <!-- About Start -->
    <div class="about_sec section_gap bg-white" style="padding-top: 25px; padding-bottom: 25px;">
        <div class="container">
            {{-- {!!$page->body!!} --}}
            <div class="text-center">
                <h2>{{ $page->title_1 ?? 'About CEO' }}</h2>
                {{-- <p class="mb-0">This section will hold about us content dynamically.</p> --}}
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Founder Start -->
    <div class="founder_sec bg-light section_gap">
        <div class="container">
            <div class="row d-flex align-items-center">
                <!-- Image Right -->
                <div class="col-lg-6 mb-4 mb-lg-0 order-lg-2">
                    <div class="about_bx text-center text-lg-end">
                        <img src="{{ asset($page->ceo_image) }}" class="img-fluid rounded shape-md mt-5 mb-5"
                            alt="">
                    </div>
                </div>
                <!-- Content Left -->
                <div class="col-lg-6 order-lg-1">
                    <div>
                        <p class="text-primary text-uppercase sub_title mb-2">{{ $page->ceo_designation ?? '' }}</p>
                        <h1 class="title mb-4">{{ $page->ceo_name ?? '' }}</h1>
                        <p class="mb-4 text-justify">
                            {{ $page->body ?? '' }}
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Founder End -->

    <!-- About Memoryclick (Title Section) -->
    <div class="about_sec bg-white" style="padding-top: 25px; padding-bottom: 25px;">
        <div class="container">
            <div class="text-center">
                <h2>{{ $page->title_2 ?? 'About MemoryClick' }}</h2>
                {{-- <p class="mb-0">This section will hold about us content dynamically.</p> --}}
            </div>
        </div>
    </div>
    <!-- About Memoryclick End -->


    <!-- About Memoryclick (Details Section) -->
    <div class="about_memoryclick section_gap bg-light py-5">
        <div class="container">
            <div class="row d-flex align-items-center">
                <!-- Image Left -->
                <div class="col-lg-6 mb-4 mb-lg-0 order-lg-1">
                    <div class="about_bx text-center text-lg-start">
                        <img src="{{ asset($page->memoryclick_image) }}" class="img-fluid rounded shape-md mt-5"
                            alt="">
                    </div>
                </div>
                <!-- Content Right -->
                <div class="col-lg-6 order-lg-2">
                    <div>
                        <p class="text-primary text-uppercase sub_title mb-2">Our Journey</p>
                        <h1 class="title mb-4">Memoryclick Story</h1>
                        <p class="mb-4 text-justify">
                            {{ $page->about_memoryclick ?? '' }}
                        </p>

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
                        <div class="team-membem shadow-sm bg-light p-3 p-lg-4 rounded text-center">
                            <img src="{{ asset($team->image) }}" class="img-fluid rounded mb-3" alt="Photographer">
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
