<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
<<<<<<< HEAD
=======
    // Menampilkan halaman login
>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c
    public function showLogin()
    {
        return view('auth.login');
    }

<<<<<<< HEAD
    public function login(Request $request)
    {
=======
    // Memproses data login
    public function login(Request $request)
    {
        // Validasi input
>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

<<<<<<< HEAD
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status_akun !== 'aktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->with('error', 'Akun Anda dinonaktifkan.')
                    ->withInput($request->only('username'));
            }

            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'pemilik') {
                return redirect()->route('pemilik.dashboard');
            } elseif ($user->role === 'petugas') {
                return redirect()->route('petugas.dashboard');
            }

            Auth::logout();
            return redirect('/login')
                ->with('error', 'Role pengguna tidak dikenali.');
        }

        return back()
            ->with('error', 'Username atau password salah!')
            ->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
=======
        // Cek kecocokan username & password ke database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika berhasil, arahkan ke halaman dashboard
            return redirect()->intended('/dashboard');
        }

        // Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->with('error', 'Username atau password salah!')->withInput($request->only('username'));
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();

>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c
