@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Ubah Catatan Panen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-warning">
                    <i class="bi bi-pencil-square me-2"></i>Ubah Catatan Panen (T-03)
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pekerja.hasil-panen.update', $hasilPanen->id_hasil) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Wajib untuk proses update --}}

                    <div class="mb-3">
                        <label for="tanggal_panen" class="form-label fw-semibold">Tanggal Panen <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_panen" id="tanggal_panen" 
                               class="form-control @error('tanggal_panen') is-invalid @enderror" 
                               value="{{ old('tanggal_panen', $hasilPanen->tanggal_panen) }}" required>
                        @error('tanggal_panen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_blok" class="form-label fw-semibold">Pilih Blok <span class="text-danger">*</span></label>
                        <select name="id_blok" id="id_blok" class="form-select @error('id_blok') is-invalid @enderror" required>
                            @foreach($blokList as $blok)
                                <option value="{{ $blok->id_blok }}" {{ old('id_blok', $hasilPanen->id_blok) == $blok->id_blok ? 'selected' : '' }}>
                                    {{ $blok->kebun->nama_kebun ?? '' }} - {{ $blok->kode_blok }} ({{ $blok->nama_blok }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_blok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="berat_tbs_kg" class="form-label fw-semibold">Berat TBS (Kg) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="berat_tbs_kg" id="berat_tbs_kg" 
                                   class="form-control @error('berat_tbs_kg') is-invalid @enderror" 
                                   value="{{ old('berat_tbs_kg', $hasilPanen->berat_tbs_kg) }}" required>
                            <span class="input-group-text bg-light">Kg</span>
                            @error('berat_tbs_kg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" rows="3" 
                                  class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $hasilPanen->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pekerja.hasil-panen.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection