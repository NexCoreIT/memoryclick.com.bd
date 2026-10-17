<?php

namespace App\Http\Controllers\Api;

use App\Models\Division;
use App\Models\HomePageContent;
use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Http\JsonResponse;

class PackageApiController extends ApiController
{
    /**
     * Get all active divisions for the package overview page.
     */
    public function divisions(): JsonResponse
    {
        $divisions = Division::active()->latest()->get()->map(function ($div) {
            return [
                'id' => $div->id,
                'name' => $div->name,
                'slug' => $div->slug,
                'image' => $div->image,
                'image_url' => self::formatImageUrl($div->image),
                'packages_count' => $div->packages()->active()->count(),
            ];
        });

        return $this->successResponse($divisions);
    }

    /**
     * Get packages for a specific division, with category filters.
     */
    public function divisionPackages(string $slug): JsonResponse
    {
        $division = Division::where('slug', $slug)->first();

        if (!$division) {
            return $this->errorResponse('Division not found', 404);
        }

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
                    'chief' => $pkg->chief,
                    'photographer' => $pkg->photographer,
                    'cinematographer' => $pkg->cinematographer,
                    'image' => $pkg->image,
                    'image_url' => self::formatImageUrl($pkg->image),
                    'description' => $pkg->description,
                    'category_id' => $pkg->category_id,
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

        return $this->successResponse([
            'division' => [
                'id' => $division->id,
                'name' => $division->name,
                'slug' => $division->slug,
                'image_url' => self::formatImageUrl($division->image),
            ],
            'categories' => $categories,
            'packages' => $packages,
        ]);
    }

    /**
     * Get details for a single package (for modal and checkout).
     */
    public function show($id): JsonResponse
    {
        $package = Package::with(['features', 'division', 'category'])->find($id);

        if (!$package) {
            return $this->errorResponse('Package not found', 404);
        }

        $settings = HomePageContent::first();

        $people = array_values(array_filter([
            $package->chief,
            $package->photographer,
            $package->cinematographer,
        ]));

        $data = [
            'id' => $package->id,
            'package_name' => $package->package_name,
            'slug' => $package->slug,
            'price' => (float) $package->price,
            'team' => implode(' + ', $people),
            'chief' => $package->chief,
            'photographer' => $package->photographer,
            'cinematographer' => $package->cinematographer,
            'image' => $package->image,
            'image_url' => self::formatImageUrl($package->image),
            'description' => $package->description,
            'division' => $package->division ? [
                'id' => $package->division->id,
                'name' => $package->division->name,
                'slug' => $package->division->slug,
            ] : null,
            'category' => $package->category ? [
                'id' => $package->category->id,
                'name' => $package->category->name,
                'slug' => $package->category->slug,
            ] : null,
            'features' => $package->features->map(function ($f) {
                return [
                    'id' => $f->id,
                    'name' => $f->name,
                ];
            }),
            'ssl_status' => (int) ($settings->ssl_status ?? 1),
            'whatsapp_phone' => $settings->phone ?? '',
            'outside_charge_notice' => 'Transportation + Accommodation & 15% shift charge (Package Price) will be added with package price.',
        ];

        return $this->successResponse($data);
    }
}
