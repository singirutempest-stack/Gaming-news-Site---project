<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users', ['users' => User::latest()->paginate(15)]);
    }

    public function updateRole(Request $request, int $id)
    {
        $data = $request->validate(['role' => 'required|in:admin,journalist,guest']);
        User::findOrFail($id)->update($data);

        return back()->with('success', __('app.flash_saved'));
    }
}
