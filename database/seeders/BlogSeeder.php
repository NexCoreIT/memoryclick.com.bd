<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Photography Tips',
            'Wedding Stories',
            'Cinematography Insights',
            'Event Coverage',
        ];

        $catModels = [];
        foreach ($categories as $catName) {
            $catModels[$catName] = BlogCategory::firstOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName, 'status' => 1]
            );
        }

        $posts = [
            [
                'title' => 'Top 10 Essential Wedding Photography Tips for Bangladeshi Brides & Grooms',
                'category' => 'Wedding Stories',
                'author_name' => 'MemoryClick Studio',
                'short_description' => 'Planning your dream wedding in Bangladesh? Discover essential tips to get the most breathtaking wedding photos and capture every timeless emotion.',
                'description' => '<p>Your wedding day is one of the most significant chapters of your life. In Bangladeshi traditions, weddings are vibrant celebrations filled with vivid colors, emotional moments, and grand rituals ranging from Holud to Reception.</p><h4>1. Plan the Lighting and Venue Timing</h4><p>Proper lighting is essential for magical portraits. Coordinate with your photography team so that signature couple shots are scheduled during the golden hour right before sunset.</p><h4>2. Share Your Concept & Family Preferences</h4><p>Communicating with your lead photographer before the event ensures every important family member and candid ritual is captured effortlessly.</p><p>MemoryClick specializes in blending modern candid storytelling with timeless traditional portraits to keep your memories vivid forever.</p>',
                'views' => 420,
                'is_featured' => 1,
            ],
            [
                'title' => 'How Cinematic Videography Elevates Your Event Experience',
                'category' => 'Cinematography Insights',
                'author_name' => 'MemoryClick Studio',
                'short_description' => 'Beyond standard videos, cinematic films tell a story. Learn how professional camera work, color grading, and drone shots bring your events to life.',
                'description' => '<p>Cinematography is more than recording clips—it is the art of emotional storytelling through movement, composition, sound design, and color grading.</p><p>Using cinema-grade 4K equipment, slow-motion sequences, and stabilized gimbal shots, MemoryClick creates cinematic highlight reels that feel like a feature film.</p>',
                'views' => 285,
                'is_featured' => 1,
            ],
            [
                'title' => 'Mastering Outdoor Portrait Lighting: Golden Hour Secrets',
                'category' => 'Photography Tips',
                'author_name' => 'MemoryClick Team',
                'short_description' => 'Golden hour offers soft, warm, and dreamy lighting. Here is how professional photographers harness natural light for stunning outdoor portraits.',
                'description' => '<p>Outdoor portraiture relies heavily on understanding how light interacts with skin tones and surroundings. Golden hour—the hour right after sunrise and right before sunset—provides naturally diffused light that eliminates harsh shadows.</p><p>By positioning the sun behind your subject, you create a romantic rim-light effect while filling shadows with a subtle reflector or warm fill light.</p>',
                'views' => 310,
                'is_featured' => 0,
            ],
            [
                'title' => 'Behind The Scenes: Capturing Corporate Galas and Grand Expos',
                'category' => 'Event Coverage',
                'author_name' => 'MemoryClick Team',
                'short_description' => 'Corporate event coverage requires precision, speed, and subtle positioning. Take a glimpse behind the camera at how we document major corporate functions.',
                'description' => '<p>Corporate expos and brand launch events require dynamic coverage that highlights key speakers, guest interactions, branding banners, and crowd engagement without disrupting the flow of the program.</p><p>Our specialized event photography team works seamlessly in high-speed environments to deliver high-resolution press-ready photos and quick social media cuts.</p>',
                'views' => 195,
                'is_featured' => 0,
            ],
        ];

        foreach ($posts as $item) {
            $catId = isset($catModels[$item['category']]) ? $catModels[$item['category']]->id : null;

            BlogPost::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'category_id' => $catId,
                    'title' => $item['title'],
                    'author_name' => $item['author_name'] ?? 'MemoryClick Studio',
                    'short_description' => $item['short_description'],
                    'description' => $item['description'],
                    'views' => $item['views'] ?? 100,
                    'is_featured' => $item['is_featured'] ?? 0,
                    'status' => 1,
                ]
            );
        }
    }
}
