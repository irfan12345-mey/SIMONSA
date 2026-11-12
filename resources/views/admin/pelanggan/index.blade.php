@extends('layouts.admin.app')

@section('content')
    {{-- Start Main Content --}}
    <section class="section">
        <div class="container">

            {{-- Breadcrumb & Judul Halaman --}}
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">
                                <i class="bi bi-house-door"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h1 class="h3 mb-1">Data Pelanggan</h1>
                        <p class="text-muted mb-0">List data seluruh pelanggan</p>
                    </div>
                    <div>
                        <a href="{{ route('pelanggan.create') }}" class="btn btn-success text-white">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Pelanggan
                        </a>
                    </div>
                </div>
            </div>

            {{-- Pesan Alert Flash Data --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Tabel Data Pelanggan --}}
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table-pelanggan" class="table table-hover align-middle text-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Birthday</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataPelanggan as $item)
                                            <tr>
                                                <td>{{ $item->first_name }}</td>
                                                <td>{{ $item->last_name }}</td>
                                                <td>{{ $item->birthday }}</td>
                                                <td>{{ $item->gender }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('pelanggan.edit', $item->pelanggan_id) }}"
                                                        class="btn btn-info btn-sm text-white">
                                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('pelanggan.destroy', $item->pelanggan_id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus data pelanggan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    Belum ada data pelanggan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    {{-- End Main Content --}}
@endsection
