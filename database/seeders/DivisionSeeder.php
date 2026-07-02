<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::create([
            'name' => 'Dhaka',
            'slug' => 'dhaka',
            'status' => 1,
        ]);

        Division::create([
            'name' => 'Chattogram',
            'slug' => 'chattogram',
            'status' => 1,
        ]);
    }
}