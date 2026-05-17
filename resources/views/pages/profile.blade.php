@extends('layouts.app')

@section('title', __('app.profile'))

@section('content')
<div class="container">
    <div class="row g-4">
        <div class="col-lg-4">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-surface border-gaming p-3">
                @csrf
                <img class="avatar mb-3" src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/avatar-placeholder.svg') }}" alt="{{ $user->name }}">
                <input class="form-control mb-3" type="file" name="avatar" accept="image/jpeg,image/png">
                <label class="form-label">{{ __('app.name') }}</label>
                <input class="form-control mb-3" name="name" value="{{ old('name', $user->name) }}">
                <label class="form-label">{{ __('app.email') }}</label>
                <input class="form-control mb-3" value="{{ $user->email }}" readonly>
                <button class="btn btn-primary">{{ __('app.save') }}</button>
            </form>
        </div>
        <div class="col-lg-8">
            <section class="mb-4">
                <h1 class="h3">{{ __('app.my_articles') }}</h1>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover table-bordered align-middle">
                        <thead><tr><th>{{ __('app.title') }}</th><th>{{ __('app.status') }}</th><th>{{ __('app.views') }}</th><th>{{ __('app.date') }}</th><th>{{ __('app.actions') }}</th></tr></thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
                                    <td><span class="badge bg-secondary">{{ $article->status }}</span></td>
                                    <td>{{ $article->views }}</td>
                                    <td>{{ $article->created_at->format('Y-m-d') }}</td>
                                    <td><a class="btn btn-sm btn-secondary" href="{{ route('news.edit', $article) }}">{{ __('app.edit') }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $articles->links() }}
            </section>
        </div>
    </div>
</div>
@endsection
