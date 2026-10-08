<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('home_page_contents', 'google_pixel_id')) {
            Schema::table('home_page_contents', function (Blueprint $table) {
                $table->string('google_pixel_id')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('home_page_contents', 'google_pixel_id')) {
            Schema::table('home_page_contents', function (Blueprint $table) {
                $table->dropColumn('google_pixel_id');
            });
        }
    }
};
