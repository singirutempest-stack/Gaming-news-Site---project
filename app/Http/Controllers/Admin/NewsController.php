<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends FrontendNewsController
{
    public function index(Request $request)
    {
        $query = News::with(['category', 'author'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('admin.news', [
            'news' => $query->paginate(12)->withQueryString(),
        ]);
    }

    public function show($id)
    {
        return redirect()->route('admin.news.edit', $id);
    }

    public function edit($id)
    {
        return view('pages.news-form', [
            'news' => News::findOrFail($id),
            'categories' => Category::all(),
            'mode' => 'admin',
        ]);
    }

    public function update(UpdateNewsRequest $request, $id)
    {
        $news = News::findOrFail($id);
        $this->fillAndPersist($news, $request);

        return redirect()->route('admin.news.index')->with('success', __('app.flash_saved'));
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        if ($news->video_type === 'local' && $news->video_url) {
            Storage::disk('public')->delete($news->video_url);
        }

        $news->delete();

        return back()->with('success', __('app.flash_deleted'));
    }
}
