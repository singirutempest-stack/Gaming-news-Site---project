<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $featured = News::with(['category', 'translations'])->published()->where('featured', true)->latest('published_at')->first()
            ?: News::with(['category', 'translations'])->published()->latest('published_at')->first();

        $news = News::with(['category', 'author', 'translations'])->published()->latest('published_at')->paginate(9);
        $categories = Category::withCount('news')->get();

        return view('pages.home', compact('featured', 'news', 'categories'));
    }
}
