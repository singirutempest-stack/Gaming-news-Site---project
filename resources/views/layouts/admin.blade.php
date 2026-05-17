<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('app.admin'))</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Rajdhani:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="admin-shell d-flex">
    <aside class="admin-sidebar border-end p-3">
        <a class="navbar-brand fs-3 d-block mb-4" href="{{ route('admin.dashboard') }}">GAMEWIRE</a>
        <nav class="nav flex-column gap-1">
            <a class="nav-link text-light" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> <span class="nav-label">{{ __('app.dashboard') }}</span></a>
            <a class="nav-link text-light" href="{{ route('admin.news.index') }}"><i class="bi bi-newspaper"></i> <span class="nav-label">{{ __('app.news') }}</span></a>
            <a class="nav-link text-light" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> <span class="nav-label">{{ __('app.users') }}</span></a>
<a class="nav-link text-light" href="{{ route('admin.comments.index') }}"><i class="bi bi-chat-dots"></i> <span class="nav-label">{{ __('app.comments') }}</span></a>
        </nav>
    </aside>
    <div class="admin-content">
        <nav class="navbar navbar-dark border-bottom px-3">
            <span class="navbar-text">@yield('title', __('app.admin'))</span>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                <form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-light"><i class="bi bi-box-arrow-right"></i></button></form>
            </div>
        </nav>
        <main class="p-3 p-lg-4">
            <x-flash-messages />
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
