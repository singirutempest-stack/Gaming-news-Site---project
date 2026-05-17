<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'News',     'name_ru' => 'Новости',    'name_kz' => 'Жаңалықтар',  'color' => '#ff3d3d', 'icon' => 'bi-newspaper'],
            ['name' => 'Reviews',  'name_ru' => 'Обзоры',     'name_kz' => 'Шолулар',      'color' => '#7b2fff', 'icon' => 'bi-star-fill'],
            ['name' => 'Esports',  'name_ru' => 'Киберспорт', 'name_kz' => 'Киберспорт',   'color' => '#00e676', 'icon' => 'bi-trophy-fill'],
            ['name' => 'Trailers', 'name_ru' => 'Трейлеры',   'name_kz' => 'Трейлерлер',   'color' => '#ff9800', 'icon' => 'bi-play-circle-fill'],
            ['name' => 'Industry', 'name_ru' => 'Индустрия',  'name_kz' => 'Индустрия',    'color' => '#00bcd4', 'icon' => 'bi-briefcase-fill'],
            ['name' => 'Guides',   'name_ru' => 'Гайды',      'name_kz' => 'Гайдтар',      'color' => '#8888aa', 'icon' => 'bi-book-fill'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    ...$category,
                    'description' => $category['name'].' coverage for competitive players and gaming fans.',
                ]
            );
        }
    }
}
