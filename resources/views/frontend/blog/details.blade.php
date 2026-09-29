@extends('frontend.layout.app')

@section('title', $title ?? $post->title . ' — MemoryClick.com.bd')

@push('styles')
    <style>
        .blog-details-hero {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            padding: 50px 0 35px;
            color: #ffffff;
        }

        .blog-details-badge {
            display: inline-block;
            background: #2563eb;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 5px 16px;
            border-radius: 50px;
            margin-bottom: 15px;
        }

        .article-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            padding: 40px;
        }

        .blog-lead-quote {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #1f2937;
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 16px 20px;
            border-radius: 0 12px 12px 0;
            margin-bottom: 30px;
            font-style: italic;
        }

        .blog-featured-img-wrap {
            text-align: center;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 35px;
            max-height: 500px;
            background: #f3f4f6;
        }

        .blog-featured-img-wrap img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
        }

        .blog-article-content {
            font-size: 17.5px;
            line-height: 1.85;
            color: #374151;
            word-wrap: break-word;
        }

        .blog-article-content h1,
        .blog-article-content h2,
        .blog-article-content h3,
        .blog-article-content h4 {
            color: #111827;
            font-weight: 700;
            margin-top: 1.75rem;
            margin-bottom: 0.85rem;
        }

        .blog-article-content p {
            margin-bottom: 1.3rem;
        }

        .blog-article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 18px 0;
        }

        .share-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #374151;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .share-btn:hover {
            background: #2563eb;
            color: #ffffff;
            transform: scale(1.1);
        }

        @media (max-width: 767.98px) {
            .article-card {
                padding: 20px 16px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- HERO SECTION -->
    <section class="blog-details-hero text-center">
        <div class="container">
            <h1 class="display-6 fw-bold mb-0">Blog Details</h1>
        </div>
    </section>

    <!-- ARTICLE SECTION -->
    <section class="py-5 bg-light">
        <div class="container py-2">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">

                    <!-- ARTICLE CARD -->
                    <div class="article-card mb-5">
                        @if ($post->category)
                            <span class="blog-details-badge">
                                {{ $post->category->name }}
                            </span>
                        @endif

                        <h1 class="fw-bold mb-3 text-dark display-6">
                            {{ $post->title }}
                        </h1>

                        <!-- AUTHOR HEADER BAR -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-4 mb-4 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px; font-size: 16px;">
                                    MC
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">
                                        {{ $post->author_name ?? 'MemoryClick Studio' }}
                                    </h6>
                                    <small class="text-muted">
                                        Published on {{ $post->created_at ? $post->created_at->format('F d, Y') : 'N/A' }} · {{ number_format($post->views) }} Views
                                    </small>
                                </div>
                            </div>

                            <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
                                <i class="fas fa-arrow-left me-1"></i> Back to Blog
                            </a>
                        </div>

                        <!-- LEAD QUOTE -->
                        @if (!empty($post->short_description))
                            <div class="blog-lead-quote">
                                "{{ $post->short_description }}"
                            </div>
                        @endif

                        <!-- FEATURED IMAGE -->
                        @if (!empty($post->image))
                            <div class="blog-featured-img-wrap">
                                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" loading="lazy">
                            </div>
                        @endif

                        <!-- ARTICLE BODY -->
                        <div class="blog-article-content">
                            {!! $post->description !!}
                        </div>

                        <!-- BOTTOM ACTION BAR -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pt-4 mt-5 border-top">
                            <div class="text-muted small fw-semibold">
                                <i class="far fa-eye me-1 text-primary"></i> {{ number_format($post->views) }} Reads
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="small fw-bold text-uppercase text-muted me-2">Share:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-btn" title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" class="share-btn" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="share-btn" title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- RELATED ARTICLES SECTION -->
                    @if (isset($relatedPosts) && count($relatedPosts) > 0)
                        <div class="pt-3">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h3 class="fw-bold text-dark mb-0">Related Articles</h3>
                                <a href="{{ route('blog.index') }}" class="text-primary fw-bold text-decoration-none small text-uppercase">
                                    View All <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>

                            <div class="row g-4">
                                @foreach ($relatedPosts as $relPost)
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                            @if(!empty($relPost->image))
                                                <img src="{{ asset($relPost->image) }}" class="card-img-top" alt="{{ $relPost->title }}" style="height: 160px; object-fit: cover;">
                                            @endif
                                            <div class="card-body p-3 d-flex flex-column">
                                                @if($relPost->category)
                                                    <span class="badge bg-primary me-auto mb-2" style="font-size: 10px;">{{ $relPost->category->name }}</span>
                                                @endif
                                                <h6 class="card-title fw-bold">
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
    </section>
@endsection
