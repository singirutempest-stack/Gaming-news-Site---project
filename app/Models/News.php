<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'content',
        'category_id',
        'author_id',
        'image',
        'video_type',
        'video_url',
        'status',
        'featured',
        'views',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'published_at' => 'datetime',
            'views' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function approvedComments()
    {
        return $this->comments()->where('is_approved', true)->latest();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function localizedTitle(?string $locale = null): string
    {
        $translation = $this->translations->firstWhere('locale', $locale ?: app()->getLocale());
        return $translation?->translated_title ?: $this->title;
    }

    public function localizedShortDescription(?string $locale = null): string
    {
        $translation = $this->translations->firstWhere('locale', $locale ?: app()->getLocale());
        return $translation?->translated_short_description ?: $this->short_description;
    }

    public function translatedFor(?string $locale): array
    {
        $translation = $this->translations->firstWhere('locale', $locale ?: app()->getLocale());

        return [
            'title' => $translation?->translated_title ?: $this->title,
            'short_description' => $translation?->translated_short_description ?: $this->short_description,
            'content' => $translation?->translated_content ?: $this->content,
            'is_original' => ! $translation,
        ];
    }

}
