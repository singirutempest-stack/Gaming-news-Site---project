@extends('layouts.app')

@section('title', $display['title'].' - '.config('app.name'))

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', $news->category) }}">{{ $news->category->label() }}</a></li>
            <li class="breadcrumb-item active">{{ $display['title'] }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <article class="col-lg-8">
            @if($news->image)
                <img class="news-image border-gaming mb-3" src="{{ asset('storage/'.$news->image) }}" alt="{{ $display['title'] }}">
            @else
                <div class="news-image border-gaming mb-3 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#12121a 0%,{{ $news->category->color ?? '#7b2fff' }}55 100%)">
                    <i class="bi bi-controller" style="font-size:5rem;color:{{ $news->category->color ?? '#7b2fff' }};opacity:0.5"></i>
                </div>
            @endif
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <span class="badge" style="background: {{ $news->category->color }}">{{ $news->category->label() }}</span>
                @if ($display['is_original'])
                    <span class="badge bg-secondary">{{ __('app.original_language') }}</span>
                @endif
                <span class="text-muted">{{ $news->published_at?->format('M d, Y') }}</span>
                <span class="text-muted">{{ $news->author->name }}</span>
                <span class="text-muted"><i class="bi bi-eye"></i> {{ number_format($news->views) }}</span>
            </div>
            <h1 class="display-5">{{ $display['title'] }}</h1>
            <p class="lead text-muted fst-italic">{{ $display['short_description'] }}</p>
            <div class="fs-5 lh-lg">{!! nl2br(e($display['content'])) !!}</div>

            <div class="my-4"><x-video-player :news="$news" /></div>

            <section class="mt-5">
                <h2>{{ __('app.comments') }}</h2>
                @auth
                    <form method="post" action="{{ route('news.comments.store', $news) }}" class="mb-4">
                        @csrf
                        <textarea class="form-control mb-2" name="body" rows="4" required></textarea>
                        <button class="btn btn-primary">{{ __('app.submit') }}</button>
                    </form>
                @else
                    <p class="text-muted"><a href="{{ route('login') }}">{{ __('app.login') }}</a> {{ __('app.to_comment') }}</p>
                @endauth

                <div class="d-flex flex-column gap-3">
                    @forelse ($news->approvedComments as $comment)
                        <div class="bg-surface border-gaming p-3">
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                            <p class="mb-0 mt-2">{{ $comment->body }}</p>
                        </div>
                    @empty
                        <p class="text-muted">{{ __('app.no_items') }}</p>
                    @endforelse
                </div>
            </section>
        </article>
        <aside class="col-lg-4">
            <section class="bg-surface border-gaming p-3 mb-4">
                <h2 class="h4">{{ __('app.related_news') }}</h2>
                <div class="d-flex flex-column gap-3">
                    @foreach ($related as $item)
                        <a href="{{ route('news.show', $item) }}">{{ $item->localizedTitle() }}</a>
                    @endforeach
                </div>
            </section>
            <x-sidebar :trending="$trending" :categories="\App\Models\Category::withCount('news')->get()" />
        </aside>
    </div>
</div>
@endsection
