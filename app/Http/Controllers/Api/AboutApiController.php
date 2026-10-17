<?php

namespace App\Http\Controllers\Api;

use App\Models\CustomPage;
use App\Models\Team;
use Illuminate\Http\JsonResponse;

class AboutApiController extends ApiController
{
    public function index(): JsonResponse
    {
        $page = CustomPage::where('slug', 'about-us')->first();
        $teams = Team::all()->map(function ($team) {
            return [
                'id' => $team->id,
                'name' => $team->name,
                'slug' => $team->slug,
                'designation' => $team->designation,
                'image' => $team->image,
                'image_url' => self::formatImageUrl($team->image),
            ];
        });

        $data = [
            'meta_title' => $page->meta_title ?? 'About Us | Memory Click',
            'meta_description' => $page->meta_description ?? 'Learn more about Memory Click - your trusted wedding photography partner in Bangladesh.',
            'meta_keywords' => $page->meta_keywords ?? 'memory click, about us, wedding photography',
            'ceo_name' => $page->ceo_name ?? 'Founder & CEO',
            'ceo_designation' => $page->ceo_designation ?? 'CEO',
            'ceo_image' => $page->ceo_image ?? null,
            'ceo_image_url' => self::formatImageUrl($page?->ceo_image) ?: self::formatImageUrl('default.jpg'),
            'ceo_body' => $page->body ?? 'Memory Click started with a vision to capture life\'s most beautiful moments.',
            'title_2' => $page->title_2 ?? 'About MemoryClick',
            'memoryclick_image' => $page->memoryclick_image ?? null,
            'memoryclick_image_url' => self::formatImageUrl($page?->memoryclick_image) ?: self::formatImageUrl('default.jpg'),
            'about_memoryclick' => $page->about_memoryclick ?? 'Memory Click started with a vision to capture life\'s most beautiful moments.',
            'teams' => $teams,
        ];

        return $this->successResponse($data);
    }
}
