<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        return view('pages.news-index', [
            'news' => News::with(['category', 'author', 'translations'])->published()
                ->whereBelongsTo($category)
                ->latest('published_at')
                ->paginate(9),
            'categories' => Category::withCount('news')->get(),
            'trending' => News::with('translations')->where('status', 'published')->where('published_at', '>=', now()->subDays(7))->orderBy('views', 'desc')->take(5)->get(),
            'currentCategory' => $category,
        ]);
    }
}
