@props(['trending' => collect(), 'categories' => collect()])

<aside class="d-flex flex-column gap-4">
    <section class="bg-surface border-gaming p-3">
        <h2 class="h4 mb-3">{{ __('app.trending') }}</h2>
        <div class="d-flex flex-column gap-3">
            @forelse ($trending as $item)
                <a class="d-flex gap-3 align-items-start border-bottom border-secondary pb-3" href="{{ route('news.show', $item) }}">
                    <span class="rank">{{ $loop->iteration }}</span>
                    <span>
                        <strong class="d-block">{{ $item->localizedTitle() }}</strong>
                        <span class="small text-muted">{{ number_format($item->views) }} {{ __('app.views') }}</span>
                    </span>
                </a>
            @empty
                <p class="text-muted mb-0">{{ __('app.no_items') }}</p>
            @endforelse
        </div>
    </section>

    <section class="bg-surface border-gaming p-3">
        <h2 class="h4 mb-3">{{ __('app.categories') }}</h2>
        <div class="list-group list-group-flush">
            @foreach ($categories as $category)
                <a class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center" href="{{ route('category.show', $category) }}">
                    <span><i class="bi {{ $category->icon }}" style="color: {{ $category->color }}"></i> {{ $category->label() }}</span>
                    <span class="badge bg-secondary">{{ $category->news_count ?? $category->news()->count() }}</span>
                </a>
            @endforeach
        </div>
    </section>
</aside>
