<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Species extends Model
{
    use HasSlug;

    protected $fillable = [
        'slug',
        'category',
        'danger_level',
        'name_uz',
        'name_ru',
        'name_en',
        'scientific_name',
        'description_short_uz',
        'description_short_ru',
        'description_short_en',
        'description_full_uz',
        'description_full_ru',
        'description_full_en',
        'description_bullets_uz',
        'description_bullets_ru',
        'description_bullets_en',
        'image_main',
        'image_gallery',
        'stat_mass',
        'stat_speed',
        'stat_lifespan',
        'stat_diet',
        'stat_height',
        'stat_bloom_period',
        'stat_habitat',
        'habitat_location_uz',
        'habitat_location_ru',
        'habitat_location_en',
        'latitude',
        'longitude',
        'conservation_level',
        'conservation_population',
        'threats_uz',
        'threats_ru',
        'threats_en',
        'related_species',
        'views_count',
        'featured',
        'is_active',
    ];

    protected $casts = [
        'description_bullets_uz' => 'array',
        'description_bullets_ru' => 'array',
        'description_bullets_en' => 'array',
        'image_gallery'          => 'array',
        'threats_uz'             => 'array',
        'threats_ru'             => 'array',
        'threats_en'             => 'array',
        'related_species'        => 'array',
        'featured'               => 'boolean',
        'is_active'              => 'boolean',
        'latitude'               => 'decimal:7',
        'longitude'              => 'decimal:7',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name_uz')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeByDangerLevel(Builder $query, string $level): Builder
    {
        return $query->where('danger_level', $level);
    }

    // Danger level label
    public function getDangerLevelLabelAttribute(): string
    {
        return match ($this->danger_level) {
            'critically_endangered' => "Yo'qolib ketish xavfi juda yuqori",
            'endangered'            => "Yo'qolib ketish xavfi yuqori",
            'vulnerable'            => 'Zaif',
            'near_threatened'       => 'Deyarli tahdid ostida',
            default                 => $this->danger_level,
        };
    }

    public function getDangerLevelColorAttribute(): string
    {
        return match ($this->danger_level) {
            'critically_endangered' => 'danger',
            'endangered'            => 'warning',
            'vulnerable'            => 'info',
            'near_threatened'       => 'secondary',
            default                 => 'secondary',
        };
    }
}
