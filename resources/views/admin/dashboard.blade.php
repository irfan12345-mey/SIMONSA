@extends('layouts.admin.app')

@section('content')
    {{-- Hero Section (Banner Utama BizLand) --}}
    <section id="hero" class="hero section light-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-8 d-flex flex-column justify-content-center" data-aos="zoom-out">
                    <h1>Selamat Datang di <span>SIMONSA</span></h1>
                    <p>Sistem Informasi Manajemen Data Pelanggan dan Pengguna</p>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/pelanggan') }}" class="btn-get-started">Kelola Pelanggan</a>
                        <a href="{{ url('/user') }}" class="btn btn-outline-primary d-flex align-items-center px-4">Kelola User</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section (Statistik Ringkas BizLand) --}}
    <section id="stats" class="stats section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">

                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-people"></i>
                    <div class="stats-item">
                        <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1" class="purecounter">150</span>
                        <p>Total Pelanggan</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-person-badge"></i>
                    <div class="stats-item">
                        <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter">12</span>
                        <p>Total User Admin</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-check-circle"></i>
                    <div class="stats-item">
                        <span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter">100</span>
                        <p>Sistem Aktif (%)</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Featured Services Section (Kartu Akses Cepat BizLand) --}}
    <section id="featured-services" class="featured-services section light-background">
        <div class="container">
            <div class="row gy-4">

                <div class="col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative w-100">
                        <div class="icon"><i class="bi bi-people-fill icon"></i></div>
                        <h4><a href="{{ url('/pelanggan') }}" class="stretched-link">Data Pelanggan</a></h4>
                        <p>Lihat, tambah, ubah, dan hapus seluruh informasi data pelanggan yang terdaftar.</p>
                    </div>
                </div>

                <div class="col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative w-100">
                        <div class="icon"><i class="bi bi-person-gear icon"></i></div>
                        <h4><a href="{{ url('/user') }}" class="stretched-link">Manajemen User</a></h4>
                        <p>Kelola akun pengguna dan hak akses administrator pada aplikasi SIMONSA.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
