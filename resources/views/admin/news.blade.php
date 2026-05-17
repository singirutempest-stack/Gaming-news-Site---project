@extends('layouts.admin')

@section('title', __('app.news'))

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
    <a class="btn btn-primary" href="{{ route('news.create') }}"><i class="bi bi-plus-lg"></i> {{ __('app.add_news') }}</a>
    <form class="d-flex gap-2" action="{{ route('admin.news.index') }}">
        <select class="form-select" name="status">
            <option value="">{{ __('app.all') }}</option>
            <option value="draft" @selected(request('status') === 'draft')>{{ __('app.draft') }}</option>
            <option value="published" @selected(request('status') === 'published')>{{ __('app.published') }}</option>
        </select>
        <button class="btn btn-secondary">{{ __('app.filter') }}</button>
    </form>
</div>
<div class="table-responsive">
    <table class="table table-dark table-striped table-hover table-bordered align-middle">
        <thead><tr><th>ID</th><th>{{ __('app.thumb') }}</th><th>{{ __('app.title') }}</th><th>{{ __('app.category') }}</th><th>{{ __('app.author') }}</th><th>{{ __('app.status') }}</th><th>{{ __('app.views') }}</th><th>{{ __('app.date') }}</th><th>{{ __('app.actions') }}</th></tr></thead>
        <tbody>
            @foreach ($news as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><img src="{{ $item->image ? asset('storage/'.$item->image) : asset('images/placeholder.svg') }}" width="96" height="54" class="object-fit-cover" alt=""></td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->author->name }}</td>
                    <td><span class="badge bg-secondary">{{ $item->status }}</span></td>
                    <td>{{ $item->views }}</td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.news.edit', $item->id) }}">{{ __('app.edit') }}</a>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteNews{{ $item->id }}">{{ __('app.delete') }}</button>
                        <div class="modal fade" id="deleteNews{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content bg-card">
                                <div class="modal-header"><h5 class="modal-title">{{ __('app.delete') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body">{{ $item->title }}</div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
                                    <form method="post" action="{{ route('admin.news.destroy', $item->id) }}">@csrf @method('DELETE')<button class="btn btn-danger">{{ __('app.delete') }}</button></form>
                                </div>
                            </div></div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $news->links() }}
@endsection
