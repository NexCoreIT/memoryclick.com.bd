<?php

namespace Database\Seeders;

use App\Models\Photography;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhotographySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photographies = [
            [
                'title' => 'Elegant Wedding Ceremony',
                'package_name' => 'Premium Package',
                'image' => 'frontend/images/work-1.jpg',
                'client_name' => 'Nadia & Rahim',
                'status' => 1,
                'category_id' => 1,
            ],
            [
                'title' => 'Traditional Bengali Wedding',
                'package_name' => 'Standard Package',
                'image' => 'frontend/images/work-2.jpg',
                'client_name' => 'Sara & Hasan',
                'status' => 1,
                'category_id' => 1,
            ],
            [
                'title' => 'Royal Reception Event',
                'package_name' => 'Premium Package',
                'image' => 'frontend/images/work-3.jpg',
                'client_name' => 'Farzana & Kabir',
                'status' => 1,
                'category_id' => 1,
            ],
            [
                'title' => 'Garden Pre-Wedding Shoot',
                'package_name' => 'Deluxe Package',
                'image' => 'frontend/images/work-4.jpg',
                'client_name' => 'Tania & Shakib',
                'status' => 1,
                'category_id' => 1,
            ],
        ];

        foreach ($photographies as $photo) {
            Photography::create([
                'title' => $photo['title'],
                'slug' => Str::slug($photo['title']),
                'package_name' => $photo['package_name'],
                'image' => $photo['image'],
                'client_name' => $photo['client_name'],
                'status' => $photo['status'],
                'category_id' => $photo['category_id'],
            ]);
        }
    }
}