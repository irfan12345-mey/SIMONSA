<?php

namespace App\Http\Controllers\Pemilik;

use App\Models\Blok;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Query bersama: semua data panen SELALU dibatasi ke kebun milik user yang login.
 */
trait PanenQuery
{
    protected function panenQuery(Request $r)
    {
        $q = DB::table('hasil_panen as h')
            ->join('blok as b', 'b.id_blok', '=', 'h.id_blok')
            ->join('kebun as k', 'k.id_kebun', '=', 'b.id_kebun')
            ->where('k.id_pemilik', Auth::id());

        if ($r->filled('dari'))     $q->whereDate('h.tanggal_panen', '>=', $r->dari);
        if ($r->filled('sampai'))   $q->whereDate('h.tanggal_panen', '<=', $r->sampai);
        if ($r->filled('id_kebun')) $q->where('k.id_kebun', $r->id_kebun);
        if ($r->filled('id_blok'))  $q->where('b.id_blok', $r->id_blok);

        return $q;
    }

    /** Pilihan "bulan" menimpa dari/sampai; jika kosong semua, default bulan ini. */
    protected function defaultPeriode(Request $r): void
    {
        if ($r->filled('bulan')) {
            $awal = \Carbon\Carbon::createFromFormat('Y-m', $r->bulan)->startOfMonth();
            $r->merge(['dari' => $awal->toDateString(), 'sampai' => $awal->copy()->endOfMonth()->toDateString()]);
        } else {
            $r->merge([
                'dari'   => $r->input('dari', now()->startOfMonth()->toDateString()),
                'sampai' => $r->input('sampai', now()->endOfMonth()->toDateString()),
            ]);
        }
    }

    protected function kebunMilik()
    {
        return Kebun::where('id_pemilik', Auth::id())->orderBy('nama_kebun')->get();
    }

    protected function blokMilik()
    {
        return Blok::with('kebun:id_kebun,nama_kebun')
            ->whereHas('kebun', fn ($q) => $q->where('id_pemilik', Auth::id()))
            ->orderBy('kode_blok')->get();
    }

    protected function rekapPerBlok(Request $r)
    {
        return $this->panenQuery($r)
            ->select('b.id_blok', 'b.kode_blok', 'b.nama_blok', 'b.luas_hektare', 'k.nama_kebun',
                DB::raw('SUM(h.berat_tbs_kg) as total'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('b.id_blok', 'b.kode_blok', 'b.nama_blok', 'b.luas_hektare', 'k.nama_kebun')
            ->orderByDesc('total')->get();
    }
}
