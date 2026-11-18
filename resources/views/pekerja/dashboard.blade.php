@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Dashboard Pekerja Panen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Dashboard Pekerja Panen</h4>
        <p class="text-muted small mb-0">Selamat datang, {{ Auth::user()->nama }}. Berikut ringkasan aktivitas Anda.</p>
    </div>
</div>

{{-- 4 Kartu Ringkasan (Sesuai Proposal) --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-success text-white h-100">
            <div class="card-body">
                <h6 class="mb-1 opacity-75 text-uppercase fw-semibold" style="font-size: 0.8rem;">Total Panen</h6>
                <h3 class="fw-bold mb-0">{{ number_format($totalBerat, 2, ',', '.') }} <small class="fs-6">Kg</small></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-white text-dark h-100 border-start border-4 border-primary">
            <div class="card-body">
                <h6 class="mb-1 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">Jumlah Catatan</h6>
                <h3 class="fw-bold mb-0">{{ $jumlahCatatan }} <small class="fs-6 text-muted">Data</small></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-white text-dark h-100 border-start border-4 border-warning">
            <div class="card-body">
                <h6 class="mb-1 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">Blok Diinput</h6>
                <h3 class="fw-bold mb-0">{{ $jumlahBlok }} <small class="fs-6 text-muted">Blok</small></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-white text-dark h-100 border-start border-4 border-info">
            <div class="card-body">
                <h6 class="mb-1 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">Jadwal Panen</h6>
                <h3 class="fw-bold mb-0">{{ $jadwalHariIni }} <small class="fs-6 text-muted">Lokasi</small></h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- KIRI: Grafik & Form Input Cepat --}}
    <div class="col-md-8 mb-4">
        
        {{-- Grafik 7 Hari --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-graph-up-arrow me-2"></i>Grafik Hasil Panen 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 250px; width: 100%;">
                    <canvas id="grafikPekerja" 
                            data-labels="{{ json_encode($grafikLabels) }}" 
                            data-panen="{{ json_encode($grafikData) }}"></canvas>
                </div>
            </div>
        </div>

        {{-- Form Input Cepat (Sesuai Proposal) --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-success"><i class="bi bi-plus-circle me-2"></i>Form Pencatatan Panen Cepat</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pekerja.hasil-panen.store') }}" method="POST">
                    @csrf
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tanggal Panen</label>
                            <input type="date" name="tanggal_panen" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pilih Blok</label>
                            <select name="id_blok" class="form-select form-select-sm" required>
                                <option value="">-- Pilih Blok --</option>
                                @foreach($blokList as $blok)
                                    <option value="{{ $blok->id_blok }}">{{ $blok->kebun->nama_kebun ?? '' }} - {{ $blok->kode_blok }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Berat TBS (Kg)</label>
                            <input type="number" step="0.01" name="berat_tbs_kg" class="form-control form-control-sm" placeholder="Contoh: 1500" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control form-control-sm" placeholder="Opsional">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success btn-sm px-4"><i class="bi bi-save me-1"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- KANAN: Tabel Catatan Terbaru & Peta/Ringkasan --}}
    <div class="col-md-4 mb-4">
        
        {{-- Catatan Terbaru --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-clock-history me-2"></i>Catatan Terbaru</h6>
                <a href="{{ route('pekerja.hasil-panen.index') }}" class="text-decoration-none small">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Blok</th>
                                <th class="text-end">Berat (Kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($catatanTerbaru as $item)
                                <tr>
                                    <td class="small">{{ \Carbon\Carbon::parse($item->tanggal_panen)->format('d/m/Y') }}</td>
                                    <td class="small fw-semibold">{{ $item->blok->kode_blok ?? '-' }}</td>
                                    <td class="text-end fw-bold text-success">{{ number_format($item->berat_tbs_kg, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kotak Pengganti Peta (Sesuai Proposal) --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-map me-2"></i>Info Lokasi / Peta</h6>
            </div>
            <div class="card-body text-center">
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px; border: 2px dashed #ccc;">
                    <div>
                        <i class="bi bi-geo-alt fs-1 text-muted"></i>
                        <p class="text-muted small mb-0">Peta Lokasi Kebun<br>(Placeholder)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Rekap Panen Bawah (Sesuai Proposal) --}}
<div class="card shadow-sm border-0 mt-2">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-table me-2"></i>Rekap Panen Saya</h6>
        <a href="{{ route('pekerja.laporan') }}" class="text-decoration-none small">Lihat Laporan Lengkap</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kebun</th>
                        <th>Blok</th>
                        <th class="text-end">Berat (Kg)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapPanen as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_panen)->format('d/m/Y') }}</td>
                            <td>{{ $item->blok->kebun->nama_kebun ?? '-' }}</td>
                            <td>{{ $item->blok->kode_blok ?? '-' }}</td>
                            <td class="text-end fw-bold">{{ number_format($item->berat_tbs_kg, 0, ',', '.') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('grafikPekerja');
        if (!canvas) return;
        
        const labels = JSON.parse(canvas.dataset.labels);
        const dataPanen = JSON.parse(canvas.dataset.panen);

        new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Berat Panen (Kg)',
                    data: dataPanen,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#198754'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { callback: function(value) { return value + ' Kg'; } }
                    }
                }
            }
        });
    });
</script>
@endpush