@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Riwayat Input Panen')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-clock-history me-2"></i>Riwayat Catatan Panen Saya
        </h5>
        <a href="{{ route('pekerja.hasil-panen.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Input Baru
        </a>
    </div>
    <div class="card-body">
        
        {{-- T-04: Form Pencarian & Filter --}}
        <form action="{{ route('pekerja.hasil-panen.index') }}" method="GET" class="row g-2 mb-4 bg-light p-3 rounded border align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Cari Tanggal</label>
                <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Pilih Blok</label>
                <select name="id_blok" class="form-select form-select-sm">
                    <option value="">-- Semua Blok --</option>
                    @foreach($blokList as $blok)
                        <option value="{{ $blok->id_blok }}" {{ request('id_blok') == $blok->id_blok ? 'selected' : '' }}>
                            {{ $blok->kebun->nama_kebun ?? '' }} - {{ $blok->kode_blok }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Cari Keterangan</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Kata kunci..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bi bi-search me-1"></i> Cari</button>
                <a href="{{ route('pekerja.hasil-panen.index') }}" class="btn btn-outline-secondary btn-sm w-100">Reset</a>
            </div>
        </form>

        {{-- T-02: Tabel Data Panen --}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Tanggal</th>
                        <th>Kebun / Blok</th>
                        <th class="text-end">Berat (Kg)</th>
                        <th>Keterangan</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatPanen as $index => $item)
                        <tr>
                            <td class="text-center">{{ $riwayatPanen->firstItem() + $index }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_panen)->format('d/m/Y') }}</td>
                            <td>
                                {{ $item->blok->kebun->nama_kebun ?? '-' }} <br>
                                <span class="badge bg-secondary">{{ $item->blok->kode_blok ?? '-' }}</span>
                            </td>
                            <td class="text-end fw-bold text-success">{{ number_format($item->berat_tbs_kg, 2, ',', '.') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                {{-- T-03: Tombol Edit --}}
                                <a href="{{ route('pekerja.hasil-panen.edit', $item->id_hasil) }}" class="btn btn-sm btn-outline-warning" title="Ubah Catatan">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Tidak ada catatan panen yang sesuai dengan pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $riwayatPanen->links() }}
        </div>
    </div>
</div>
@endsection