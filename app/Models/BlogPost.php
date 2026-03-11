<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogPost extends Model
{
    use HasSlug;

    protected $fillable = [
        'category_id',
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
        'author',
        'video',
        'audio',
        'views_count',
        'is_active',
        'publish_date',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'publish_date' => 'datetime',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class, 'blog_post_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('publish_date')
                  ->orWhere('publish_date', '<=', now());
            });
    }
}
