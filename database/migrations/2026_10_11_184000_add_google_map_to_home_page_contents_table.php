<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('home_page_contents', 'google_map')) {
            Schema::table('home_page_contents', function (Blueprint $table) {
                $table->text('google_map')->nullable()->after('address');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('home_page_contents', 'google_map')) {
            Schema::table('home_page_contents', function (Blueprint $table) {
                $table->dropColumn('google_map');
            });
        }
    }
};
