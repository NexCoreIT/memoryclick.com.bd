<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HomePageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('home_page_contents')->insert([
            'since_year'       => '2014',
            'events_count'     => '3000',
            'photos_count'     => '1000',
            'clients_count'    => '999',
            'service_subtitle' => 'Our Services',
            'service_title'    => 'Our Top Services',
            'recent_work_subtitle' => 'Recent Work',
            'recent_work_title'    => 'Our recent stunning wedding photography',
            'cinematography_subtitle' => 'Cinematography',
            'cinematography_title'    => 'Take a peek at our recent stunning wedding photography',
            'homepage_title'   => 'What Our Clients Say',
            'homepage_content' => 'This is the main homepage content.',
            'about_title'      => 'Your Trusted Wedding Photography & Cinematography Partner',
            'about_content'    => 'At Memory Click, we specialize in capturing your most precious moments with professional wedding photography and cinematography services. Based in Bangladesh, we are passionate about turning your special day into timeless memories.',
            'home_btn'         => 'Learn More',
            'about_btn'        => 'Read More',
            'footer_title'     => 'Stay Connected',
            'footer_btn'       => 'Subscribe',
            'youtube_link'     => 'https://youtube.com/@memoryclick',
            'facebook_link'    => 'https://facebook.com/memoryclick',
            'linkedin_link'    => 'https://linkedin.com/company/memoryclick',
            'instagram_link'   => 'https://instagram.com/memoryclick',
            'twitter_link'     => 'https://twitter.com/memoryclick',
            'email'            => 'info@memoryclick.com.bd',
            'address'          => 'Uttara Sector 11, Road 12, House 04, Lift 05 (A6)',
            'google_map'       => '<iframe src="https://maps.google.com/maps?q=House+04,+Road+12,+Sector+11,+Uttara,+Dhaka,+Bangladesh&t=&z=16&ie=UTF8&iwloc=&output=embed" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'phone'            => '01711111111',
            'image'            => null,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
}