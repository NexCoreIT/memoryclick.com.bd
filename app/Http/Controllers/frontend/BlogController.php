<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index(Request $request)
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

        $paginator = $query->latest()->paginate(9)->withQueryString();

        $posts = collect($paginator->items())->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'short_description' => $post->short_description,
                'author_name' => $post->author_name ?? 'MemoryClick',
                'created_at' => $post->created_at ? $post->created_at->format('M d, Y') : null,
                'views' => $post->views ?? 0,
                'image' => $post->image,
                'image_url' => $post->image ? asset($post->image) : asset('fav.png'),
                'category' => $post->category ? [
                    'id' => $post->category->id,
                    'name' => $post->category->name,
                    'slug' => $post->category->slug,
                ] : null,
            ];
        });

        return Inertia::render('Blog/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
            ],
            'selected_category' => $selectedCategorySlug,
            'search_query' => $searchQuery ?? '',
        ]);
    }

    public function details(Request $request, $slug)
    {
        $post = BlogPost::where('slug', $slug)->where('status', 1)->with('category')->firstOrFail();
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
                    'image' => $rp->image,
                    'image_url' => $rp->image ? asset($rp->image) : asset('fav.png'),
                    'created_at' => $rp->created_at ? $rp->created_at->format('M d, Y') : null,
                ];
            });

        return Inertia::render('Blog/Details', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'short_description' => $post->short_description,
                'description' => $post->description,
                'author_name' => $post->author_name ?? 'MemoryClick Studio',
                'created_at' => $post->created_at ? $post->created_at->format('M d, Y') : null,
                'views' => $post->views ?? 0,
                'image' => $post->image,
                'image_url' => $post->image ? asset($post->image) : asset('fav.png'),
                'category' => $post->category ? [
                    'id' => $post->category->id,
                    'name' => $post->category->name,
                    'slug' => $post->category->slug,
                ] : null,
            ],
            'seo' => [
                'meta_title' => $post->meta_title ?: "{$post->title} | Memory Click",
                'meta_description' => $post->meta_description ?: $post->short_description,
                'meta_keywords' => $post->meta_keywords ?? '',
            ],
            'categories' => $categories,
            'related_posts' => $relatedPosts,
        ]);
    }
}
