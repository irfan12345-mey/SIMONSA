@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Laporan Hasil Panen')

@push('styles')
<style>
    @media print {
        /* Sembunyikan form filter dan tombol saat dicetak */
        .no-print { display: none !important; }
        /* Sesuaikan margin kertas */
        body { margin: 0; padding: 0; background: white; }
        .card { border: none !important; box-shadow: none !important; }
        .card-header { background: white !important; border-bottom: 2px solid #000 !important; }
    }
</style>
@endpush

@section('content')
{{-- Header Laporan (Hanya muncul saat di-print) --}}
<div class="d-none d-print-block text-center mb-4">
    <h3 class="fw-bold mb-1">LAPORAN HASIL PANEN KELAPA SAWIT</h3>
    <h5 class="mb-1">SIMONSA (Sistem Informasi Monitoring Sawit)</h5>
    <p class="mb-0">Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}</p>
    <hr>
</div>

{{-- Form Filter (Disembunyikan saat print) --}}
<div class="card shadow-sm border-0 mb-4 no-print">
    <div class="card-body">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-funnel me-2"></i>Filter Laporan</h5>
        <form action="{{ route('pemilik.laporan') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Kebun</label>
                <select name="id_kebun" class="form-select">
                    <option value="">-- Semua Kebun --</option>
                    @foreach($kebunList as $kebun)
                        <option value="{{ $kebun->id_kebun }}" {{ request('id_kebun') == $kebun->id_kebun ? 'selected' : '' }}>
                            {{ $kebun->nama_kebun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Blok</label>
                <select name="id_blok" class="form-select">
                    <option value="">-- Semua Blok --</option>
                    @foreach($blokList as $blok)
                        <option value="{{ $blok->id_blok }}" {{ request('id_blok') == $blok->id_blok ? 'selected' : '' }}>
                            {{ $blok->kode_blok }} - {{ $blok->nama_blok }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Tgl Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" value="{{ $tanggalAwal }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Tgl Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Filter</button>
                <a href="{{ route('pemilik.laporan') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Hasil Laporan --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-file-earmark-text me-2"></i>Data Hasil Panen
        </h5>
        <button onclick="window.print()" class="btn btn-success no-print">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Tanggal</th>
                        <th>Kebun</th>
                        <th>Blok</th>
                        <th>Petugas</th>
                        <th class="text-end">Berat TBS (Kg)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_panen)->format('d/m/Y') }}</td>
                            <td>{{ $item->blok->kebun->nama_kebun ?? '-' }}</td>
                            <td>{{ $item->blok->kode_blok ?? '-' }}</td>
                            <td>{{ $item->petugas->nama ?? $item->petugas->username ?? '-' }}</td>
                            <td class="text-end">{{ number_format($item->berat_tbs_kg, 2, ',', '.') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Tidak ada data hasil panen pada periode dan filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                {{-- Baris Total --}}
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5" class="text-end">TOTAL KESELURUHAN</th>
                        <th class="text-end text-success fw-bold">{{ number_format($totalBerat, 2, ',', '.') }} Kg</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        {{-- Tanda Tangan (Hanya muncul saat print) --}}
        <div class="d-none d-print-block mt-5 row">
            <div class="col-6 offset-6 text-center">
                <p class="mb-5">Mengetahui,<br>Pemilik Kebun</p>
                <p class="fw-bold text-decoration-underline">{{ Auth::user()->nama ?? Auth::user()->username }}</p>
            </div>
        </div>
    </div>
</div>
@endsection