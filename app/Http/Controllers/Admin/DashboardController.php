<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalNews' => News::count(),
            'totalUsers' => User::count(),
            'totalComments' => Comment::count(),
            'pendingComments' => Comment::where('is_approved', false)->count(),
            'latestNews' => News::with(['category', 'author'])->latest()->take(5)->get(),
            'latestComments' => Comment::with(['user', 'news'])->latest()->take(5)->get(),
        ]);
    }
}
