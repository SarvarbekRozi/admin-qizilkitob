<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('natural_resources', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_uz');
            $table->string('title_ru');
            $table->string('title_en');
            $table->text('excerpt_uz')->nullable();
            $table->text('excerpt_ru')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('content_uz')->nullable();
            $table->longText('content_ru')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->json('image_gallery')->nullable();
            $table->json('features_uz')->nullable();
            $table->json('features_ru')->nullable();
            $table->json('features_en')->nullable();
            $table->string('stat_area')->nullable();
            $table->string('stat_species')->nullable();
            $table->string('stat_protected')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('views_count')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('natural_resources');
    }
};
