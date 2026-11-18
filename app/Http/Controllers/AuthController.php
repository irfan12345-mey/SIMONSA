<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Menampilkan halaman daftar
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses pendaftaran akun
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'min:4', 'max:50', 'unique:pengguna,username'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            // Ubah 'petugas' menjadi 'pekerja'
            'role' => ['required', 'in:pemilik,pekerja'], 
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.unique' => 'Username sudah terdaftar, silakan gunakan username lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'role.required' => 'Silakan pilih peran Anda.',
            'role.in' => 'Peran yang dipilih tidak valid.',
        ]);

        // Menyimpan ke tabel 'pengguna'
        User::create([
            'nama' => $request->username, 
            'username' => $request->username,
            'password' => $request->password, 
            'role' => $request->role, 
            'status_akun' => 'aktif',
        ]);

        return redirect('/login')
            ->with('success', 'Pendaftaran berhasil! Silakan login menggunakan username dan password Anda.');
    }

    // Memproses data login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Memeriksa username dan password
        if (Auth::attempt($credentials)) {

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Memeriksa status akun
            if ($user->status_akun !== 'aktif') {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->with('error', 'Akun Anda dinonaktifkan.')
                    ->withInput($request->only('username'));
            }

            // Memperbarui session
            $request->session()->regenerate();

            // Mengarahkan berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'pemilik') {
                return redirect()->route('pemilik.dashboard');
            } elseif ($user->role === 'pekerja') { // Ubah 'petugas' menjadi 'pekerja'
                return redirect()->route('pekerja.dashboard'); // Ubah route ke pekerja.dashboard
            }

            // Jika role tidak dikenali
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')
                ->with('error', 'Role pengguna tidak dikenali.');
        }

        // Jika login gagal
        return back()
            ->with('error', 'Username atau password salah!')
            ->withInput($request->only('username'));
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}