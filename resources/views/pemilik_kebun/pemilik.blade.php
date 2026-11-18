<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Dashboard') - SIMONSA</title>
    @include('layouts.admin.css')
    <style>
        .stat-num {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 0.25rem;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="light-background">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top no-print">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/"><i class="bi bi-tree me-1"></i> SIMONSA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if(Auth::user()->role === 'pemilik')
                    {{-- MENU PEMILIK --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('pemilik.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pemilik.kebun.*') ? 'active fw-semibold' : '' }}" href="{{ route('pemilik.kebun.index') }}">
                            <i class="bi bi-geo-alt me-1"></i> Data Kebun
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pemilik.blok.*') ? 'active fw-semibold' : '' }}" href="{{ route('pemilik.blok.index') }}">
                            <i class="bi bi-grid me-1"></i> Data Blok
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pemilik.monitoring') ? 'active fw-semibold' : '' }}" href="{{ route('pemilik.monitoring') }}">
                            <i class="bi bi-activity me-1"></i> Monitoring
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pemilik.analisis') ? 'active fw-semibold' : '' }}" href="{{ route('pemilik.analisis') }}">
                            <i class="bi bi-bar-chart-line me-1"></i> Analisis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pemilik.laporan') ? 'active fw-semibold' : '' }}" href="{{ route('pemilik.laporan') }}">
                            <i class="bi bi-file-earmark-text me-1"></i> Laporan
                        </a>
                    </li>

                    @elseif(Auth::user()->role === 'pekerja')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pekerja.dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('pekerja.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pekerja.hasil-panen.index') ? 'active fw-semibold' : '' }}" href="{{ route('pekerja.hasil-panen.index') }}">
                            <i class="bi bi-list-check me-1"></i> Riwayat Panen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pekerja.laporan') ? 'active fw-semibold' : '' }}" href="{{ route('pekerja.laporan') }}">
                            <i class="bi bi-file-earmark-text me-1"></i> Laporan
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="d-flex align-items-center gap-3 text-white">
                    <span class="small"><i class="bi bi-person-circle me-1"></i> {{ Auth::user()->nama ?? Auth::user()->username }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <main class="container py-4 min-vh-100">
        @if (session('success')) <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
        @if (session('error')) <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
        @yield('content')
    </main>
    <footer class="bg-white border-top py-3 text-center text-muted small no-print">© Copyright <strong>SIMONSA</strong>. All Rights Reserved</footer>
    @include('layouts.admin.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>