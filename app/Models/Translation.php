<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{

    protected $fillable = [
        'news_id',
        'locale',
        'translated_title',
        'translated_short_description',
        'translated_content',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
