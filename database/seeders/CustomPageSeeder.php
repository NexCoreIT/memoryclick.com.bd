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

        CustomPage::create([
            'title' => 'Terms and Condition',
            'slug' => Str::slug('Terms and Condition'),
            'meta_title' => 'Terms and Condition | Memory Click',
            'meta_description' => 'Read our terms and conditions for using Memory Click services.',
            'meta_keywords' => 'terms, conditions, memory click, policy',
            'status' => 1,
            'body' => '
                <h2>Terms and Conditions</h2>
                <p>Welcome to Memory Click. By using our services, you agree to the following terms and conditions.</p>

                <h3>Booking and Payment</h3>
                <p>A advance payment is required to confirm your booking. The remaining balance must be paid before or on the event day as per the agreed schedule.</p>

                <h3>Cancellation Policy</h3>
                <p>If you cancel your booking within 7 days of the event, the advance payment will not be refunded. Cancellations made more than 7 days in advance may be eligible for a partial refund.</p>

                <h3>Delivery</h3>
                <p>Edited photos and videos will be delivered within the timeframe specified in your package. Delivery times may vary depending on the scope of work.</p>

                <h3>Usage Rights</h3>
                <p>Memory Click retains the right to use your photos and videos for portfolio and promotional purposes unless otherwise agreed in writing.</p>

                <p>For any questions, please contact us.</p>
            ',
        ]);
    }
}