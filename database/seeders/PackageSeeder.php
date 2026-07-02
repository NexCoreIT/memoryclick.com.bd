<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageFeature;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'package_name'    => 'Starter Wedding Package',
                'division_id'     => 1, // Dhaka
                'category_id'     => 1,
                'price'           => '25000',
                'chief'           => '1',
                'photographer'    => '1',
                'cinematographer' => '0',
                'number_of_photos'=> '200',
                'description'     => 'Perfect for intimate wedding ceremonies. Includes a professional photographer to capture your special moments.',
                'status'          => 1,
                'image'           => 'uploads/package-1.jpg',
                'features'        => [
                    'Professional photographer for 4 hours',
                    '200 edited digital photos',
                    'Online gallery access',
                    'Prints included',
                ],
            ],
            [
                'package_name'    => 'Standard Wedding Package',
                'division_id'     => 1, // Dhaka
                'category_id'     => 1,
                'price'           => '45000',
                'chief'           => '1',
                'photographer'    => '2',
                'cinematographer' => '1',
                'number_of_photos'=> '500',
                'description'     => 'Our most popular package. Covers full day wedding coverage with both photography and cinematography.',
                'status'          => 1,
                'image'           => 'uploads/package-2.jpg',
                'features'        => [
                    '2 professional photographers for 8 hours',
                    '1 cinematographer for 6 hours',
                    '500+ edited digital photos',
                    '3-5 minute wedding highlight video',
                    'Online gallery access',
                    'Prints and photo album',
                ],
            ],
            [
                'package_name'    => 'Premium Wedding Package',
                'division_id'     => 1, // Dhaka
                'category_id'     => 1,
                'price'           => '75000',
                'chief'           => '2',
                'photographer'    => '3',
                'cinematographer' => '2',
                'number_of_photos'=> '1000',
                'description'     => 'Ultimate wedding coverage with a full team of photographers and cinematographers. Every moment captured in stunning detail.',
                'status'          => 1,
                'image'           => 'uploads/package-3.jpg',
                'features'        => [
                    '3 professional photographers for full day',
                    '2 cinematographers for full day',
                    '1000+ edited digital photos',
                    'Full wedding cinematography (15-20 min)',
                    'Drone coverage',
                    'Premium photo album',
                    'Online gallery with print rights',
                ],
            ],
            [
                'package_name'    => 'Starter Wedding Package',
                'division_id'     => 2, // Chattogram
                'category_id'     => 1,
                'price'           => '22000',
                'chief'           => '1',
                'photographer'    => '1',
                'cinematographer' => '0',
                'number_of_photos'=> '200',
                'description'     => 'Perfect for intimate wedding ceremonies in Chattogram. Professional photography coverage.',
                'status'          => 1,
                'image'           => 'uploads/package-4.jpg',
                'features'        => [
                    'Professional photographer for 4 hours',
                    '200 edited digital photos',
                    'Online gallery access',
                    'Prints included',
                ],
            ],
            [
                'package_name'    => 'Standard Wedding Package',
                'division_id'     => 2, // Chattogram
                'category_id'     => 1,
                'price'           => '42000',
                'chief'           => '1',
                'photographer'    => '2',
                'cinematographer' => '1',
                'number_of_photos'=> '500',
                'description'     => 'Full day wedding coverage in Chattogram with photography and cinematography.',
                'status'          => 1,
                'image'           => 'uploads/package-5.jpg',
                'features'        => [
                    '2 professional photographers for 8 hours',
                    '1 cinematographer for 6 hours',
                    '500+ edited digital photos',
                    '3-5 minute wedding highlight video',
                    'Online gallery access',
                    'Prints and photo album',
                ],
            ],
            [
                'package_name'    => 'Premium Wedding Package',
                'division_id'     => 2, // Chattogram
                'category_id'     => 1,
                'price'           => '70000',
                'chief'           => '2',
                'photographer'    => '3',
                'cinematographer' => '2',
                'number_of_photos'=> '1000',
                'description'     => 'Premium wedding coverage in Chattogram with full team and drone coverage.',
                'status'          => 1,
                'image'           => 'uploads/package-6.jpg',
                'features'        => [
                    '3 professional photographers for full day',
                    '2 cinematographers for full day',
                    '1000+ edited digital photos',
                    'Full wedding cinematography (15-20 min)',
                    'Drone coverage',
                    'Premium photo album',
                    'Online gallery with print rights',
                ],
            ],
            [
                'package_name'    => 'Pre-Wedding Photoshoot',
                'division_id'     => 1, // Dhaka
                'category_id'     => 1,
                'price'           => '15000',
                'chief'           => '1',
                'photographer'    => '1',
                'cinematographer' => '0',
                'number_of_photos'=> '100',
                'description'     => 'Beautiful pre-wedding photoshoot at a location of your choice. Perfect for engagement announcements.',
                'status'          => 1,
                'image'           => 'uploads/package-7.jpg',
                'features'        => [
                    '1 photographer for 3 hours',
                    '100 edited digital photos',
                    '1 location shoot',
                    'Online gallery',
                ],
            ],
            [
                'package_name'    => 'Reception Coverage',
                'division_id'     => 1, // Dhaka
                'category_id'     => 1,
                'price'           => '30000',
                'chief'           => '1',
                'photographer'    => '2',
                'cinematographer' => '1',
                'number_of_photos'=> '400',
                'description'     => 'Focused coverage for your wedding reception. Includes photography and cinematography.',
                'status'          => 1,
                'image'           => 'uploads/package-8.jpg',
                'features'        => [
                    '2 photographers for 5 hours',
                    '1 cinematographer for 4 hours',
                    '400+ edited digital photos',
                    'Reception highlight video',
                    'Online gallery',
                ],
            ],
        ];

        foreach ($packages as $packageData) {
            $features = $packageData['features'];
            unset($packageData['features']);

            $packageData['slug'] = Str::slug($packageData['package_name'] . '-' . $packageData['division_id'] . '-' . uniqid());

            $package = Package::create($packageData);

            foreach ($features as $feature) {
                PackageFeature::create([
                    'package_id' => $package->id,
                    'name' => $feature,
                ]);
            }
        }
    }
}