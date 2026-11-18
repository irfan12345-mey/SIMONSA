<?php
namespace App\Http\Controllers\Pekerja;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\HasilPanen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilPanenController extends Controller
{
    public function index(Request $request)
    {
        $query = HasilPanen::with('blok.kebun')->where('id_petugas', Auth::id());
        if ($request->filled('tanggal')) $query->whereDate('tanggal_panen', $request->tanggal);
        if ($request->filled('id_blok')) $query->where('id_blok', $request->id_blok);
        if ($request->filled('search')) $query->where('keterangan', 'like', '%' . $request->search . '%');

        $riwayatPanen = $query->orderBy('tanggal_panen', 'desc')->paginate(10)->withQueryString();
        $blokList = Blok::with('kebun')->orderBy('kode_blok')->get();
        return view('pekerja.hasil-panen.index', compact('riwayatPanen', 'blokList'));
    }

    public function create()
    {
        $blokList = Blok::with('kebun')->orderBy('kode_blok')->get();
        return view('pekerja.hasil-panen.create', compact('blokList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_blok' => 'required|exists:blok,id_blok',
            'tanggal_panen' => 'required|date|before_or_equal:today',
            'berat_tbs_kg' => 'required|numeric|min:0.1',
            'keterangan' => 'nullable|string|max:255'
        ]);
        HasilPanen::create(['id_blok' => $validated['id_blok'], 'id_petugas' => Auth::id(), 'tanggal_panen' => $validated['tanggal_panen'], 'berat_tbs_kg' => $validated['berat_tbs_kg'], 'keterangan' => $validated['keterangan']]);
        return redirect()->route('pekerja.hasil-panen.index')->with('success', 'Data berhasil dicatat!');
    }

    public function edit($id)
    {
        $hasilPanen = HasilPanen::where('id_petugas', Auth::id())->findOrFail($id);
        $blokList = Blok::with('kebun')->orderBy('kode_blok')->get();
        return view('pekerja.hasil-panen.edit', compact('hasilPanen', 'blokList'));
    }

    public function update(Request $request, $id)
    {
        $hasilPanen = HasilPanen::where('id_petugas', Auth::id())->findOrFail($id);
        $validated = $request->validate([
            'id_blok' => 'required|exists:blok,id_blok',
            'tanggal_panen' => 'required|date|before_or_equal:today',
            'berat_tbs_kg' => 'required|numeric|min:0.1',
            'keterangan' => 'nullable|string|max:255'
        ]);
        $hasilPanen->update($validated);
        return redirect()->route('pekerja.hasil-panen.index')->with('success', 'Data berhasil diperbarui!');
    }
}