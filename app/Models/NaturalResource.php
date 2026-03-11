<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class NaturalResource extends Model
{
    use HasSlug;

    protected $fillable = [
        'slug',
        'title_uz',
        'title_ru',
        'title_en',
        'excerpt_uz',
        'excerpt_ru',
        'excerpt_en',
        'content_uz',
        'content_ru',
        'content_en',
        'image',
        'category',
        'image_gallery',
        'features_uz',
        'features_ru',
        'features_en',
        'stat_area',
        'stat_species',
        'stat_protected',
        'latitude',
        'longitude',
        'views_count',
        'featured',
        'is_active',
    ];

    protected $casts = [
        'image_gallery' => 'array',
        'features_uz'   => 'array',
        'features_ru'   => 'array',
        'features_en'   => 'array',
        'featured'      => 'boolean',
        'is_active'     => 'boolean',
        'latitude'      => 'decimal:7',
        'longitude'     => 'decimal:7',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title_uz')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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
}
