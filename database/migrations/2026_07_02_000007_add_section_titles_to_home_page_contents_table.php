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
        Schema::table('home_page_contents', function (Blueprint $table) {
            $table->string('service_subtitle')->nullable()->after('clients_count');
            $table->string('service_title')->nullable()->after('service_subtitle');
            $table->string('recent_work_subtitle')->nullable()->after('service_title');
            $table->string('recent_work_title')->nullable()->after('recent_work_subtitle');
            $table->string('cinematography_subtitle')->nullable()->after('recent_work_title');
            $table->string('cinematography_title')->nullable()->after('cinematography_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_contents', function (Blueprint $table) {
            $table->dropColumn([
                'service_subtitle',
                'service_title',
                'recent_work_subtitle',
                'recent_work_title',
                'cinematography_subtitle',
                'cinematography_title',
            ]);
        });
    }
};