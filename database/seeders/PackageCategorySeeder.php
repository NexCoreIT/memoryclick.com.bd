<?php

namespace Database\Seeders;

use App\Models\PackageCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Wedding Photography',
                'slug' => 'wedding-photography',
                'status' => 1,
            ],
            [
                'name' => 'Pre-Wedding Shoot',
                'slug' => 'pre-wedding-shoot',
                'status' => 1,
            ],
            [
                'name' => 'Event Coverage',
                'slug' => 'event-coverage',
                'status' => 1,
            ],
            [
                'name' => 'Cinematography',
                'slug' => 'cinematography',
                'status' => 1,
            ],
        ];

        foreach ($categories as $category) {
            PackageCategory::create($category);
        }
    }
}