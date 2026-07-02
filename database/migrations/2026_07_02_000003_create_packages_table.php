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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('slug')->unique();
            $table->foreignId('division_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('package_categories')->cascadeOnDelete();
            $table->string('price');
            $table->string('chief')->nullable();
            $table->string('photographer')->nullable();
            $table->string('cinematographer')->nullable();
            $table->string('number_of_photos');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};