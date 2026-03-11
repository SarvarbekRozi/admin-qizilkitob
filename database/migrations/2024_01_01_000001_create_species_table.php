<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->enum('category', ['animal', 'plant']);
            $table->enum('danger_level', ['critically_endangered', 'endangered', 'vulnerable', 'near_threatened']);
            $table->string('name_uz');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('scientific_name');
            $table->text('description_short_uz')->nullable();
            $table->text('description_short_ru')->nullable();
            $table->text('description_short_en')->nullable();
            $table->longText('description_full_uz')->nullable();
            $table->longText('description_full_ru')->nullable();
            $table->longText('description_full_en')->nullable();
            $table->json('description_bullets_uz')->nullable();
            $table->json('description_bullets_ru')->nullable();
            $table->json('description_bullets_en')->nullable();
            $table->string('image_main')->nullable();
            $table->json('image_gallery')->nullable();
            // Stats
            $table->string('stat_mass')->nullable();
            $table->string('stat_speed')->nullable();
            $table->string('stat_lifespan')->nullable();
            $table->string('stat_diet')->nullable();
            $table->string('stat_height')->nullable();
            $table->string('stat_bloom_period')->nullable();
            $table->string('stat_habitat')->nullable();
            // Habitat
            $table->string('habitat_location_uz')->nullable();
            $table->string('habitat_location_ru')->nullable();
            $table->string('habitat_location_en')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            // Conservation
            $table->string('conservation_level')->nullable();
            $table->string('conservation_population')->nullable();
            $table->json('threats_uz')->nullable();
            $table->json('threats_ru')->nullable();
            $table->json('threats_en')->nullable();
            $table->json('related_species')->nullable();
            $table->integer('views_count')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
