<?php

namespace App\Http\Controllers\Api;

use App\Models\HomePageContent;
use Illuminate\Http\JsonResponse;

class SettingsApiController extends ApiController
{
    public function index(): JsonResponse
    {
        $settings = HomePageContent::first();

        if (!$settings) {
            return $this->errorResponse('Settings not found', 404);
        }

        $logoUrl = self::formatImageUrl($settings->image) ?: self::formatImageUrl('fav.png');
        $faviconUrl = self::formatImageUrl('fav.png');

        $data = [
            'site_title' => $settings->meta_title ?? 'Memory Click',
            'meta_title' => $settings->meta_title ?? 'Memory Click | Best Wedding Photographer in Bangladesh',
            'meta_description' => $settings->meta_description ?? 'Premium wedding photography and cinematography company based in Bangladesh',
            'meta_keywords' => $settings->meta_keywords ?? 'wedding photography, cinematography, bridal shoot, memory click',
            'meta_image_url' => $logoUrl,
            'logo_url' => $logoUrl,
            'favicon_url' => $faviconUrl,
            'phone' => $settings->phone ?? '',
            'email' => $settings->email ?? '',
            'address' => $settings->address ?? '',
            'google_map' => $settings->google_map ?? '',
            'footer_title' => $settings->footer_title ?? 'MemoryClick.com.bd',
            'facebook_link' => $settings->facebook_link ?? '#',
            'youtube_link' => $settings->youtube_link ?? '#',
            'instagram_link' => $settings->instagram_link ?? '#',
            'ssl_status' => (int) ($settings->ssl_status ?? 1),
            // Tracking & Scripts
            'google_search_console_code' => $settings->google_search_console_code ?? '',
            'google_analytics_id' => $settings->google_analytics_id ?? '',
            'google_analytics_code' => $settings->google_analytics_code ?? '',
            'google_pixel_id' => $settings->google_pixel_id ?? '',
            'google_pixel_code' => $settings->google_pixel_code ?? '',
            'custom_head_code' => $settings->custom_head_code ?? '',
            'custom_body_code' => $settings->custom_body_code ?? '',
        ];

        return $this->successResponse($data);
    }
}
