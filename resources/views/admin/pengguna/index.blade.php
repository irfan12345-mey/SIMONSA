@extends('layouts.admin.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Data Pengguna</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:60px">No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengguna as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->username }}</td>
                        <td>{{ ucfirst($p->role) }}</td>
                        <td>{{ ucfirst($p->status_akun) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection