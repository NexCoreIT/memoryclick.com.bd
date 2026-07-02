<?php

namespace Database\Seeders;

use App\Models\CustomPage;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomPage::create([
            'title' => 'About Us',
            'slug' => Str::slug('About Us'),
            'meta_title' => 'About Us | Memory Click',
            'meta_description' => 'Learn more about Memory Click - your trusted wedding photography and cinematography partner in Bangladesh.',
            'meta_keywords' => 'memory click, about us, wedding photography, cinematography, Bangladesh',
            'status' => 1,
            'title_1' => 'About Our CEO',
            'title_2' => 'About MemoryClick',
            'ceo_name' => 'John Doe',
            'ceo_designation' => 'Founder & CEO',
            'about_memoryclick' => 'Memory Click started with a vision to capture life\'s most beautiful moments. We have grown into a trusted name in wedding photography and cinematography across Bangladesh. Our team of passionate photographers and cinematographers work tirelessly to deliver stunning visuals that tell your unique story.',
            'body' => '
                <h2>Welcome to Memory Click</h2>
                <p>At <strong>Memory Click</strong>, we specialize in capturing your most precious moments with professional wedding photography and cinematography services. Based in Bangladesh, we are passionate about turning your special day into timeless memories.</p>

                <h3>Why Choose Us?</h3>
                <ul>
                    <li>Professional wedding photography and cinematography.</li>
                    <li>Experienced team with creative vision.</li>
                    <li>High-quality editing and delivery.</li>
                    <li>Affordable packages tailored to your needs.</li>
                </ul>

                <h3>Our Mission</h3>
                <p>We aim to preserve your beautiful moments with artistic excellence and professional service, ensuring every click tells a story.</p>

                <p>Contact us today to book your session!</p>
            ',
        ]);
    }
}