@extends('frontend.layout.app')

@section('title', $title ?? 'Blog & Stories — MemoryClick.com.bd')

@push('styles')
    <style>
        .blog-hero-section {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            padding: 60px 0 40px;
            color: #ffffff;
            position: relative;
        }

        .blog-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
            border-color: #3b82f6;
        }

        .blog-card-img-wrap {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: #f3f4f6;
        }

        .blog-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .blog-card:hover .blog-card-img {
            transform: scale(1.06);
        }

        .blog-category-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #0284c7;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 12px;
            border-radius: 50px;
            z-index: 2;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .blog-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .blog-meta-list {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .blog-card-title {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .blog-card-title a {
            color: #111827;
            text-decoration: none;
            transition: color 0.25s ease;
        }

        .blog-card-title a:hover {
            color: #2563eb;
        }

        .blog-card-desc {
            font-size: 13.5px;
            color: #4b5563;
            line-height: 1.55;
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .blog-card-footer {
            border-top: 1px solid #f3f4f6;
            padding-top: 12px;
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .blog-read-more-link {
            font-size: 13px;
            font-weight: 700;
            color: #2563eb;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.25s ease;
        }

        .blog-read-more-link:hover {
            color: #1d4ed8;
            gap: 10px;
        }

        .category-filter-btn {
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 18px;
            transition: all 0.2s ease;
        }

        .category-filter-btn.active {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }
    </style>
@endpush

@section('content')
    <!-- HERO SECTION -->
    <section class="blog-hero-section text-center">
        <div class="container py-4">
            <h1 class="display-5 fw-bold mb-2">Our Blog & Stories</h1>
            <p class="lead text-gray-300 mx-auto" style="max-width: 650px;">
                Explore latest photography trends, wedding stories, videography tips, and behind-the-scenes insights from MemoryClick Studio.
            </p>
        </div>
    </section>

    <!-- MAIN CONTENT SECTION -->
    <section class="py-5 bg-light">
        <div class="container py-2">

            <!-- FILTER BAR & SEARCH -->
            <div class="row g-3 align-items-center mb-4">
                <div class="col-lg-8">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary category-filter-btn {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'active' : '' }}">
                            All Categories
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                               class="btn btn-outline-secondary category-filter-btn {{ $selectedCategory === $cat->slug ? 'active' : '' }}">
                                {{ $cat->name }} ({{ $cat->posts_count }})
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4">
                    <form action="{{ route('blog.index') }}" method="GET">
                        @if(!empty($selectedCategory))
                            <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        @endif
                        <div class="input-group">
                            <input type="text" name="search" class="form-control shadow-none" placeholder="Search blog articles..." value="{{ request('search') }}">
                            <button class="btn btn-primary px-3" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- BLOG POSTS GRID -->
            <div class="row g-4">
                @forelse ($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-card">
                            <div class="blog-card-img-wrap">
                                @if ($post->category)
                                    <span class="blog-category-badge">
                                        {{ $post->category->name }}
                                    </span>
                                @endif

                                <a href="{{ route('blog.details', $post->slug) }}" class="d-block w-100 h-100">
                                    @if (!empty($post->image) && file_exists(public_path($post->image)))
                                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="blog-card-img" loading="lazy">
                                    @else
                                        <img src="{{ asset('fav.png') }}" alt="{{ $post->title }}" class="blog-card-img p-4 bg-dark object-fit-contain" loading="lazy">
                                    @endif
                                </a>
                            </div>

                            <div class="blog-card-body">
                                <div class="blog-meta-list">
                                    <span><i class="far fa-user text-primary me-1"></i> {{ $post->author_name ?? 'MemoryClick' }}</span>
                                    <span><i class="far fa-calendar-alt text-primary me-1"></i> {{ $post->created_at ? $post->created_at->format('M d, Y') : 'N/A' }}</span>
                                    <span><i class="far fa-eye text-primary me-1"></i> {{ number_format($post->views) }}</span>
                                </div>

                                <h3 class="blog-card-title">
                                    <a href="{{ route('blog.details', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <p class="blog-card-desc">
                                    {{ Str::limit(strip_tags($post->short_description ?? $post->description), 110) }}
                                </p>

                                <div class="blog-card-footer">
                                    <a href="{{ route('blog.details', $post->slug) }}" class="blog-read-more-link">
                                        Read Article <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="bg-white p-5 rounded-4 shadow-sm border text-muted mx-auto" style="max-width: 500px;">
                            <i class="fas fa-newspaper fa-3x text-secondary mb-3"></i>
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
    </section>
@endsection
