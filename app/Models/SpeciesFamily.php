<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpeciesFamily extends Model
{
    protected $fillable = [
        'category',
        'slug',
        'name_uz',
        'name_ru',
        'name_en',
        'latin_name',
        'sort',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public function species(): HasMany
    {
        return $this->hasMany(Species::class, 'family_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeAnimals(Builder $query): Builder
    {
        return $query->where('category', 'animal');
    }

    public function scopePlants(Builder $query): Builder
    {
        return $query->where('category', 'plant');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
