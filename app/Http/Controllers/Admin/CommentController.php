<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        return view('admin.comments', [
            'comments' => Comment::with(['user', 'news'])->latest()->paginate(15),
        ]);
    }

    public function approve(int $id)
    {
        Comment::findOrFail($id)->update(['is_approved' => true]);

        return back()->with('success', __('app.flash_saved'));
    }

    public function destroy(int $id)
    {
        Comment::findOrFail($id)->delete();

        return back()->with('success', __('app.flash_deleted'));
    }
}
