<?php

use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::post('/news/{news:slug}/comments', [NewsController::class, 'storeComment'])->name('news.comments.store');

Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest')->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/register', [RegisterController::class, 'show'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.store');
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');

Route::middleware(['auth', 'role:journalist'])->group(function () {
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news:slug}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news:slug}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news:slug}', [NewsController::class, 'destroy'])->name('news.destroy');
});

Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
    Route::get('/news/{id}/edit', [AdminNewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [AdminNewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [AdminNewsController::class, 'destroy'])->name('news.destroy');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::put('/comments/{id}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'ru', 'kz'], true), 404);
    session(['locale' => $locale]);

    return back();
})->name('lang.switch');
