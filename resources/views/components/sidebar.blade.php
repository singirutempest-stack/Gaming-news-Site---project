@props(['categories' => collect()])

<aside class="d-flex flex-column gap-4">
    <section class="bg-surface border-gaming p-3">
        <h2 class="h4 mb-3">{{ __('app.categories') }}</h2>
        <div class="list-group list-group-flush">
            @foreach ($categories as $category)
                <a class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center" href="{{ route('news.index', ['category' => $category->slug]) }}">
                    <span><i class="bi {{ $category->icon }}" style="color: {{ $category->color }}"></i> {{ $category->label() }}</span>
                    <span class="badge bg-secondary">{{ $category->news_count }}</span>
                </a>
            @endforeach
        </div>
    </section>
</aside>
