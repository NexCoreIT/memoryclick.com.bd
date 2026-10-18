<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Cinematography;
use App\Models\Contact;
use App\Models\CustomPage;
use App\Models\Division;
use App\Models\HomePageContent;
use App\Models\OurService;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Photography;
use App\Models\Slider;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use App\Rules\PasswordCheckRule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Helper to ensure valid image URLs
     */
    private function formatImageUrl(?string $path): string
    {
        if (empty($path)) {
            return asset('fav.png');
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return $path;
        }
        return asset(ltrim($path, '/'));
    }

    /**
     * Homepage
     */
    public function index()
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
                    'image_url' => $this->formatImageUrl($slider->image),
                    'sort_number' => $slider->sort_number,
                ];
            });

        // 2. Stats
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
                    'image_url' => $this->formatImageUrl($service->image),
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
                    'image' => $pkg->image,
                    'image_url' => $this->formatImageUrl($pkg->image),
                    'description' => $pkg->description,
                    'category_id' => $pkg->category_id,
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
                    'rating' => (int) ($t->rating ?? 5),
                    'image' => $t->image,
                    'image_url' => $this->formatImageUrl($t->image),
                ];
            });

        // 6. Recent Work
        $recentWork = Photography::where('status', '1')
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($photo) {
                return [
                    'id' => $photo->id,
                    'title' => $photo->title,
                    'slug' => $photo->slug,
                    'client_name' => $photo->client_name,
                    'package_name' => $photo->package_name,
                    'image' => $photo->image,
                    'image_url' => $this->formatImageUrl($photo->image),
                ];
            });

        // 7. Cinematography
        $cinematography = Cinematography::where('status', '1')
            ->get()
            ->map(function ($cinema) {
                return [
                    'id' => $cinema->id,
                    'title' => $cinema->title,
                    'youtube_url' => $cinema->youtube_url,
                    'credit' => $cinema->credit,
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
                    'short_description' => $blog->short_description,
                    'author_name' => $blog->author_name ?? 'MemoryClick',
                    'created_at' => $blog->created_at ? $blog->created_at->format('M d, Y') : null,
                    'views' => $blog->views ?? 0,
                    'image' => $blog->image,
                    'image_url' => $this->formatImageUrl($blog->image),
                    'category' => $blog->category ? [
                        'id' => $blog->category->id,
                        'name' => $blog->category->name,
                        'slug' => $blog->category->slug,
                    ] : null,
                ];
            });

        $sections = [
            'service_title' => $settings->service_title ?? 'Our Top Services',
            'service_subtitle' => $settings->service_subtitle ?? 'Our Services',
            'recent_work_title' => $settings->recent_work_title ?? 'Our recent stunning wedding photography',
            'recent_work_subtitle' => $settings->recent_work_subtitle ?? 'Recent Work',
            'cinematography_title' => $settings->cinematography_title ?? 'Take a peek at our recent stunning wedding cinematography',
            'cinematography_subtitle' => $settings->cinematography_subtitle ?? 'Cinematography',
            'reviews_title' => $settings->reviews_title ?? 'Client Reviews',
        ];

        $contact = [
            'phone' => $settings->phone ?? '',
            'email' => $settings->email ?? '',
            'address' => $settings->address ?? '',
            'google_map' => $settings->google_map ?? '',
        ];

        return Inertia::render('Home', [
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

    /**
     * Photography Listing
     */
    public function photography()
    {
        $categories = Category::where('status', '1')->get()->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
            ];
        });

        $items = Photography::with('category')->where('status', '1')->latest()->get()->map(function ($photo) {
            return [
                'id' => $photo->id,
                'title' => $photo->title,
                'slug' => $photo->slug,
                'client_name' => $photo->client_name,
                'package_name' => $photo->package_name,
                'image' => $photo->image,
                'image_url' => $this->formatImageUrl($photo->image),
                'category' => $photo->category ? [
                    'id' => $photo->category->id,
                    'name' => $photo->category->name,
                    'slug' => $photo->category->slug,
                ] : null,
            ];
        });

        return Inertia::render('Photography/Index', [
            'categories' => $categories,
            'items' => $items,
        ]);
    }

    /**
     * Photography Details
     */
    public function photographyDetails($slug)
    {
        $photo = Photography::with('category')->where('slug', $slug)->firstOrFail();

        $galleryImages = [];
        if (!empty($photo->gallery_images)) {
            $rawImages = is_string($photo->gallery_images) ? json_decode($photo->gallery_images, true) : $photo->gallery_images;
            if (is_array($rawImages)) {
                foreach ($rawImages as $img) {
                    $imgPath = is_array($img) ? ($img['path'] ?? ($img['image'] ?? '')) : $img;
                    if ($imgPath) {
                        $galleryImages[] = [
                            'path' => $imgPath,
                            'url' => $this->formatImageUrl($imgPath),
                        ];
                    }
                }
            }
        }

        return Inertia::render('Photography/Details', [
            'id' => $photo->id,
            'title' => $photo->title,
            'slug' => $photo->slug,
            'client_name' => $photo->client_name,
            'package_name' => $photo->package_name,
            'image' => $photo->image,
            'image_url' => $this->formatImageUrl($photo->image),
            'gallery_images' => $galleryImages,
            'category' => $photo->category ? [
                'id' => $photo->category->id,
                'name' => $photo->category->name,
                'slug' => $photo->category->slug,
            ] : null,
        ]);
    }

    /**
     * Cinematography Listing
     */
    public function cinematography()
    {
        $videos = Cinematography::where('status', '1')->latest()->get()->map(function ($cinema) {
            return [
                'id' => $cinema->id,
                'title' => $cinema->title,
                'youtube_url' => $cinema->youtube_url,
                'credit' => $cinema->credit,
            ];
        });

        return Inertia::render('Cinematography', [
            'videos' => $videos,
        ]);
    }

    /**
     * Contact Page
     */
    public function contactUs()
    {
        $settings = HomePageContent::first();
        $contact = [
            'phone' => $settings->phone ?? '',
            'email' => $settings->email ?? '',
            'address' => $settings->address ?? '',
            'google_map' => $settings->google_map ?? '',
        ];

        return Inertia::render('Contact', [
            'contact' => $contact,
        ]);
    }

    /**
     * Store Contact Message
     */
    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    /**
     * About Page
     */
    public function about()
    {
        $customPage = CustomPage::where('slug', 'about-us')->first();
        $settings = HomePageContent::first();

        $teams = Team::latest()->get()->map(function ($team) {
            return [
                'id' => $team->id,
                'name' => $team->name,
                'designation' => $team->designation,
                'image' => $team->image,
                'image_url' => $this->formatImageUrl($team->image),
            ];
        });

        return Inertia::render('About', [
            'meta_title' => $customPage->meta_title ?? 'About Us | Memory Click',
            'meta_description' => $customPage->meta_description ?? '',
            'meta_keywords' => $customPage->meta_keywords ?? '',
            'ceo_name' => $settings->ceo_name ?? 'Founder & CEO',
            'ceo_designation' => $settings->ceo_designation ?? 'CEO',
            'ceo_image_url' => $this->formatImageUrl($settings->ceo_image ?? null),
            'ceo_body' => $settings->ceo_body ?? ($customPage->body ?? ''),
            'title_2' => $settings->title_2 ?? 'About MemoryClick',
            'memoryclick_image_url' => $this->formatImageUrl($settings->memoryclick_image ?? null),
            'about_memoryclick' => $settings->about_memoryclick ?? ($customPage->body ?? ''),
            'teams' => $teams,
        ]);
    }

    /**
     * All Services
     */
    public function topService()
    {
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
                    'image_url' => $this->formatImageUrl($service->image),
                ];
            });

        return Inertia::render('Services/Index', [
            'services' => $services,
        ]);
    }

    /**
     * Service Details
     */
    public function topServiceDetails($slug)
    {
        $service = OurService::where('slug', $slug)->firstOrFail();

        return Inertia::render('Services/Details', [
            'service' => [
                'id' => $service->id,
                'title' => $service->title,
                'slug' => $service->slug,
                'description' => $service->description,
                'image' => $service->image,
                'image_url' => $this->formatImageUrl($service->image),
            ],
        ]);
    }

    /**
     * Packages Divisions Listing
     */
    public function package()
    {
        $divisions = Division::active()->withCount('packages')->latest()->get()->map(function ($div) {
            return [
                'id' => $div->id,
                'name' => $div->name,
                'slug' => $div->slug,
                'image' => $div->image,
                'image_url' => $this->formatImageUrl($div->image),
                'packages_count' => $div->packages_count,
            ];
        });

        return Inertia::render('Package/Index', [
            'divisions' => $divisions,
        ]);
    }

    /**
     * Division Wise Packages
     */
    public function divisionPackage($slug)
    {
        $division = Division::where('slug', $slug)->firstOrFail();

        $categories = PackageCategory::active()->latest()->get()->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
            ];
        });

        $packages = Package::with(['features', 'division', 'category'])
            ->active()
            ->where('division_id', $division->id)
            ->latest()
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
                    'image' => $pkg->image,
                    'image_url' => $this->formatImageUrl($pkg->image),
                    'description' => $pkg->description,
                    'category_id' => $pkg->category_id,
                    'features' => $pkg->features->map(function ($f) {
                        return [
                            'id' => $f->id,
                            'name' => $f->name,
                        ];
                    }),
                ];
            });

        return Inertia::render('Package/Division', [
            'division' => [
                'id' => $division->id,
                'name' => $division->name,
                'slug' => $division->slug,
                'image_url' => $this->formatImageUrl($division->image),
            ],
            'categories' => $categories,
            'packages' => $packages,
        ]);
    }

    /**
     * Checkout
     */
    public function checkout(Request $request)
    {
        $packageId = $request->get('package_id');
        $package = null;

        if ($packageId) {
            $pkg = Package::with(['features', 'division', 'category'])->find($packageId);
            if ($pkg) {
                $people = array_values(array_filter([
                    $pkg->chief,
                    $pkg->photographer,
                    $pkg->cinematographer,
                ]));

                $package = [
                    'id' => $pkg->id,
                    'package_name' => $pkg->package_name,
                    'slug' => $pkg->slug,
                    'price' => $pkg->price,
                    'team' => implode(' + ', $people),
                    'image' => $pkg->image,
                    'image_url' => $this->formatImageUrl($pkg->image),
                    'description' => $pkg->description,
                    'ssl_status' => (int) ($pkg->ssl_status ?? 1),
                    'features' => $pkg->features->map(function ($f) {
                        return [
                            'id' => $f->id,
                            'name' => $f->name,
                        ];
                    }),
                ];
            }
        }

        return Inertia::render('Checkout', [
            'packageItem' => $package,
        ]);
    }

    /**
     * Terms and Condition
     */
    public function term()
    {
        $page = CustomPage::where('slug', 'terms-and-condition')->first();

        return Inertia::render('TermAndConditions', [
            'page' => $page ? [
                'title' => $page->title,
                'body' => $page->body,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'meta_keywords' => $page->meta_keywords,
            ] : null,
        ]);
    }

    public function changeProfile()
    {
        return view('frontend.user_dashboard.change-profile');
    }

    public function changePassword()
    {
        return view('frontend.user_dashboard.change-password');
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'old_password' => ['required', new PasswordCheckRule],
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];

        $messages = [
            'old_password.required' => 'Old password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 6 characters.',
            'confirm_password.required' => 'Confirm password is required.',
            'confirm_password.same' => 'The new password and confirm password must match.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $userUpdate = User::find($id);

        $userUpdate->update([
            "password" => bcrypt($request->password),
        ]);

        if ($request->filled('new_password')) {
            $userUpdate->update([
                'password' => bcrypt($validatedData['new_password']),
            ]);
        }
        return redirect()->back()->withSuccess('Password Update Success');
    }

    public function customerUpdate(Request $request, string $id)
    {
        $userUpdate = User::find($id);

        $imageName = auth()->user()->image;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('uploads', $imageName, 'public');
        }

        $userUpdate->update([
            "email" => $request->email,
            "phone" => $request->phone,
            "name" => $request->name,
            "role" => 'customer',
            "image" => $imageName,
        ]);

        return redirect()->back()->withSuccess('Profile Update Success');
    }
}
