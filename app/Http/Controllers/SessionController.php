<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Fail
        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'general' => 'The provided credentials does not match our records.',
            ]);
        }

        // Success
        $request->session()->regenerate();

        return redirect()->intended('/my-page');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
