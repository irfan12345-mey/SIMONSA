@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Monitoring Hasil Panen')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 bg-primary text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-normal">Total Panen (Sesuai Filter)</h5>
                    <h2 class="mb-0 fw-bold mt-2">{{ number_format($totalBerat, 2, ',', '.') }} Kg</h2>
                </div>
                <i class="bi bi-basket fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-activity me-2"></i>Data Monitoring Hasil Panen
        </h5>
    </div>
    <div class="card-body">
        {{-- Form Filter --}}
        <form action="{{ route('pemilik.monitoring') }}" method="GET" class="row g-3 mb-4 bg-light p-3 rounded border">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Pilih Kebun</label>
                <select name="id_kebun" class="form-select">
                    <option value="">-- Semua Kebun --</option>
                    @foreach($kebunList as $kebun)
                        <option value="{{ $kebun->id_kebun }}" {{ request('id_kebun') == $kebun->id_kebun ? 'selected' : '' }}>
                            {{ $kebun->nama_kebun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Filter</button>
                <a href="{{ route('pemilik.monitoring') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>

        {{-- Tabel Data --}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Tanggal</th>
                        <th>Nama Kebun</th>
                        <th>Kode Blok</th>
                        <th>Petugas</th>
                        <th class="text-end">Berat TBS (Kg)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hasilPanen as $index => $item)
                        <tr>
                            <td class="text-center">{{ $hasilPanen->firstItem() + $index }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_panen)->format('d/m/Y') }}</td>
                            <td>{{ $item->blok->kebun->nama_kebun ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $item->blok->kode_blok ?? '-' }}</span></td>
                            <td>{{ $item->petugas->nama ?? $item->petugas->username ?? '-' }}</td>
                            <td class="text-end fw-bold text-success">{{ number_format($item->berat_tbs_kg, 2, ',', '.') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Tidak ada data hasil panen yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $hasilPanen->links() }}
        </div>
    </div>
</div>
@endsection