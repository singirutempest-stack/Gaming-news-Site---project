@extends('layouts.admin')

@section('title', __('app.users'))

@section('content')
<div class="table-responsive">
    <table class="table table-dark table-striped table-hover table-bordered align-middle">
        <thead><tr><th>ID</th><th>{{ __('app.avatar') }}</th><th>{{ __('app.name') }}</th><th>{{ __('app.email') }}</th><th>{{ __('app.role') }}</th><th>{{ __('app.registered') }}</th></tr></thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><img class="avatar" style="width:48px;height:48px" src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/avatar-placeholder.svg') }}" alt=""></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.users.role', $user->id) }}" class="d-flex gap-2">
                            @csrf @method('PUT')
                            <select class="form-select form-select-sm" name="role">
                                @foreach(['admin','journalist','guest'] as $role)<option value="{{ $role }}" @selected($user->role === $role)>{{ $role }}</option>@endforeach
                            </select>
                            <button class="btn btn-sm btn-secondary">{{ __('app.save') }}</button>
                        </form>
                    </td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $users->links() }}
@endsection
