<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['category', 'author', 'translations'])->published()->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        return view('pages.news-index', [
            'news' => $query->paginate(9)->withQueryString(),
            'categories' => Category::withCount('news')->get(),
            'trending' => $this->trending(),
        ]);
    }

    public function show(News $news)
    {
        abort_unless($news->status === 'published' || auth()->id() === $news->author_id || auth()->user()?->isAdmin(), 404);

        if (! session()->has('viewed_'.$news->id)) {
            $news->increment('views');
            session()->put('viewed_'.$news->id, true);
        }

        $news->load(['category', 'author', 'translations', 'approvedComments.user']);
        $display = $news->translatedFor(app()->getLocale());
        $related = News::with(['category', 'translations'])->published()
            ->where('category_id', $news->category_id)
            ->whereKeyNot($news->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('pages.news-show', [
            'news' => $news,
            'display' => $display,
            'related' => $related,
            'trending' => $this->trending(),
        ]);
    }

    public function create()
    {
        $this->authorize('create', News::class);

        return view('pages.news-form', [
            'news' => new News(['video_type' => 'none', 'language' => 'en', 'status' => 'draft']),
            'categories' => Category::all(),
            'mode' => 'create',
        ]);
    }

    public function store(StoreNewsRequest $request)
    {
        $this->authorize('create', News::class);

        $news = new News();
        $this->fillAndPersist($news, $request);

        return redirect()->route('news.show', $news)->with('success', __('app.flash_saved'));
    }

    public function edit(News $news)
    {
        $this->authorize('update', $news);

        return view('pages.news-form', [
            'news' => $news,
            'categories' => Category::all(),
            'mode' => 'edit',
        ]);
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $this->authorize('update', $news);
        $this->fillAndPersist($news, $request);

        return redirect()->route('news.show', $news)->with('success', __('app.flash_saved'));
    }

    public function destroy(News $news)
    {
        $this->authorize('delete', $news);
        $this->deleteMedia($news);
        $news->delete();

        return redirect()->route('news.index')->with('success', __('app.flash_deleted'));
    }

    public function storeComment(StoreCommentRequest $request, News $news)
    {
        $news->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->validated('body'),
            'is_approved' => false,
        ]);

        return back()->with('success', __('app.flash_comment_pending'));
    }

    protected function fillAndPersist(News $news, Request $request): void
    {
        $validated = $request->validated();
        $validated['featured'] = $request->boolean('featured');
        $validated['author_id'] = $news->exists ? $news->author_id : $request->user()->id;
        $validated['slug'] = News::makeUniqueSlug($validated['title'], $news->id);
        $validated['published_at'] = $validated['published_at'] ?: ($validated['status'] === 'published' ? now() : null);
        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        if ($request->user()->isAdmin() && $request->filled('views')) {
            $validated['views'] = $request->integer('views');
        } else {
            unset($validated['views']);
        }

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news/images', 'public');
        }

        if ($validated['video_type'] === 'youtube') {
            if ($news->video_type === 'local' && $news->video_url) {
                Storage::disk('public')->delete($news->video_url);
            }
            $validated['video_url'] = $this->extractYoutubeId($validated['video_url']);
        } elseif ($validated['video_type'] === 'local' && $request->hasFile('video_file')) {
            if ($news->video_type === 'local' && $news->video_url) {
                Storage::disk('public')->delete($news->video_url);
            }
            $validated['video_url'] = $request->file('video_file')->store('news/videos', 'public');
        } elseif ($validated['video_type'] === 'none') {
            if ($news->video_type === 'local' && $news->video_url) {
                Storage::disk('public')->delete($news->video_url);
            }
            $validated['video_url'] = null;
        }

        unset($validated['video_file']);
        $news->fill($validated)->save();
        $this->syncTranslations($news, $translations);
    }

    private function syncTranslations(News $news, array $translations): void
    {
        foreach (['en', 'ru', 'kz'] as $locale) {
            $translation = $translations[$locale] ?? [];
            $title = trim($translation['title'] ?? '');
            $shortDescription = trim($translation['short_description'] ?? '');
            $content = trim($translation['content'] ?? '');

            if ($title === '' && $shortDescription === '' && $content === '') {
                $news->translations()->where('locale', $locale)->delete();
                continue;
            }

            $news->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'translated_title' => $title !== '' ? $title : $news->title,
                    'translated_short_description' => $shortDescription !== '' ? $shortDescription : $news->short_description,
                    'translated_content' => $content !== '' ? $content : $news->content,
                ]
            );
        }
    }

    private function deleteMedia(News $news): void
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        if ($news->video_type === 'local' && $news->video_url) {
            Storage::disk('public')->delete($news->video_url);
        }
    }

    private function extractYoutubeId(string $url): string
    {
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([A-Za-z0-9_-]{11})/', $url, $matches);

        return $matches[1] ?? $url;
    }

    private function trending()
    {
        return News::where('status', 'published')
            ->with('translations')
            ->where('published_at', '>=', now()->subDays(7))
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
    }
}
