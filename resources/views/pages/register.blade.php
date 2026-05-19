@extends('layouts.auth')

@section('title', __('app.register'))

@section('content')
<h1 class="h2 mb-3">{{ __('app.register') }}</h1>
<form method="post" action="{{ route('register.store') }}">
    @csrf
    <input class="form-control mb-3" type="text" name="name" placeholder="{{ __('app.name') }}" required>
    <input class="form-control mb-3" type="email" name="email" placeholder="{{ __('app.email') }}" required>
    <input class="form-control mb-3" type="password" name="password" placeholder="{{ __('app.password') }}" required>
    <button class="btn btn-primary w-100">{{ __('app.register') }}</button>
    <p class="mt-3 mb-0 text-muted"><a href="{{ route('login') }}">{{ __('app.login') }}</a></p>
</form>
@endsection
