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
        Schema::table('custom_pages', function (Blueprint $table) {
            $table->string('title_1')->nullable()->after('title');
            $table->string('title_2')->nullable()->after('title_1');
            $table->text('about_memoryclick')->nullable()->after('body');
            $table->string('ceo_name')->nullable()->after('about_memoryclick');
            $table->string('ceo_designation')->nullable()->after('ceo_name');
            $table->string('ceo_image')->nullable()->after('ceo_designation');
            $table->string('memoryclick_image')->nullable()->after('ceo_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_pages', function (Blueprint $table) {
            $table->dropColumn(['title_1', 'title_2', 'about_memoryclick', 'ceo_name', 'ceo_designation', 'ceo_image', 'memoryclick_image']);
        });
    }
};