<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KebunController extends Controller
{
    // P-02 Kelola Data Kebun
    public function index()
    {
        $kebun = Kebun::withCount('blok')->where('id_pemilik', Auth::id())->orderBy('nama_kebun')->get();
        return view('pemilik_kebun.kebun.index', compact('kebun'));
    }

    public function create()
    {
        return view('pemilik_kebun.kebun.form', ['kebun' => new Kebun]);
    }

    public function store(Request $r)
    {
        Kebun::create($this->validated($r) + ['id_pemilik' => Auth::id()]);
        return redirect()->route('pemilik.kebun.index')->with('success', 'Kebun berhasil ditambahkan.');
    }

    public function edit(Kebun $kebun)
    {
        $this->milikSaya($kebun);
        return view('pemilik_kebun.kebun.form', compact('kebun'));
    }

    public function update(Request $r, Kebun $kebun)
    {
        $this->milikSaya($kebun);
        $kebun->update($this->validated($r));
        return redirect()->route('pemilik.kebun.index')->with('success', 'Kebun berhasil diperbarui.');
    }

    public function destroy(Kebun $kebun)
    {
        $this->milikSaya($kebun);

        if ($kebun->blok()->exists()) {
            return back()->with('error', 'Kebun tidak bisa dihapus karena masih memiliki blok. Hapus blok terlebih dahulu.');
        }

        $kebun->delete();
        return back()->with('success', 'Kebun berhasil dihapus.');
    }

    private function milikSaya(Kebun $kebun): void
    {
        abort_unless($kebun->id_pemilik == Auth::id(), 403);
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'nama_kebun' => 'required|string|max:100',
            'lokasi'     => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
    }
}
