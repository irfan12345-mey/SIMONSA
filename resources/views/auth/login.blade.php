<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - SIMONSA</title>

    {{-- Memanggil CSS BizLand yang sudah dibuat --}}
    @include('layouts.admin.css')
</head>

<body class="index-page light-background">

    <main class="main d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">

                    {{-- Logo / Nama Aplikasi --}}
                    <div class="text-center mb-4">
                        <a href="{{ url('/') }}" class="text-decoration-none">
                            <h1 class="h2 fw-bold text-primary mb-1">SIMONSA</h1>
                        </a>
                        <p class="text-muted">Silakan masuk ke akun Anda</p>
                    </div>

                    {{-- Card Form Login --}}
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4 p-md-5">

                            {{-- Alert jika login gagal atau ada pesan error --}}
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ url('/login') }}" method="POST">
                                @csrf

                                {{-- Input Username --}}
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-medium">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                        <input type="text" name="username" id="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                                    </div>
                                </div>

                                {{-- Input Password --}}
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-medium">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password" required>
                                    </div>
                                </div>

                                {{-- Tombol Submit --}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2 fw-semibold">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="text-center mt-4 text-muted small">
                        © Copyright <strong>SIMONSA</strong>. All Rights Reserved
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- Memanggil JS BizLand --}}
    @include('layouts.admin.js')

</body>

</html>
