@extends('layouts.auth')

@section('title', __('app.login'))

@section('content')
<h1 class="h2 mb-3">{{ __('app.login') }}</h1>
<form method="post" action="{{ route('login.store') }}">
    @csrf
    <label class="form-label">{{ __('app.email') }}</label>
    <input class="form-control mb-3" type="email" name="email" value="{{ old('email') }}" required>
    <label class="form-label">{{ __('app.password') }}</label>
    <input class="form-control mb-3" type="password" name="password" required>
    <button class="btn btn-primary w-100">{{ __('app.login') }}</button>
    <p class="mt-3 mb-0 text-muted"><a href="{{ route('register') }}">{{ __('app.register') }}</a></p>
</form>
@endsection
