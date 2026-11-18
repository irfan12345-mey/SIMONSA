<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlokController extends Controller
{
    // P-03 Kelola Data Blok
    public function index(Request $r)
    {
        $blok = Blok::with('kebun:id_kebun,nama_kebun')->withCount('hasilPanen')
            ->whereHas('kebun', fn ($q) => $q->where('id_pemilik', Auth::id()))
            ->when($r->filled('id_kebun'), fn ($q) => $q->where('id_kebun', $r->id_kebun))
            ->orderBy('id_kebun')->orderBy('kode_blok')->get();

        return view('pemilik_kebun.blok.index', [
            'blok' => $blok,
            'kebunList' => $this->kebunMilik(),
        ]);
    }

    public function create()
    {
        return view('pemilik_kebun.blok.form', ['blok' => new Blok, 'kebunList' => $this->kebunMilik()]);
    }

    public function store(Request $r)
    {
        Blok::create($this->validated($r));
        return redirect()->route('pemilik.blok.index')->with('success', 'Blok berhasil ditambahkan.');
    }

    public function edit(Blok $blok)
    {
        $this->milikSaya($blok);
        return view('pemilik_kebun.blok.form', ['blok' => $blok, 'kebunList' => $this->kebunMilik()]);
    }

    public function update(Request $r, Blok $blok)
    {
        $this->milikSaya($blok);
        $blok->update($this->validated($r, $blok));
        return redirect()->route('pemilik.blok.index')->with('success', 'Blok berhasil diperbarui.');
    }

    public function destroy(Blok $blok)
    {
        $this->milikSaya($blok);

        if ($blok->hasilPanen()->exists()) {
            return back()->with('error', 'Blok tidak bisa dihapus karena sudah memiliki catatan panen.');
        }

        $blok->delete();
        return back()->with('success', 'Blok berhasil dihapus.');
    }

    private function kebunMilik()
    {
        return Kebun::where('id_pemilik', Auth::id())->orderBy('nama_kebun')->get();
    }

    private function milikSaya(Blok $blok): void
    {
        abort_unless($blok->kebun && $blok->kebun->id_pemilik == Auth::id(), 403);
    }

    private function validated(Request $r, ?Blok $blok = null): array
    {
        return $r->validate([
            // id_kebun harus milik user yang login
            'id_kebun' => ['required', Rule::exists('kebun', 'id_kebun')->where('id_pemilik', Auth::id())],
            'kode_blok' => ['required', 'string', 'max:20',
                Rule::unique('blok', 'kode_blok')->where('id_kebun', $r->id_kebun)->ignore($blok?->id_blok, 'id_blok')],
            'nama_blok' => 'nullable|string|max:100',
            'luas_hektare' => 'nullable|numeric|min:0|max:99999999.99',
        ]);
    }
}
