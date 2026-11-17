<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    public function index()
    {
        // Mengambil data pengguna tanpa menampilkan password (sesuai aturan A-02)
        $pengguna = Pengguna::orderBy('role')->orderBy('nama')->get();

        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function toggleStatus($id_pengguna)
    {
        $user = Pengguna::findOrFail($id_pengguna);
        $user->status_akun = ($user->status_akun === 'aktif') ? 'nonaktif' : 'aktif';
        $user->save();

        return redirect()->back()->with('success', 'Status akun berhasil diubah.');
    }
}