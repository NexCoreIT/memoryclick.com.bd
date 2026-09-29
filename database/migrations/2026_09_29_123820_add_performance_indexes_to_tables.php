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
        Schema::table('photographies', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('divisions', function (Blueprint $table) {
            $table->index('slug');
            $table->index('status');
        });

        Schema::table('custom_pages', function (Blueprint $table) {
            $table->index('slug');
            $table->index('status');
        });

        Schema::table('image_galleries', function (Blueprint $table) {
            $table->index('product_id');
        });

        Schema::table('cinematographies', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('package_categories', function (Blueprint $table) {
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photographies', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('divisions', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['status']);
        });

        Schema::table('custom_pages', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['status']);
        });

        Schema::table('image_galleries', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
        });

        Schema::table('cinematographies', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('package_categories', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
