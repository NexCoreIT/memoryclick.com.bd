<?php

namespace App\Http\Controllers\Api;

use App\Models\CustomPage;
use Illuminate\Http\JsonResponse;

class CustomPageApiController extends ApiController
{
    public function show(string $slug): JsonResponse
    {
        $page = CustomPage::where('slug', $slug)->first();

        if (!$page) {
            $formattedTitle = ucwords(str_replace('-', ' ', $slug));
            return $this->successResponse([
                'id' => null,
                'title' => $formattedTitle,
                'slug' => $slug,
                'body' => '<div class="text-center py-5"><h2>' . htmlspecialchars($formattedTitle) . '</h2><p class="mb-0 text-muted">Content coming soon.</p></div>',
                'meta_title' => $formattedTitle . ' | Memory Click',
                'meta_description' => 'Memory Click - ' . $formattedTitle,
                'meta_keywords' => 'memory click, ' . strtolower($formattedTitle),
            ]);
        }

        return $this->successResponse([
            'id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
            'body' => $page->body,
            'meta_title' => $page->meta_title ?? $page->title,
            'meta_description' => $page->meta_description,
            'meta_keywords' => $page->meta_keywords,
        ]);
    }
}
