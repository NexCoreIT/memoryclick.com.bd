<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = request('status') === 'pending' ? 'Pending Blog Posts' : 'Blog Posts Directory';
        $query = BlogPost::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'pending' || $request->status === '0') {
                $query->where('status', 0);
            } elseif ($request->status === 'published' || $request->status === '1') {
                $query->where('status', 1);
            }
        }

        $data['posts'] = $query->paginate(15);
        $data['categories'] = BlogCategory::where('status', 1)->orderBy('name')->get();

        $data['allCount'] = BlogPost::count();
        $data['publishedCount'] = BlogPost::where('status', 1)->count();
        $data['pendingCount'] = BlogPost::where('status', 0)->count();

        return view('backend.admin.blog.posts.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Add New Blog Post';
        $data['categories'] = BlogCategory::where('status', 1)->orderBy('name')->get();
        return view('backend.admin.blog.posts.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255|unique:blog_posts,title',
            'author_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'views' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|in:0,1',
            'status' => 'required|in:0,1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blog'), $filename);
            $imagePath = 'uploads/blog/' . $filename;
        }

        BlogPost::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author_name' => $request->author_name ?? 'MemoryClick Studio',
            'slug' => Str::slug($request->title),
            'image' => $imagePath,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'meta_title' => $request->meta_title ?? $request->title,
            'meta_description' => $request->meta_description ?? Str::limit(strip_tags($request->short_description ?? $request->description), 160),
            'meta_keywords' => $request->meta_keywords,
            'views' => $request->views ?? 0,
            'is_featured' => $request->is_featured ?? 0,
            'status' => $request->status,
        ]);

        return redirect()->route('blog.post.index')->with('success', 'Blog post created successfully.');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Blog Post';
        $data['post'] = BlogPost::findOrFail($id);
        $data['categories'] = BlogCategory::where('status', 1)->orderBy('name')->get();
        return view('backend.admin.blog.posts.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255|unique:blog_posts,title,' . $post->id,
            'author_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'views' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|in:0,1',
            'status' => 'required|in:0,1',
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image && File::exists(public_path($post->image))) {
                File::delete(public_path($post->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blog'), $filename);
            $imagePath = 'uploads/blog/' . $filename;
        }

        $post->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author_name' => $request->author_name ?? $post->author_name ?? 'MemoryClick Studio',
            'slug' => Str::slug($request->title),
            'image' => $imagePath,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'meta_title' => $request->meta_title ?? $request->title,
            'meta_description' => $request->meta_description ?? Str::limit(strip_tags($request->short_description ?? $request->description), 160),
            'meta_keywords' => $request->meta_keywords,
            'views' => $request->views ?? $post->views ?? 0,
            'is_featured' => $request->is_featured ?? 0,
            'status' => $request->status,
        ]);

        return redirect()->route('blog.post.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        if ($post->image && File::exists(public_path($post->image))) {
            File::delete(public_path($post->image));
        }
        $post->delete();

        return redirect()->route('blog.post.index')->with('success', 'Blog post deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->status = $post->status == 1 ? 0 : 1;
        $post->save();

        $statusText = $post->status == 1 ? 'Approved & Published' : 'Set to Pending';
        return redirect()->back()->with('success', "Blog post status updated to {$statusText}.");
    }
}
