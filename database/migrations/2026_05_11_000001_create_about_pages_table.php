<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();

            // Hero
            $table->string('hero_title_uz')->nullable();
            $table->string('hero_title_ru')->nullable();
            $table->string('hero_title_en')->nullable();
            $table->text('hero_subtitle_uz')->nullable();
            $table->text('hero_subtitle_ru')->nullable();
            $table->text('hero_subtitle_en')->nullable();
            $table->string('hero_image')->nullable();

            // Intro / About block
            $table->string('intro_title_uz')->nullable();
            $table->string('intro_title_ru')->nullable();
            $table->string('intro_title_en')->nullable();
            $table->longText('intro_description_uz')->nullable();
            $table->longText('intro_description_ru')->nullable();
            $table->longText('intro_description_en')->nullable();
            $table->string('intro_image')->nullable();

            // Mission
            $table->string('mission_title_uz')->nullable();
            $table->string('mission_title_ru')->nullable();
            $table->string('mission_title_en')->nullable();
            $table->text('mission_text_uz')->nullable();
            $table->text('mission_text_ru')->nullable();
            $table->text('mission_text_en')->nullable();

            // Vision
            $table->string('vision_title_uz')->nullable();
            $table->string('vision_title_ru')->nullable();
            $table->string('vision_title_en')->nullable();
            $table->text('vision_text_uz')->nullable();
            $table->text('vision_text_ru')->nullable();
            $table->text('vision_text_en')->nullable();

            // Goals
            $table->string('goals_title_uz')->nullable();
            $table->string('goals_title_ru')->nullable();
            $table->string('goals_title_en')->nullable();
            $table->json('goals_uz')->nullable();
            $table->json('goals_ru')->nullable();
            $table->json('goals_en')->nullable();

            // Quick stats shown on the page (array of {value, label_uz, label_ru, label_en, icon})
            $table->json('stats')->nullable();

            $table->boolean('show_team')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
