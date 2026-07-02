<?php

namespace Database\Seeders;

use App\Models\Cinematography;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CinematographySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Nadia & Rahim Wedding Highlights',
                'youtube_url' => 'https://www.facebook.com/watch/?v=example1',
                'credit' => 'Memory Click Team',
                'status' => 1,
            ],
            [
                'title' => 'Sara & Hasan Cinematic Wedding',
                'youtube_url' => 'https://www.facebook.com/watch/?v=example2',
                'credit' => 'Memory Click Team',
                'status' => 1,
            ],
            [
                'title' => 'Farzana & Kabir Reception Video',
                'youtube_url' => 'https://www.facebook.com/watch/?v=example3',
                'credit' => 'Memory Click Team',
                'status' => 1,
            ],
        ];

        foreach ($videos as $video) {
            Cinematography::create([
                'title' => $video['title'],
                'slug' => Str::slug($video['title']),
                'youtube_url' => $video['youtube_url'],
                'credit' => $video['credit'],
                'status' => $video['status'],
            ]);
        }
    }
}