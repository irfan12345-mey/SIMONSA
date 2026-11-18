<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\HasilPanen;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil daftar kebun milik pemilik yang login (untuk dropdown filter)
        $kebunList = Kebun::where('id_pemilik', Auth::id())->orderBy('nama_kebun')->get();

        // 2. Query dasar mengambil data panen yang hanya milik kebun si pemilik
        $query = HasilPanen::with(['blok.kebun', 'petugas'])
            ->whereHas('blok.kebun', function ($q) {
                $q->where('id_pemilik', Auth::id());
            });

        // 3. Terapkan Filter (Berdasarkan Tanggal, Kebun, atau Blok)
        if ($request->filled('id_kebun')) {
            $query->whereHas('blok', function ($q) use ($request) {
                $q->where('id_kebun', $request->id_kebun);
            });
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_panen', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        // 4. Ambil data dan urutkan dari yang terbaru
        $hasilPanen = $query->orderBy('tanggal_panen', 'desc')->paginate(10)->withQueryString();

        // 5. Hitung Total Berat untuk ditampilkan di ringkasan atas
        $totalBerat = $query->sum('berat_tbs_kg');

        return view('pemilik_kebun.monitoring.index', compact('hasilPanen', 'kebunList', 'totalBerat'));
    }
}