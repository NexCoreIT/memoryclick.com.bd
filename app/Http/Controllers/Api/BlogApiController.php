<?php

namespace App\Http\Controllers\Api;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogApiController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $categories = BlogCategory::where('status', 1)
            ->withCount('posts')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'posts_count' => $cat->posts_count,
                ];
            });

        $selectedCategorySlug = $request->get('category');
        $searchQuery = $request->get('search');

        $query = BlogPost::where('status', 1)->with('category');

        if (!empty($selectedCategorySlug) && $selectedCategorySlug !== 'all') {
            $category = BlogCategory::where('slug', $selectedCategorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('short_description', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('description', 'LIKE', "%{$searchQuery}%");
            });
        }

        $perPage = $request->get('per_page', 12);
        $paginator = $query->latest()->paginate($perPage);

        $posts = collect($paginator->items())->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'short_description' => $post->short_description ?: strip_tags($post->description),
                'author_name' => $post->author_name ?? 'MemoryClick',
                'created_at' => $post->created_at ? $post->created_at->format('M d, Y') : null,
                'views' => (int) $post->views,
                'image' => $post->image,
                'image_url' => self::formatImageUrl($post->image) ?: self::formatImageUrl('fav.png'),
                'category' => $post->category ? [
                    'id' => $post->category->id,
                    'name' => $post->category->name,
                    'slug' => $post->category->slug,
                ] : null,
            ];
        });

        return $this->successResponse([
            'categories' => $categories,
            'posts' => $posts,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
            'selected_category' => $selectedCategorySlug,
            'search_query' => $searchQuery,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $post = BlogPost::where('slug', $slug)
            ->where('status', 1)
            ->with('category')
            ->first();

        if (!$post) {
            return $this->errorResponse('Blog post not found', 404);
        }

        // Increment views
        $post->increment('views');

        $categories = BlogCategory::where('status', 1)
            ->withCount('posts')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'posts_count' => $cat->posts_count,
                ];
            });

        $relatedPosts = BlogPost::with('category')
            ->where('status', 1)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($rp) {
                return [
                    'id' => $rp->id,
                    'title' => $rp->title,
                    'slug' => $rp->slug,
                    'short_description' => $rp->short_description ?: strip_tags($rp->description),
                    'author_name' => $rp->author_name ?? 'MemoryClick',
                    'created_at' => $rp->created_at ? $rp->created_at->format('M d, Y') : null,
                    'views' => (int) $rp->views,
                    'image_url' => self::formatImageUrl($rp->image) ?: self::formatImageUrl('fav.png'),
                    'category' => $rp->category ? [
                        'id' => $rp->category->id,
                        'name' => $rp->category->name,
                        'slug' => $rp->category->slug,
                    ] : null,
                ];
            });

        $seoTitle = !empty($post->meta_title) ? $post->meta_title : ($post->title . ' | Memory Click');
        $seoDescription = !empty($post->meta_description)
            ? $post->meta_description
            : \Illuminate\Support\Str::limit(strip_tags($post->short_description ?? $post->description), 160);
        $seoKeywords = !empty($post->meta_keywords) ? $post->meta_keywords : 'memory click, blog, photography, event videography';
        $seoImage = self::formatImageUrl($post->image) ?: self::formatImageUrl('fav.png');

        return $this->successResponse([
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'short_description' => $post->short_description,
                'description' => $post->description,
                'author_name' => $post->author_name ?? 'MemoryClick',
                'created_at' => $post->created_at ? $post->created_at->format('M d, Y') : null,
                'created_at_iso' => $post->created_at ? $post->created_at->toIso8601String() : null,
                'updated_at_iso' => $post->updated_at ? $post->updated_at->toIso8601String() : null,
                'views' => (int) $post->views,
                'image' => $post->image,
                'image_url' => self::formatImageUrl($post->image) ?: self::formatImageUrl('fav.png'),
                'category' => $post->category ? [
                    'id' => $post->category->id,
                    'name' => $post->category->name,
                    'slug' => $post->category->slug,
                ] : null,
            ],
            'seo' => [
                'meta_title' => $seoTitle,
                'meta_description' => $seoDescription,
                'meta_keywords' => $seoKeywords,
                'meta_image_url' => $seoImage,
            ],
            'categories' => $categories,
            'related_posts' => $relatedPosts,
        ]);
    }
}
