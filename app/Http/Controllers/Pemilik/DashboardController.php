<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use PanenQuery;

    // P-01 Dashboard Produktivitas
    public function index(Request $r)
    {
        $this->defaultPeriode($r);

        $total  = (float) $this->panenQuery($r)->sum('h.berat_tbs_kg');
        $jumlah = $this->panenQuery($r)->count();

        $perBlok = $this->rekapPerBlok($r);

        // Produktivitas kg/ha hanya dihitung dari blok yang luasnya terisi (luas opsional).
        $berluas = $perBlok->filter(fn ($b) => $b->luas_hektare > 0);
        $kgPerHa = $berluas->sum('luas_hektare') > 0
            ? $berluas->sum('total') / $berluas->sum('luas_hektare') : null;

        $tren = $this->panenQuery($r)
            ->select('h.tanggal_panen', DB::raw('SUM(h.berat_tbs_kg) as total'))
            ->groupBy('h.tanggal_panen')->orderBy('h.tanggal_panen')->get();

        $perKebun = $this->panenQuery($r)
            ->select('k.nama_kebun', DB::raw('SUM(h.berat_tbs_kg) as total'))
            ->groupBy('k.id_kebun', 'k.nama_kebun')->orderByDesc('total')->get();

        $terbaru = $this->panenQuery($r)
            ->select('h.tanggal_panen', 'h.berat_tbs_kg', 'b.kode_blok', 'k.nama_kebun')
            ->orderByDesc('h.tanggal_panen')->orderByDesc('h.id_hasil')->limit(5)->get();

        return view('pemilik_kebun.dashboard', [
            'total' => $total,
            'jumlah' => $jumlah,
            'kgPerHa' => $kgPerHa,
            'totalKebun' => Kebun::where('id_pemilik', Auth::id())->count(),
            'totalBlok' => Blok::whereHas('kebun', fn ($q) => $q->where('id_pemilik', Auth::id()))->count(),
            'tren' => $tren,
            'perBlok' => $perBlok,
            'perKebun' => $perKebun,
            'terbaru' => $terbaru,
            'dari' => $r->dari,
            'sampai' => $r->sampai,
        ]);
    }
}
