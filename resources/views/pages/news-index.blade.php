@extends('layouts.app')

@section('title', (isset($currentCategory) ? $currentCategory->label() : __('app.news')).' - '.config('app.name'))

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
            <li class="breadcrumb-item active">{{ isset($currentCategory) ? $currentCategory->label() : __('app.news') }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-9">
            <div class="bg-surface border-gaming p-3 mb-3">
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-sm {{ request('category') ? 'btn-outline-light' : 'btn-primary' }}" href="{{ route('news.index') }}">{{ __('app.all') }}</a>
                    @foreach ($categories as $category)
                        <a class="btn btn-sm {{ request('category') === $category->slug ? 'btn-primary' : 'btn-outline-light' }}" href="{{ route('news.index', ['category' => $category->slug]) }}">{{ $category->label() }}</a>
                    @endforeach
                </div>
            </div>

            <div class="row g-4">
                @forelse ($news as $item)
                    <div class="col-md-6 col-xl-4"><x-news-card :item="$item" /></div>
                @empty
                    <p class="text-muted">{{ __('app.no_items') }}</p>
                @endforelse
            </div>
            <div class="mt-4 d-flex justify-content-center">{{ $news->links() }}</div>
        </div>
        <div class="col-lg-3"><x-sidebar :trending="$trending" :categories="$categories" /></div>
    </div>
</div>
@endsection
