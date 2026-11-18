@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Data Blok')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-grid me-2"></i>Daftar Blok Kebun
        </h5>
        <a href="{{ route('pemilik.blok.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Blok
        </a>
    </div>
    <div class="card-body">
        {{-- Form Filter Kebun --}}
        <form action="{{ route('pemilik.blok.index') }}" method="GET" class="mb-3 d-flex gap-2">
            <select name="id_kebun" class="form-select w-auto">
                <option value="">-- Semua Kebun --</option>
                @foreach ($kebunList as $k)
                    <option value="{{ $k->id_kebun }}" {{ request('id_kebun') == $k->id_kebun ? 'selected' : '' }}>
                        {{ $k->nama_kebun }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-outline-secondary">Filter</button>
            @if(request('id_kebun'))
                <a href="{{ route('pemilik.blok.index') }}" class="btn btn-outline-danger">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Kebun</th>
                        <th>Kode Blok</th>
                        <th>Nama Blok</th>
                        <th class="text-end">Luas (Ha)</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blok as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->kebun->nama_kebun ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $item->kode_blok }}</span></td>
                            <td class="fw-semibold">{{ $item->nama_blok ?? '-' }}</td>
                            <td class="text-end">{{ $item->luas_hektare ? number_format($item->luas_hektare, 2, ',', '.') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('pemilik.blok.edit', $item->id_blok) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('pemilik.blok.destroy', $item->id_blok) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus blok ini?')">
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
                                Belum ada data blok. Silakan klik tombol "Tambah Blok" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection