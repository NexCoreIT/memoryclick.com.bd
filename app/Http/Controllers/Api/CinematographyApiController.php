<?php

namespace App\Http\Controllers\Api;

use App\Models\Cinematography;
use Illuminate\Http\JsonResponse;

class CinematographyApiController extends ApiController
{
    public function index(): JsonResponse
    {
        $items = Cinematography::where('status', '1')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'youtube_url' => $item->youtube_url,
                    'credit' => $item->credit,
                ];
            });

        return $this->successResponse($items);
    }
}
