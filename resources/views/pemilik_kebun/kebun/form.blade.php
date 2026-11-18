@extends('layouts.pemilik_kebun.pemilik')

@section('title', isset($kebun->id_kebun) ? 'Edit Kebun' : 'Tambah Kebun')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-pencil-square me-2"></i>
                    {{ isset($kebun->id_kebun) ? 'Edit Data Kebun' : 'Tambah Data Kebun' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($kebun->id_kebun) ? route('pemilik.kebun.update', $kebun->id_kebun) : route('pemilik.kebun.store') }}" method="POST">
                    @csrf
                    @if(isset($kebun->id_kebun))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="nama_kebun" class="form-label fw-semibold">Nama Kebun <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kebun') is-invalid @enderror" 
                               id="nama_kebun" name="nama_kebun" 
                               value="{{ old('nama_kebun', $kebun->nama_kebun ?? '') }}" 
                               placeholder="Contoh: Kebun Utama" required>
                        @error('nama_kebun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label fw-semibold">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                               id="lokasi" name="lokasi" 
                               value="{{ old('lokasi', $kebun->lokasi ?? '') }}" 
                               placeholder="Contoh: Desa Sukamaju, Kec. Cianjur">
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3" 
                                  placeholder="Catatan tambahan (opsional)">{{ old('keterangan', $kebun->keterangan ?? '') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('pemilik.kebun.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection