<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('frontend.login');
    }

    // Proses login dengan cache
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cek cache untuk pengguna berdasarkan email
        $user = Cache::remember("user_{$request->email}", now()->addMinutes(10), function () use ($request) {
            return User::where('email', $request->email)->first();
        });

        // Jika pengguna ditemukan dan password cocok
        if ($user && Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->remember)) {
            return redirect()->intended('dashboard');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return redirect()->back()->withErrors([
            'email' => 'Email atau password anda salah',
        ]);
    }

    // Fungsi untuk logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
