<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    // Tampilkan form login
    public function show() {
        return view('login');
    }

    // Proses login
    public function login(Request $request) {
        $credentials = $request->validate([
            'phone'    => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended(route('rent.index'));
        }

        return back()->withErrors([
            'phone' => 'Credensial tidak cocok.',
        ]);
    }

    // Proses logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
