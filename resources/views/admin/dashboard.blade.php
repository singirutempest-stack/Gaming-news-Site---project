@extends('layouts.admin')

@section('title', __('app.dashboard'))

@section('content')
<div class="row g-3 mb-4">
    @foreach ([['Total News', $totalNews, 'bi-newspaper'], ['Users', $totalUsers, 'bi-people'], ['Comments', $totalComments, 'bi-chat-dots'], ['Pending', $pendingComments, 'bi-hourglass']] as [$label, $value, $icon])
        <div class="col-sm-6 col-xl-3">
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">{{ $label }}</span><i class="bi {{ $icon }}"></i>
                </div>
                <strong class="display-6">{{ $value }}</strong>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <h2 class="h4">{{ __('app.latest_news') }}</h2>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover table-bordered align-middle">
                <thead><tr><th>ID</th><th>{{ __('app.title') }}</th><th>{{ __('app.category') }}</th><th>{{ __('app.status') }}</th><th>{{ __('app.views') }}</th></tr></thead>
                <tbody>
                    @foreach ($latestNews as $item)
                        <tr><td>{{ $item->id }}</td><td>{{ $item->title }}</td><td>{{ $item->category->name }}</td><td><span class="badge bg-secondary">{{ $item->status }}</span></td><td>{{ $item->views }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xl-4">
        <h2 class="h4">{{ __('app.latest_comments') }}</h2>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover table-bordered align-middle">
                <thead><tr><th>{{ __('app.author') }}</th><th>{{ __('app.excerpt') }}</th><th>{{ __('app.status') }}</th></tr></thead>
                <tbody>
                    @foreach ($latestComments as $comment)
                        <tr><td>{{ $comment->user->name }}</td><td>{{ \Illuminate\Support\Str::limit($comment->body, 40) }}</td><td><span class="badge bg-secondary">{{ $comment->is_approved ? 'approved' : 'pending' }}</span></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
