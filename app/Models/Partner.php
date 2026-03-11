<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Partner extends Model
{
    protected $fillable = [
        'name_uz', 'name_ru', 'name_en',
        'description_uz', 'description_ru', 'description_en',
        'logo', 'website', 'type', 'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'international' => 'Xalqaro',
            'national'      => 'Milliy',
            'research'      => 'Ilmiy',
            default         => $this->type,
        };
    }
}
