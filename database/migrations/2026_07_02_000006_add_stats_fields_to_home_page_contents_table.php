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
            $table->string('since_year')->nullable()->after('id');
            $table->string('events_count')->nullable()->after('since_year');
            $table->string('photos_count')->nullable()->after('events_count');
            $table->string('clients_count')->nullable()->after('photos_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_contents', function (Blueprint $table) {
            $table->dropColumn(['since_year', 'events_count', 'photos_count', 'clients_count']);
        });
    }
};