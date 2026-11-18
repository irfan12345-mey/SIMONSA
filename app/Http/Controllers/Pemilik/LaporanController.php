<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\HasilPanen;
use App\Models\Kebun;
use App\Models\Blok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data untuk dropdown filter
        $kebunList = Kebun::where('id_pemilik', Auth::id())->orderBy('nama_kebun')->get();
        $blokList = Blok::whereHas('kebun', fn($q) => $q->where('id_pemilik', Auth::id()))->orderBy('kode_blok')->get();

        // 2. Tentukan Filter Tanggal (Default: Bulan Ini)
        $tanggalAwal = $request->input('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', now()->endOfMonth()->format('Y-m-d'));

        // 3. Query Dasar
        $query = HasilPanen::with(['blok.kebun', 'petugas'])
            ->whereHas('blok.kebun', function ($q) {
                $q->where('id_pemilik', Auth::id());
            })
            ->whereBetween('tanggal_panen', [$tanggalAwal, $tanggalAkhir]);

        // 4. Terapkan Filter Kebun & Blok
        if ($request->filled('id_kebun')) {
            $query->whereHas('blok', fn($q) => $q->where('id_kebun', $request->id_kebun));
        }
        if ($request->filled('id_blok')) {
            $query->where('id_blok', $request->id_blok);
        }

        // 5. Eksekusi Data (Urutkan dari tanggal terlama untuk laporan)
        $laporan = $query->orderBy('tanggal_panen', 'asc')->get();
        
        // 6. Hitung Total Berat
        $totalBerat = $laporan->sum('berat_tbs_kg');

        return view('pemilik_kebun.laporan.index', compact(
            'kebunList', 
            'blokList', 
            'laporan', 
            'totalBerat', 
            'tanggalAwal', 
            'tanggalAkhir'
        ));
    }
}