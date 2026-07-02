<?php

namespace Database\Seeders;

use App\Models\OurService;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OurServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Wedding Photography',
                'image' => 'frontend/images/service-1.jpg',
                'description' => 'Capture every precious moment of your special day with our professional wedding photography services. From candid shots to posed portraits, we ensure timeless memories.',
                'status' => 1,
            ],
            [
                'title' => 'Cinematography',
                'image' => 'frontend/images/service-2.jpg',
                'description' => 'Professional wedding cinematography that tells your love story in motion. High-quality video coverage with cinematic editing.',
                'status' => 1,
            ],
            [
                'title' => 'Pre-Wedding Shoot',
                'image' => 'frontend/images/service-3.jpg',
                'description' => 'Beautiful pre-wedding photoshoots at stunning locations. Creative concepts and professional editing to make your love story shine.',
                'status' => 1,
            ],
            [
                'title' => 'Event Photography',
                'image' => 'frontend/images/service-4.jpg',
                'description' => 'Comprehensive event photography coverage for birthdays, anniversaries, corporate events, and all special occasions.',
                'status' => 1,
            ],
        ];

        foreach ($services as $service) {
            OurService::create([
                'title' => $service['title'],
                'slug' => Str::slug($service['title']),
                'image' => $service['image'],
                'description' => $service['description'],
                'status' => $service['status'],
            ]);
        }
    }
}