@extends('layouts.pemilik_kebun.pemilik')

@section('title', isset($blok->id_blok) ? 'Edit Blok' : 'Tambah Blok')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-grid me-2"></i>
                    {{ isset($blok->id_blok) ? 'Edit Data Blok' : 'Tambah Data Blok' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($blok->id_blok) ? route('pemilik.blok.update', $blok->id_blok) : route('pemilik.blok.store') }}" method="POST">
                    @csrf
                    @if(isset($blok->id_blok))
                        @method('PUT')
                    @endif

                    {{-- Pilihan Kebun (Gunakan $kebunList sesuai Controller) --}}
                    <div class="mb-3">
                        <label for="id_kebun" class="form-label fw-semibold">Pilih Kebun <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_kebun') is-invalid @enderror" id="id_kebun" name="id_kebun" required>
                            <option value="">-- Pilih Kebun --</option>
                            @foreach ($kebunList as $k)
                                <option value="{{ $k->id_kebun }}" {{ old('id_kebun', $blok->id_kebun ?? '') == $k->id_kebun ? 'selected' : '' }}>
                                    {{ $k->nama_kebun }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kebun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kode dan Nama Blok --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_blok" class="form-label fw-semibold">Kode Blok <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_blok') is-invalid @enderror" 
                                   id="kode_blok" name="kode_blok" 
                                   value="{{ old('kode_blok', $blok->kode_blok ?? '') }}" 
                                   placeholder="Contoh: BLK-01" required>
                            @error('kode_blok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_blok" class="form-label fw-semibold">Nama Blok</label>
                            <input type="text" class="form-control @error('nama_blok') is-invalid @enderror" 
                                   id="nama_blok" name="nama_blok" 
                                   value="{{ old('nama_blok', $blok->nama_blok ?? '') }}" 
                                   placeholder="Contoh: Blok Utara">
                            @error('nama_blok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Luas Hektare --}}
                    <div class="mb-3">
                        <label for="luas_hektare" class="form-label fw-semibold">Luas (Hektare)</label>
                        <input type="number" step="0.01" class="form-control @error('luas_hektare') is-invalid @enderror" 
                               id="luas_hektare" name="luas_hektare" 
                               value="{{ old('luas_hektare', $blok->luas_hektare ?? '') }}" 
                               placeholder="Contoh: 2.5">
                        <div class="form-text">Luas dipakai untuk menghitung produktivitas kg/ha di dashboard.</div>
                        @error('luas_hektare')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('pemilik.blok.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection