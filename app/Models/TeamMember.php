<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TeamMember extends Model
{
    protected $fillable = [
        'name_uz', 'name_ru', 'name_en',
        'position_uz', 'position_ru', 'position_en',
        'bio_uz', 'bio_ru', 'bio_en',
        'image', 'facebook', 'twitter', 'linkedin',
        'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
