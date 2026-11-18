<?php
namespace App\Http\Controllers\Pekerja;

use App\Http\Controllers\Controller;
use App\Models\HasilPanen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', now()->endOfMonth()->format('Y-m-d'));

        $query = HasilPanen::with('blok.kebun')->where('id_petugas', Auth::id())->whereBetween('tanggal_panen', [$tanggalAwal, $tanggalAkhir]);
        $laporanPanen = $query->orderBy('tanggal_panen', 'asc')->get();
        $totalBerat = $laporanPanen->sum('berat_tbs_kg');

        return view('pekerja.laporan.index', compact('laporanPanen', 'totalBerat', 'tanggalAwal', 'tanggalAkhir'));
    }
}