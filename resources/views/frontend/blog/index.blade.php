@extends('frontend.layout.app')

@section('title', $title ?? 'Blog & Stories | Memory Click')

@section('seo')
    <meta name="description" content="Discover the latest event photography tips, wedding cinematography trends, and studio stories from MemoryClick Studio.">
    <meta name="keywords" content="MemoryClick blog, photography tips, wedding photography, event videography, studio stories Bangladesh">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Blog & Stories | Memory Click">
    <meta property="og:description" content="Discover the latest event photography tips, wedding cinematography trends, and studio stories from MemoryClick Studio.">
    <meta property="og:image" content="{{ asset('fav.png') }}">
@endsection

@push('styles')
    <style>
        .blog_card {
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #eee;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog_card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(234, 166, 54, 0.2);
            border-color: var(--primary, #EAA636);
        }

        .blog_card_img_wrap {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: #fdf5eb;
        }

        .blog_card_img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .blog_card:hover .blog_card_img {
            transform: scale(1.06);
        }

        .blog_badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--primary, #EAA636);
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 12px;
            border-radius: 4px;
            z-index: 2;
        }

        .blog_card_body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .blog_meta {
            font-size: 12px;
            color: var(--secondary, #545454);
            margin-bottom: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .blog_card_title {
            font-family: "Playfair Display", serif;
            font-size: 19px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .blog_card_title a {
            color: var(--dark, #1E1916);
            text-decoration: none;
            transition: color 0.25s ease;
        }

        .blog_card_title a:hover {
            color: var(--primary, #EAA636);
        }

        .blog_card_desc {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .blog_read_more {
            font-weight: 600;
            font-size: 13px;
            color: var(--primary, #EAA636);
            text-transform: uppercase;
            text-decoration: none;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s ease;
        }

        .blog_read_more:hover {
            color: var(--dark, #1E1916);
            gap: 10px;
        }

        .filter-button.active {
            color: var(--primary, #EAA636) !important;
            font-weight: 700 !important;
            border-bottom: 2px solid var(--primary, #EAA636) !important;
        }

        @media (max-width: 575.98px) {
            .blog_card_img_wrap {
                height: 180px;
            }
            .blog_card_body {
                padding: 15px;
            }
            .blog_card_title {
                font-size: 16px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>Blog & Stories</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- Blog Section Start -->
    <div class="blog_sec section_gap py-5">
        <div class="container">
            <div class="text-center mx-auto mb-4" style="max-width:600px;">
                <p class="text-primary text-uppercase sub_title mb-2">Our Blog</p>
                <h1 class="display-6 mb-3">Explore Latest Photography & Cinematography Stories</h1>
            </div>

            <!-- Filter & Search Bar -->
            <div class="row align-items-center justify-content-between mb-4 gy-3">
                <div class="col-lg-8 text-center text-lg-start">
                    <a href="{{ route('blog.index') }}" class="btn btn-default shadow-none border-0 bg-transparent filter-button {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'active' : '' }}">
                        All
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                            class="btn btn-default shadow-none border-0 bg-transparent filter-button {{ $selectedCategory === $category->slug ? 'active' : '' }}">
                            {{ $category->name }} ({{ $category->posts_count }})
                        </a>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <form action="{{ route('blog.index') }}" method="GET">
                        @if(!empty($selectedCategory))
                            <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        @endif
                        <div class="input-group">
                            <input type="text" name="search" class="form-control shadow-none rounded-start border" placeholder="Search articles..." value="{{ request('search') }}">
                            <button class="btn btn-primary px-3 text-white" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Blog Grid -->
            <div class="row g-4">
                @forelse ($posts as $post)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="blog_card">
                            <div class="blog_card_img_wrap">
                                @if ($post->category)
                                    <span class="blog_badge">
                                        {{ $post->category->name }}
                                    </span>
                                @endif

                                <a href="{{ route('blog.details', $post->slug) }}" class="d-block w-100 h-100">
                                    @if (!empty($post->image) && file_exists(public_path($post->image)))
                                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="blog_card_img" loading="lazy">
                                    @else
                                        <img src="{{ asset('fav.png') }}" alt="{{ $post->title }}" class="blog_card_img p-4 bg-dark object-fit-contain" loading="lazy">
                                    @endif
                                </a>
                            </div>

                            <div class="blog_card_body">
                                <div class="blog_meta">
                                    <span><i class="far fa-user text-primary me-1"></i> {{ $post->author_name ?? 'MemoryClick' }}</span>
                                    <span><i class="far fa-calendar-alt text-primary me-1"></i> {{ $post->created_at ? $post->created_at->format('M d, Y') : 'N/A' }}</span>
                                    <span><i class="far fa-eye text-primary me-1"></i> {{ number_format($post->views) }}</span>
                                </div>

                                <h3 class="blog_card_title">
                                    <a href="{{ route('blog.details', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <p class="blog_card_desc">
                                    {{ Str::limit(strip_tags($post->short_description ?? $post->description), 110) }}
                                </p>

                                <div class="pt-2 border-top mt-auto">
                                    <a href="{{ route('blog.details', $post->slug) }}" class="blog_read_more">
                                        Read Article <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="bg-light p-5 rounded shadow-sm border text-muted mx-auto" style="max-width: 500px;">
                            <i class="fas fa-newspaper fa-3x text-primary mb-3"></i>
                            <h4 class="text-dark fw-bold mb-2">No Blog Posts Found</h4>
                            <p class="mb-0 small">There are currently no blog articles matching your criteria.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- PAGINATION -->
            @if ($posts->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Blog Section End -->
@endsection
