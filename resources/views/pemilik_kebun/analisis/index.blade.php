@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Analisis Produktivitas')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-funnel me-2"></i>Filter Analisis</h5>
                <form action="{{ route('pemilik.analisis') }}" method="GET" class="row g-3 align-items-end">
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
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Dari Tanggal</label>
                        <input type="date" name="tanggal_awal" class="form-control" value="{{ $tanggalAwal }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Sampai Tanggal</label>
                        <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Terapkan Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Ringkasan Tertinggi & Terendah --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 border-start border-4 border-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-semibold mb-1">Produksi Tertinggi</h6>
                        <h4 class="fw-bold text-success mb-0">{{ $tertinggi->kode_blok ?? '-' }} - {{ $tertinggi->nama_blok ?? 'Belum ada data' }}</h4>
                        <p class="mb-0 text-muted">{{ $tertinggi->nama_kebun ?? '' }}</p>
                    </div>
                    <div class="text-end">
                        <h3 class="fw-bold mb-0">{{ $tertinggi ? number_format($tertinggi->total_berat, 2, ',', '.') : 0 }}</h3>
                        <span class="text-muted small">Kg</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 border-start border-4 border-danger h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-semibold mb-1">Produksi Terendah</h6>
                        <h4 class="fw-bold text-danger mb-0">{{ $terendah->kode_blok ?? '-' }} - {{ $terendah->nama_blok ?? 'Belum ada data' }}</h4>
                        <p class="mb-0 text-muted">{{ $terendah->nama_kebun ?? '' }}</p>
                    </div>
                    <div class="text-end">
                        <h3 class="fw-bold mb-0">{{ $terendah ? number_format($terendah->total_berat, 2, ',', '.') : 0 }}</h3>
                        <span class="text-muted small">Kg</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik Perbandingan --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-bar-chart-fill me-2"></i>Grafik Perbandingan Hasil Panen Antar Blok</h5>
    </div>
    <div style="position: relative; height:400px; width:100%">
        <canvas id="chartPerbandingan"
            data-labels="{{ json_encode($labels) }}"
            data-panen="{{ json_encode($dataPanen) }}">
        </canvas>
    </div>
</div>

{{-- Tabel Rincian --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-table me-2"></i>Rincian Hasil Panen</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">Peringkat</th>
                        <th>Kebun</th>
                        <th>Kode Blok</th>
                        <th>Nama Blok</th>
                        <th class="text-end">Total Panen (Kg)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataAnalisis as $index => $item)
                    <tr>
                        <td class="text-center fw-bold">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_kebun }}</td>
                        <td><span class="badge bg-secondary">{{ $item->kode_blok }}</span></td>
                        <td>{{ $item->nama_blok }}</td>
                        <td class="text-end fw-bold">{{ number_format($item->total_berat, 2, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Tidak ada data panen pada periode ini.</td>
                    </tr>
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
        const canvas = document.getElementById('chartPerbandingan');
        if (!canvas) return; // Pengaman jika canvas tidak ada

        const ctx = canvas.getContext('2d');
        
        // Ambil data dari atribut HTML, bukan langsung dari PHP
        // Ini trik agar VS Code tidak error dan grafik tetap muncul
        const rawLabels = canvas.dataset.labels;
        const rawPanen = canvas.dataset.panen;

        // Ubah string JSON kembali menjadi Array/Object JavaScript
        const labels = rawLabels ? JSON.parse(rawLabels) : [];
        const dataPanen = rawPanen ? JSON.parse(rawPanen) : [];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Panen (Kg)',
                    data: dataPanen,
                    backgroundColor: 'rgba(25, 135, 84, 0.7)', // Warna hijau
                    borderColor: 'rgba(25, 135, 84, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID') + ' Kg';
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString('id-ID') + ' Kg';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush