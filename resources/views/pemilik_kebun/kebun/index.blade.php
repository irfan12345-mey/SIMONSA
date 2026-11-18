@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Data Kebun')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-geo-alt me-2"></i>Daftar Kebun
        </h5>
        <a href="{{ route('pemilik.kebun.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kebun
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Kebun</th>
                        <th>Lokasi</th>
                        <th class="text-center">Jumlah Blok</th>
                        <th>Keterangan</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kebun as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $item->nama_kebun }}</td>
                            <td>{{ $item->lokasi ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">{{ $item->blok_count }} Blok</span>
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('pemilik.kebun.edit', $item->id_kebun) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('pemilik.kebun.destroy', $item->id_kebun) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kebun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada data kebun. Silakan klik tombol "Tambah Kebun" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection