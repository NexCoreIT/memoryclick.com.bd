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
            $table->tinyInteger('ssl_status')->default(1)->after('cinematography_title')->comment('1=On, 0=Off');
            $table->tinyInteger('ssl_sandbox')->default(1)->after('ssl_status')->comment('1=Sandbox, 0=Live');
            $table->string('ssl_store_id')->nullable()->after('ssl_sandbox');
            $table->string('ssl_store_password')->nullable()->after('ssl_store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_contents', function (Blueprint $table) {
            $table->dropColumn(['ssl_status', 'ssl_sandbox', 'ssl_store_id', 'ssl_store_password']);
        });
    }
};
