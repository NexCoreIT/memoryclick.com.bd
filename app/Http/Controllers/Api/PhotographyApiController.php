<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Photography;
use Illuminate\Http\JsonResponse;

class PhotographyApiController extends ApiController
{
    public function index(): JsonResponse
    {
        $categories = Category::where('status', '1')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                ];
            });

        $photos = Photography::with('category')
            ->where('status', '1')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title ?? 'Photography',
                    'slug' => $item->slug,
                    'client_name' => $item->client_name,
                    'package_name' => $item->package_name,
                    'image' => $item->image,
                    'image_url' => self::formatImageUrl($item->image),
                    'category' => $item->category ? [
                        'id' => $item->category->id,
                        'name' => $item->category->name,
                        'slug' => $item->category->slug,
                    ] : null,
                ];
            });

        return $this->successResponse([
            'categories' => $categories,
            'items' => $photos,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $item = Photography::with('category')->where('slug', $slug)->first();

        if (!$item) {
            return $this->errorResponse('Photography item not found', 404);
        }

        // Decode gallery images
        $galleryImages = [];
        if (!empty($item->images)) {
            $decoded = is_string($item->images) ? json_decode($item->images, true) : $item->images;
            if (is_array($decoded)) {
                foreach ($decoded as $img) {
                    $galleryImages[] = [
                        'path' => $img,
                        'url' => self::formatImageUrl($img),
                    ];
                }
            }
        }

        return $this->successResponse([
            'id' => $item->id,
            'title' => $item->title ?? 'Photography',
            'slug' => $item->slug,
            'client_name' => $item->client_name,
            'package_name' => $item->package_name,
            'image' => $item->image,
            'image_url' => self::formatImageUrl($item->image),
            'gallery_images' => $galleryImages,
            'category' => $item->category ? [
                'id' => $item->category->id,
                'name' => $item->category->name,
                'slug' => $item->category->slug,
            ] : null,
        ]);
    }
}
