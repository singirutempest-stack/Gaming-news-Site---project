<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ru',
        'name_kz',
        'slug',
        'color',
        'icon',
        'description',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function label(?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();

        return match ($locale) {
            'ru' => $this->name_ru ?: $this->name,
            'kz' => $this->name_kz ?: $this->name,
            default => $this->name,
        };
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
