@extends('frontend.layout.app')

@php
    $seoTitle = !empty($post->meta_title) ? $post->meta_title : ($post->title . ' | Memory Click');
    $seoDescription = !empty($post->meta_description)
        ? $post->meta_description
        : Str::limit(strip_tags($post->short_description ?? $post->description), 160);
    $seoKeywords = !empty($post->meta_keywords) ? $post->meta_keywords : 'memory click, blog, photography, event videography';
    $seoImage = !empty($post->image) ? asset($post->image) : asset('fav.png');
    $seoUrl = url()->current();
@endphp

@section('title', $seoTitle)

@section('seo')
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <link rel="canonical" href="{{ $seoUrl }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:site_name" content="Memory Click">
    <meta property="article:published_time" content="{{ $post->created_at ? $post->created_at->toIso8601String() : '' }}">
    <meta property="article:modified_time" content="{{ $post->updated_at ? $post->updated_at->toIso8601String() : '' }}">
    @if($post->category)
        <meta property="article:section" content="{{ $post->category->name }}">
    @endif

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $seoUrl }}">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <!-- Schema.org JSON-LD Structured Data for Google Ranking -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $seoUrl }}"
      },
      "headline": "{{ addslashes($post->title) }}",
      "description": "{{ addslashes($seoDescription) }}",
      "image": "{{ $seoImage }}",
      "author": {
        "@type": "Organization",
        "name": "{{ addslashes($post->author_name ?? 'MemoryClick Studio') }}"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Memory Click",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ asset('fav.png') }}"
        }
      },
      "datePublished": "{{ $post->created_at ? $post->created_at->toIso8601String() : date('c') }}",
      "dateModified": "{{ $post->updated_at ? $post->updated_at->toIso8601String() : date('c') }}"
    }
    </script>
@endsection

@push('styles')
    <style>
        .blog_details_card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #eee;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 35px;
        }

        .blog_details_badge {
            display: inline-block;
            background: var(--primary, #EAA636);
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 5px 16px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .blog_details_title {
            font-family: "Playfair Display", serif;
            font-weight: 700;
            color: var(--dark, #1E1916);
            font-size: clamp(1.25rem, 4vw, 2.3rem);
            line-height: 1.35;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .blog_lead_quote {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #333;
            background: #fdf5eb;
            border-left: 4px solid var(--primary, #EAA636);
            padding: 16px 20px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 25px;
            font-style: italic;
        }

        .blog_featured_img {
            width: 100%;
            max-height: 480px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .blog_content {
            font-size: 16px;
            line-height: 1.8;
            color: #444;
            word-wrap: break-word;
        }

        .blog_content h1, .blog_content h2, .blog_content h3, .blog_content h4 {
            font-family: "Playfair Display", serif;
            color: var(--dark, #1E1916);
            font-weight: 700;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .blog_content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 15px 0;
        }

        .share_btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fdf5eb;
            color: var(--primary, #EAA636);
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .share_btn:hover {
            background: var(--primary, #EAA636);
            color: #ffffff;
            transform: scale(1.1);
        }

        @media (max-width: 767.98px) {
            .blog_details_card {
                padding: 20px 15px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb_sec bg-light py-4">
        <div class="container">
            <h4>Blog Details</h4>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 30) }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- Article Content Start -->
    <div class="blog_details_sec section_gap py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">

                    <!-- MAIN ARTICLE CARD -->
                    <div class="blog_details_card mb-5">
                        @if ($post->category)
                            <span class="blog_details_badge">
                                {{ $post->category->name }}
                            </span>
                        @endif

                        <h1 class="blog_details_title mb-3">
                            {{ $post->title }}
                        </h1>

                        <!-- AUTHOR & META HEADER -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-3 mb-4 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px;">
                                    MC
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">
                                        {{ $post->author_name ?? 'MemoryClick Studio' }}
                                    </h6>
                                    <small class="text-muted">
                                        Published on {{ $post->created_at ? $post->created_at->format('F d, Y') : 'N/A' }} · {{ number_format($post->views) }} Views
                                    </small>
                                </div>
                            </div>

                            <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                <i class="fas fa-arrow-left me-1"></i> Back to Blog
                            </a>
                        </div>

                        <!-- LEAD QUOTE -->
                        @if (!empty($post->short_description))
                            <div class="blog_lead_quote">
                                "{{ $post->short_description }}"
                            </div>
                        @endif

                        <!-- FEATURED IMAGE -->
                        @if (!empty($post->image))
                            <div>
                                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="blog_featured_img" loading="lazy">
                            </div>
                        @endif

                        <!-- ARTICLE HTML CONTENT -->
                        <div class="blog_content">
                            {!! $post->description !!}
                        </div>

                        <!-- ACTION BAR / SHARE BUTTONS -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pt-4 mt-5 border-top">
                            <div class="text-muted small fw-semibold">
                                <i class="far fa-eye me-1 text-primary"></i> {{ number_format($post->views) }} Reads
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="small fw-bold text-uppercase text-muted me-2">Share:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share_btn" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share_btn" title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" class="share_btn" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="share_btn" title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- RELATED ARTICLES -->
                    @if (isset($relatedPosts) && count($relatedPosts) > 0)
                        <div class="pt-3">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h3 class="fw-bold text-dark mb-0" style="font-family: 'Playfair Display', serif;">Related Articles</h3>
                                <a href="{{ route('blog.index') }}" class="text-primary fw-bold text-decoration-none small text-uppercase">
                                    View All <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>

                            <div class="row g-4">
                                @foreach ($relatedPosts as $relPost)
                                    <div class="col-12 col-md-4">
                                        <div class="card h-100 border-0 shadow-sm rounded overflow-hidden">
                                            @if(!empty($relPost->image))
                                                <img src="{{ asset($relPost->image) }}" class="card-img-top" alt="{{ $relPost->title }}" style="height: 160px; object-fit: cover;">
                                            @endif
                                            <div class="card-body p-3 d-flex flex-column">
                                                @if($relPost->category)
                                                    <span class="badge bg-primary text-white me-auto mb-2" style="font-size: 10px;">{{ $relPost->category->name }}</span>
                                                @endif
                                                <h6 class="card-title fw-bold" style="font-family: 'Playfair Display', serif;">
                                                    <a href="{{ route('blog.details', $relPost->slug) }}" class="text-dark text-decoration-none">
                                                        {{ Str::limit($relPost->title, 45) }}
                                                    </a>
                                                </h6>
                                                <p class="card-text small text-muted mb-3 flex-grow-1">
                                                    {{ Str::limit(strip_tags($relPost->short_description ?? $relPost->description), 75) }}
                                                </p>
                                                <a href="{{ route('blog.details', $relPost->slug) }}" class="text-primary fw-bold small text-decoration-none">
                                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- Article Content End -->
@endsection
