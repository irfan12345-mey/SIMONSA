
@extends('layouts.pemilik_kebun.pemilik')

@section('title', 'Dashboard')

@section('content')

{{-- HERO SECTION --}}
<section id="hero" class="hero section light-background">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-8 d-flex flex-column justify-content-center">
                <h1>
                    Selamat Datang di <span>SIMONSA</span>
                </h1>

                <p>
                    Sistem Informasi Manajemen Kebun dan Produktivitas Panen
                </p>

                <div class="d-flex gap-2">
                    <a href="{{ route('pemilik.monitoring') }}"
                       class="btn-get-started">
                        Monitoring Panen
                    </a>

                    <a href="{{ route('pemilik.analisis') }}"
                       class="btn btn-outline-primary d-flex align-items-center px-4">
                        Lihat Analisis
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATISTIK --}}
<section id="stats" class="stats section">
    <div class="container">
        <div class="row gy-4">

            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                <i class="bi bi-box-seam"></i>
                <div class="stats-item">
                    <span>{{ number_format($total ?? 0, 0, ',', '.') }}</span>
                    <p>Total Hasil Panen (kg)</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                <i class="bi bi-clipboard-data"></i>
                <div class="stats-item">
                    <span>{{ number_format($jumlah ?? 0, 0, ',', '.') }}</span>
                    <p>Jumlah Catatan Panen</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                <i class="bi bi-tree"></i>
                <div class="stats-item">
                    <span>{{ $totalKebun ?? 0 }}</span>
                    <p>Total Kebun</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- AKSES FITUR --}}
<section id="featured-services" class="featured-services section light-background">
    <div class="container">
        <div class="row gy-4">

            <div class="col-md-6 d-flex">
                <div class="service-item position-relative w-100">
                    <div class="icon">
                        <i class="bi bi-geo-alt icon"></i>
                    </div>
                    <h4>
                        <a href="{{ route('pemilik.monitoring') }}">
                            Monitoring Panen
                        </a>
                    </h4>
                    <p>
                        Lihat dan pantau seluruh catatan hasil panen
                        berdasarkan tanggal, kebun, dan blok.
                    </p>
                </div>
            </div>

            <div class="col-md-6 d-flex">
                <div class="service-item position-relative w-100">
                    <div class="icon">
                        <i class="bi bi-bar-chart-line icon"></i>
                    </div>
                    <h4>
                        <a href="{{ route('pemilik.analisis') }}">
                            Analisis Produktivitas
                        </a>
                    </h4>
                    <p>
                        Lihat perkembangan dan perbandingan
                        produktivitas hasil panen kebun.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
