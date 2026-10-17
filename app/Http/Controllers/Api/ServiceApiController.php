<?php

namespace App\Http\Controllers\Api;

use App\Models\OurService;
use Illuminate\Http\JsonResponse;

class ServiceApiController extends ApiController
{
    public function index(): JsonResponse
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
                    'image_url' => self::formatImageUrl($service->image),
                ];
            });

        return $this->successResponse($services);
    }

    public function show(string $slug): JsonResponse
    {
        $service = OurService::where('slug', $slug)->first();

        if (!$service) {
            return $this->errorResponse('Service not found', 404);
        }

        return $this->successResponse([
            'id' => $service->id,
            'title' => $service->title,
            'slug' => $service->slug,
            'description' => $service->description,
            'image' => $service->image,
            'image_url' => self::formatImageUrl($service->image),
        ]);
    }
}
