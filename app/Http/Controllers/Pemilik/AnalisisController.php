<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\HasilPanen;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalisisController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data kebun untuk filter
        $kebunList = Kebun::where('id_pemilik', Auth::id())->orderBy('nama_kebun')->get();

        // 2. Tentukan Filter Tanggal (Default: Bulan Ini)
        $tanggalAwal = $request->input('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', now()->endOfMonth()->format('Y-m-d'));

        // 3. Query Dasar: Ambil total berat panen per blok
        $query = HasilPanen::select(
                'blok.id_blok',
                'blok.kode_blok',
                'blok.nama_blok',
                'kebun.nama_kebun',
                DB::raw('SUM(hasil_panen.berat_tbs_kg) as total_berat')
            )
            ->join('blok', 'hasil_panen.id_blok', '=', 'blok.id_blok')
            ->join('kebun', 'blok.id_kebun', '=', 'kebun.id_kebun')
            ->where('kebun.id_pemilik', Auth::id())
            ->whereBetween('hasil_panen.tanggal_panen', [$tanggalAwal, $tanggalAkhir]);

        // 4. Filter berdasarkan Kebun (jika dipilih)
        if ($request->filled('id_kebun')) {
            $query->where('kebun.id_kebun', $request->id_kebun);
        }

        // 5. Eksekusi query dan urutkan dari yang tertinggi
        $dataAnalisis = $query->groupBy('blok.id_blok', 'blok.kode_blok', 'blok.nama_blok', 'kebun.nama_kebun')
            ->orderByDesc('total_berat')
            ->get();

        // 6. Siapkan data untuk Grafik Chart.js
        $labels = $dataAnalisis->map(fn($item) => $item->kode_blok . ' - ' . $item->nama_blok);
        $dataPanen = $dataAnalisis->pluck('total_berat');

        // 7. Cari Tertinggi dan Terendah
        $tertinggi = $dataAnalisis->first();
        $terendah = $dataAnalisis->last();

        return view('pemilik_kebun.analisis.index', compact(
            'kebunList', 
            'dataAnalisis', 
            'labels', 
            'dataPanen', 
            'tertinggi', 
            'terendah',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }
}