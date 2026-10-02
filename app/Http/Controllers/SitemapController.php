<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\CustomPage;
use App\Models\Division;
use App\Models\OurService;
use App\Models\Photography;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $staticUrls = [
            [
                'url' => route('home'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'url' => route('about.page'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'url' => route('photography.page'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'url' => route('cinematography.page'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'url' => route('topService.page'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'url' => route('package'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'url' => route('blog.index'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'url' => route('contactUs.page'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'url' => route('term.page'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'yearly',
                'priority' => '0.3',
            ],
        ];

        // Blog Posts
        $blogPosts = BlogPost::where('status', 1)->latest()->get()->map(function ($post) {
            return [
                'url' => route('blog.details', $post->slug),
                'lastmod' => $post->updated_at ? $post->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        });

        // Photography Details
        $photographies = Photography::where('status', 1)->latest()->get()->map(function ($photo) {
            return [
                'url' => route('photography.details', $photo->slug),
                'lastmod' => $photo->updated_at ? $photo->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        });

        // Services Details
        $services = OurService::where('status', 1)->latest()->get()->map(function ($service) {
            return [
                'url' => route('topService.details', $service->slug),
                'lastmod' => $service->updated_at ? $service->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        });

        // Division Packages
        $divisions = Division::where('status', 1)->get()->map(function ($division) {
            return [
                'url' => route('division.package', $division->slug),
                'lastmod' => $division->updated_at ? $division->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        });

        $urls = collect($staticUrls)
            ->merge($blogPosts)
            ->merge($photographies)
            ->merge($services)
            ->merge($divisions);

        return response()->view('sitemap', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }
}
