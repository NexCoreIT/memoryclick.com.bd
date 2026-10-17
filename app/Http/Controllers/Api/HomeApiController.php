<?php

namespace App\Http\Controllers\Api;

use App\Models\BlogPost;
use App\Models\Cinematography;
use App\Models\HomePageContent;
use App\Models\OurService;
use App\Models\Package;
use App\Models\Photography;
use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class HomeApiController extends ApiController
{
    public function index(): JsonResponse
    {
        $settings = HomePageContent::first();

        // 1. Sliders
        $sliders = Slider::where('status', '1')
            ->orderBy('sort_number')
            ->get()
            ->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'title' => $slider->title,
                    'image' => $slider->image,
                    'image_url' => self::formatImageUrl($slider->image),
                    'sort_number' => $slider->sort_number,
                ];
            });

        // 2. Counters / About Teaser
        $stats = [
            'since_year' => $settings->since_year ?? '2014',
            'events_count' => $settings->events_count ?? '3000',
            'photos_count' => $settings->photos_count ?? '1000',
            'clients_count' => $settings->clients_count ?? '999',
            'about_title' => $settings->about_title ?? 'About MemoryClick',
            'about_content' => $settings->about_content ?? 'Premium wedding photography and cinematography company based in Bangladesh.',
        ];

        // 3. Top Services
        $services = OurService::where('status', '1')
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'title' => $service->title,
                    'slug' => $service->slug,
                    'description' => $service->description,
                    'image' => $service->image,
                    'image_url' => self::formatImageUrl($service->image),
                ];
            });

        // 4. Latest Packages
        $latestPackages = Package::with(['features', 'division', 'category'])
            ->active()
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($pkg) {
                $people = array_values(array_filter([
                    $pkg->chief,
                    $pkg->photographer,
                    $pkg->cinematographer,
                ]));

                return [
                    'id' => $pkg->id,
                    'package_name' => $pkg->package_name,
                    'slug' => $pkg->slug,
                    'price' => $pkg->price,
                    'team' => implode(' + ', $people),
                    'chief' => $pkg->chief,
                    'photographer' => $pkg->photographer,
                    'cinematographer' => $pkg->cinematographer,
                    'image' => $pkg->image,
                    'image_url' => self::formatImageUrl($pkg->image),
                    'description' => $pkg->description,
                    'division' => $pkg->division ? [
                        'id' => $pkg->division->id,
                        'name' => $pkg->division->name,
                        'slug' => $pkg->division->slug,
                    ] : null,
                    'category' => $pkg->category ? [
                        'id' => $pkg->category->id,
                        'name' => $pkg->category->name,
                        'slug' => $pkg->category->slug,
                    ] : null,
                    'features' => $pkg->features->map(function ($f) {
                        return [
                            'id' => $f->id,
                            'name' => $f->name,
                        ];
                    }),
                ];
            });

        // 5. Testimonials
        $testimonials = Testimonial::where('status', '1')
            ->orderByDesc('id')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'name' => $t->name,
                    'designation' => $t->designation,
                    'description' => $t->description,
                    'rating' => (int) $t->rating,
                    'image' => $t->image,
                    'image_url' => self::formatImageUrl($t->image),
                ];
            });

        // 6. Recent Work
        $recentWork = Photography::where('status', '1')
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($rw) {
                return [
                    'id' => $rw->id,
                    'title' => $rw->title,
                    'slug' => $rw->slug,
                    'client_name' => $rw->client_name,
                    'package_name' => $rw->package_name,
                    'image' => $rw->image,
                    'image_url' => self::formatImageUrl($rw->image),
                ];
            });

        // 7. Cinematography
        $cinematography = Cinematography::where('status', '1')
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'title' => $c->title,
                    'youtube_url' => $c->youtube_url,
                    'credit' => $c->credit,
                ];
            });

        // 8. Latest Blogs
        $latestBlogs = BlogPost::with('category')
            ->where('status', 1)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'short_description' => $blog->short_description ?: strip_tags($blog->description),
                    'author_name' => $blog->author_name ?? 'MemoryClick',
                    'created_at' => $blog->created_at ? $blog->created_at->format('M d, Y') : null,
                    'views' => (int) $blog->views,
                    'image' => $blog->image,
                    'image_url' => self::formatImageUrl($blog->image) ?: self::formatImageUrl('fav.png'),
                    'category' => $blog->category ? [
                        'id' => $blog->category->id,
                        'name' => $blog->category->name,
                        'slug' => $blog->category->slug,
                    ] : null,
                ];
            });

        // 9. Section Titles & Headings
        $sections = [
            'service_title' => $settings->service_title ?? 'Our Top Services',
            'service_subtitle' => $settings->service_subtitle ?? 'Our Services',
            'recent_work_title' => $settings->recent_work_title ?? 'Our recent stunning wedding photography',
            'recent_work_subtitle' => $settings->recent_work_subtitle ?? 'Recent Work',
            'cinematography_title' => $settings->cinematography_title ?? 'Take a peek at our recent stunning wedding photography',
            'cinematography_subtitle' => $settings->cinematography_subtitle ?? 'Cinematography',
            'reviews_title' => $settings->homepage_title ?? 'Client Reviews',
        ];

        // 10. Contact Info
        $contact = [
            'phone' => $settings->phone ?? '',
            'email' => $settings->email ?? '',
            'address' => $settings->address ?? '',
            'google_map' => $settings->google_map ?? '',
        ];

        return $this->successResponse([
            'sliders' => $sliders,
            'stats' => $stats,
            'services' => $services,
            'latest_packages' => $latestPackages,
            'testimonials' => $testimonials,
            'recent_work' => $recentWork,
            'cinematography' => $cinematography,
            'latest_blogs' => $latestBlogs,
            'sections' => $sections,
            'contact' => $contact,
        ]);
    }
}
