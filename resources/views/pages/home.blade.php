@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
<div class="container">
    @if ($featured)
        <section class="hero border-gaming mb-5">
            @if($featured->image)
                <img class="hero-image h-100" src="{{ asset('storage/'.$featured->image) }}" alt="{{ $featured->title }}">
            @else
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#0a0a0f 0%,{{ $featured->category->color ?? '#7b2fff' }}55 100%);z-index:1">
                    <i class="bi bi-controller" style="font-size:7rem;color:{{ $featured->category->color ?? '#7b2fff' }};opacity:0.25"></i>
                </div>
            @endif
            <div class="position-absolute top-0 start-0 z-2 p-3">
                <span class="badge" style="background: {{ $featured->category->color }}">{{ $featured->category->label() }}</span>
            </div>
            <div class="hero-content">
                <h1><a href="{{ route('news.show', $featured) }}">{{ $featured->localizedTitle() }}</a></h1>
                <p class="text-muted fs-5 mb-0">{{ $featured->localizedShortDescription() }}</p>
            </div>
        </section>
    @endif

    <div class="row g-4">
        <div class="col-lg-9">
            <h2 class="mb-3">{{ __('app.latest_news') }}</h2>
            <div class="row g-4">
                @foreach ($news as $item)
                    <div class="col-md-6 col-xl-4"><x-news-card :item="$item" /></div>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">{{ $news->links() }}</div>
        </div>
        <div class="col-lg-3">
            <x-sidebar :trending="$trending" :categories="$categories" />
        </div>
    </div>
</div>
@endsection
