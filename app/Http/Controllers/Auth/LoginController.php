<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('pages.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended(Auth::user()->isAdmin() ? route('admin.dashboard') : route('home'));
        }

        return back()->withErrors(['email' => __('app.login_failed')])->onlyInput('email');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
