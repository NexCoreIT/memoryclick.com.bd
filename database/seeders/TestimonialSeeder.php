<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Nadia & Rahim',
                'designation' => 'Happy Couple',
                'image' => 'frontend/images/testimonial-1.jpg',
                'rating' => 5,
                'description' => 'Memory Click captured our wedding day perfectly! The photos are absolutely stunning and every moment was beautifully preserved. Highly recommended!',
                'status' => 1,
            ],
            [
                'name' => 'Sara & Hasan',
                'designation' => 'Happy Couple',
                'image' => 'frontend/images/testimonial-2.jpg',
                'rating' => 5,
                'description' => 'We are so grateful to the Memory Click team for their incredible work. The cinematography was cinematic quality and the photos took our breath away.',
                'status' => 1,
            ],
            [
                'name' => 'Farzana & Kabir',
                'designation' => 'Happy Couple',
                'image' => 'frontend/images/testimonial-3.jpg',
                'rating' => 4,
                'description' => 'Professional, creative, and extremely talented. They made us feel comfortable throughout the shoot and the results exceeded our expectations.',
                'status' => 1,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}