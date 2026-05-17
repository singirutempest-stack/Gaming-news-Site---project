@extends('layouts.admin')

@section('title', __('app.comments'))

@section('content')
<div class="table-responsive">
    <table class="table table-dark table-striped table-hover table-bordered align-middle">
        <thead><tr><th>ID</th><th>{{ __('app.author') }}</th><th>{{ __('app.news_title') }}</th><th>{{ __('app.excerpt') }}</th><th>{{ __('app.status') }}</th><th>{{ __('app.date') }}</th><th>{{ __('app.actions') }}</th></tr></thead>
        <tbody>
            @foreach ($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->news->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($comment->body, 80) }}</td>
                    <td><span class="badge bg-secondary">{{ $comment->is_approved ? 'approved' : 'pending' }}</span></td>
                    <td>{{ $comment->created_at->format('Y-m-d') }}</td>
                    <td class="d-flex gap-2">
                        @unless ($comment->is_approved)
                            <form method="post" action="{{ route('admin.comments.approve', $comment->id) }}">@csrf @method('PUT')<button class="btn btn-sm btn-success">{{ __('app.approve') }}</button></form>
                        @endunless
                        <form method="post" action="{{ route('admin.comments.destroy', $comment->id) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">{{ __('app.delete') }}</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $comments->links() }}
@endsection
