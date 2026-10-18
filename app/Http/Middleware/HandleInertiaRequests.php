<?php

namespace App\Http\Middleware;

use App\Models\HomePageContent;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $settings = HomePageContent::first();
        $logoUrl = $settings && $settings->image ? asset($settings->image) : asset('fav.png');

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],
            'settings' => $settings ? [
                'site_title' => $settings->meta_title ?? 'Memory Click',
                'meta_title' => $settings->meta_title ?? 'Memory Click | Best Wedding Photographer in Bangladesh',
                'meta_description' => $settings->meta_description ?? 'Premium wedding photography and cinematography company based in Bangladesh',
                'meta_keywords' => $settings->meta_keywords ?? 'wedding photography, cinematography, bridal shoot, memory click',
                'meta_image_url' => $logoUrl,
                'logo_url' => $logoUrl,
                'phone' => $settings->phone ?? '',
                'email' => $settings->email ?? '',
                'address' => $settings->address ?? '',
                'google_map' => $settings->google_map ?? '',
                'footer_title' => $settings->footer_title ?? 'MemoryClick.com.bd',
                'facebook_link' => $settings->facebook_link ?? '#',
                'youtube_link' => $settings->youtube_link ?? '#',
                'instagram_link' => $settings->instagram_link ?? '#',
                'ssl_status' => (int) ($settings->ssl_status ?? 1),
                'google_search_console_code' => $settings->google_search_console_code ?? '',
                'google_analytics_id' => $settings->google_analytics_id ?? '',
                'google_analytics_code' => $settings->google_analytics_code ?? '',
                'google_pixel_id' => $settings->google_pixel_id ?? '',
                'google_pixel_code' => $settings->google_pixel_code ?? '',
                'custom_head_code' => $settings->custom_head_code ?? '',
                'custom_body_code' => $settings->custom_body_code ?? '',
            ] : null,
        ];
    }
}
