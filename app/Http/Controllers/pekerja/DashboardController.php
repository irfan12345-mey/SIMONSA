<?php

namespace App\Http\Controllers\Pekerja;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\HasilPanen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $idPekerja = Auth::id();

        // 1. Data Ringkasan
        $totalBerat = HasilPanen::where('id_petugas', $idPekerja)->sum('berat_tbs_kg');
        $jumlahCatatan = HasilPanen::where('id_petugas', $idPekerja)->count();
        $jumlahBlok = HasilPanen::where('id_petugas', $idPekerja)->distinct('id_blok')->count('id_blok');
        
        // Simulasi Jadwal (bisa diganti sesuai kebutuhan)
        $jadwalHariIni = 2; 

        // 2. Data Grafik 7 Hari Terakhir
        $grafikLabels = [];
        $grafikData = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->format('Y-m-d');
            $grafikLabels[] = now()->subDays($i)->translatedFormat('d M');
            $beratHarian = HasilPanen::where('id_petugas', $idPekerja)
                            ->whereDate('tanggal_panen', $tanggal)
                            ->sum('berat_tbs_kg');
            $grafikData[] = $beratHarian;
        }

        // 3. Data Catatan Terbaru (5 data)
        $catatanTerbaru = HasilPanen::with('blok.kebun')
                            ->where('id_petugas', $idPekerja)
                            ->orderBy('tanggal_panen', 'desc')
                            ->take(5)
                            ->get();

        // 4. Data untuk Form Input Cepat (Dropdown Blok)
        $blokList = Blok::with('kebun')->orderBy('kode_blok')->get();

        // 5. Data Rekap Panen Saya (Tabel Bawah)
        $rekapPanen = HasilPanen::with('blok.kebun')
                        ->where('id_petugas', $idPekerja)
                        ->orderBy('tanggal_panen', 'desc')
                        ->take(5) // Ambil 5 data terbaru untuk rekap
                        ->get();

        return view('pekerja.dashboard', compact(
            'totalBerat', 'jumlahCatatan', 'jumlahBlok', 'jadwalHariIni',
            'grafikLabels', 'grafikData', 'catatanTerbaru', 'blokList', 'rekapPanen'
        ));
    }
}