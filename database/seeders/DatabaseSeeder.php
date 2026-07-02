<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\FaqSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\HomePageContentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        // Call the CustomPageSeeder
        $this->call(CustomPageSeeder::class);

        $this->call(PermissionSeeder::class);

        $this->call(CategorySeeder::class);

        $this->call(PackageCategorySeeder::class);

        $this->call(HomePageContentSeeder::class);

        $this->call(DivisionSeeder::class);

        $this->call(OurServiceSeeder::class);

        $this->call(TestimonialSeeder::class);

        $this->call(PhotographySeeder::class);

        $this->call(CinematographySeeder::class);

        $this->call(PackageSeeder::class);

    }
}
