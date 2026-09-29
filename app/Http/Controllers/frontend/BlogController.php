<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $siteInfo = DB::table('home_page_contents')->first();
        $data['title'] = 'Blog & Stories — MemoryClick.com.bd';
        $data['siteInfo'] = $siteInfo;

        $categories = BlogCategory::where('status', 1)->withCount('posts')->get();
        $data['categories'] = $categories;

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

        $data['posts'] = $query->latest()->paginate(12)->withQueryString();
        $data['selectedCategory'] = $selectedCategorySlug;

        return view('frontend.blog.index', $data);
    }

    public function details(Request $request, $slug)
    {
        $siteInfo = DB::table('home_page_contents')->first();
        $post = BlogPost::where('slug', $slug)->where('status', 1)->with('category')->firstOrFail();

        // Increment views count
        $post->increment('views');

        $data['post'] = $post;
        $data['title'] = $post->title . ' — MemoryClick.com.bd';
        $data['siteInfo'] = $siteInfo;

        $data['categories'] = BlogCategory::where('status', 1)->withCount('posts')->get();
        $data['relatedPosts'] = BlogPost::with('category')
            ->where('status', 1)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.blog.details', $data);
    }
}
