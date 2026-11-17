<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar informasi dasar pengguna (Fitur A-02)
     * Tanpa menampilkan password sesuai ketentuan proposal.
     */
    public function index()
    {
        $pengguna = Pengguna::select('id_pengguna', 'nama', 'username', 'role', 'status_akun', 'created_at')
            ->orderBy('role')
            ->orderBy('nama')
            ->get();

        return view('admin.pengguna.index', compact('pengguna'));
    }

    /**
     * Mengaktifkan atau menonaktifkan akun pengguna (Fitur A-02)
     */
    public function toggleStatus($id_pengguna)
    {
        $user = Pengguna::findOrFail($id_pengguna);
        $user->status_akun = ($user->status_akun === 'aktif') ? 'nonaktif' : 'aktif';
        $user->save();

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Status akun ' . $user->nama . ' berhasil diubah menjadi ' . $user->status_akun . '.');
    }
}
