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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->string('target_audience')->nullable();
            $table->string('key_benefits')->nullable();
            $table->timestamps();
        });

        Schema::create('video_scripts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('script_content');
            $table->json('settings')->nullable(); // speed, font_size
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('message');
            $table->string('image_path')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();
        });

        Schema::create('affiliate_scripts', function (Blueprint $table) {
            $table->id();
            $table->string('product_link')->nullable();
            $table->string('platform');
            $table->text('benefits')->nullable();
            $table->string('tone')->nullable();
            $table->text('generated_script')->nullable();
            $table->timestamps();
        });

        Schema::create('ads_images', function (Blueprint $table) {
            $table->id();
            $table->string('headline')->nullable();
            $table->string('subheadline')->nullable();
            $table->string('cta')->nullable();
            $table->string('image_path')->nullable();
            $table->json('settings')->nullable(); // colors, etc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_images');
        Schema::dropIfExists('affiliate_scripts');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('video_scripts');
        Schema::dropIfExists('landing_pages');
    }
};
