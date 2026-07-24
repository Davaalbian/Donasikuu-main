<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        $user = Auth::user();
        $request->session()->regenerate();

        // ADMIN LANGSUNG MASUK
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        // DONATUR WAJIB EMAIL VERIF (kalau kamu pakai fitur ini)
        if (!is_null($user->email_verified_at)) {
            return redirect()->route('donatur.dashboard');
        }

        Auth::logout();

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Silakan verifikasi email terlebih dahulu!'
            ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'donatur',
        ]);

        Auth::login($user);

        // ini yang WAJIB supaya email verification trigger
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}