<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Rajdhani:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@php($navCategories = \App\Models\Category::all())
<nav class="navbar navbar-expand-lg navbar-dark border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fs-3 fw-bold" href="{{ route('home') }}">GAMEWIRE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                @foreach ($navCategories as $category)
                    <li class="nav-item"><a class="nav-link" href="{{ route('category.show', $category) }}">{{ $category->label() }}</a></li>
                @endforeach
            </ul>
            <div class="btn-group me-lg-3" role="group">
                @foreach (['en' => 'EN', 'ru' => 'RU', 'kz' => 'KZ'] as $locale => $label)
                    <a class="btn btn-sm {{ app()->getLocale() === $locale ? 'btn-primary' : 'btn-outline-light' }}" href="{{ route('lang.switch', $locale) }}">{{ $label }}</a>
                @endforeach
            </div>
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">{{ auth()->user()->name }}</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if(auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">{{ __('app.admin') }}</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('profile') }}">{{ __('app.profile') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="post" action="{{ route('logout') }}">@csrf<button class="dropdown-item">{{ __('app.logout') }}</button></form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="btn btn-outline-light" href="{{ route('login') }}">{{ __('app.login') }}</a>
            @endauth
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container"><x-flash-messages /></div>
    @yield('content')
</main>

<footer class="footer border-top mt-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3"><h3 class="h5">GAMEWIRE</h3><p class="text-muted">{{ __('app.footer_about') }}</p></div>
            <div class="col-md-3"><h3 class="h5">{{ __('app.links') }}</h3><a class="d-block" href="{{ route('news.index') }}">{{ __('app.news') }}</a></div>
            <div class="col-md-3"><h3 class="h5">{{ __('app.categories') }}</h3>@foreach($navCategories->take(6) as $category)<a class="d-block" href="{{ route('category.show', $category) }}">{{ $category->label() }}</a>@endforeach</div>
            <div class="col-md-3"><h3 class="h5">{{ __('app.contacts') }}</h3><p class="text-muted mb-2">press@gamewire.test</p><div class="d-flex gap-2"><a href="#"><i class="bi bi-twitter-x"></i></a><a href="#"><i class="bi bi-youtube"></i></a><a href="#"><i class="bi bi-discord"></i></a></div></div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
