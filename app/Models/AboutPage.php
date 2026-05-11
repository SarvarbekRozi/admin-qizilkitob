<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'hero_title_uz', 'hero_title_ru', 'hero_title_en',
        'hero_subtitle_uz', 'hero_subtitle_ru', 'hero_subtitle_en',
        'hero_image',
        'intro_title_uz', 'intro_title_ru', 'intro_title_en',
        'intro_description_uz', 'intro_description_ru', 'intro_description_en',
        'intro_image',
        'mission_title_uz', 'mission_title_ru', 'mission_title_en',
        'mission_text_uz', 'mission_text_ru', 'mission_text_en',
        'vision_title_uz', 'vision_title_ru', 'vision_title_en',
        'vision_text_uz', 'vision_text_ru', 'vision_text_en',
        'goals_title_uz', 'goals_title_ru', 'goals_title_en',
        'goals_uz', 'goals_ru', 'goals_en',
        'stats',
        'show_team',
    ];

    protected $casts = [
        'goals_uz'  => 'array',
        'goals_ru'  => 'array',
        'goals_en'  => 'array',
        'stats'     => 'array',
        'show_team' => 'boolean',
    ];

    public static function singleton(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
