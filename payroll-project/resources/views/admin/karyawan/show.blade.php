@extends('layouts.app')

@section('title', 'Detail Karyawan: ' . $karyawan->user->name)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Detail Karyawan: {{ $karyawan->user->name }}</h3>
        <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Akun Login</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th style="width: 30%;">Nama</th>
                            <td>: {{ $karyawan->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $karyawan->user->email }}</td>
                        </tr>
                         <tr>
                            <th>Role</th>
                            <td>: <span class="badge bg-info">{{ ucfirst($karyawan->user->role) }}</span></td>
                        </tr>
                         <tr>
                            <th>Akun Dibuat</th>
                            <td>: {{ $karyawan->user->created_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Informasi Detail Karyawan</h5>
                     <table class="table table-borderless table-sm">
                        <tr>
                            <th style="width: 30%;">NIK</th>
                            <td>: {{ $karyawan->nik }}</td>
                        </tr>
                        <tr>
                            <th>Posisi</th>
                            <td>: {{ $karyawan->posisi }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <td>: {{ $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->isoFormat('D MMMM YYYY') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>: {{ $karyawan->no_telepon ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: {{ $karyawan->alamat ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Gaji Pokok</th>
                            <td>: Rp {{ number_format($karyawan->gaji_pokok, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <div class="text-end">
                 <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit Data</a>
            </div>
        </div>
    </div>

    {{-- Opsional: Tampilkan Riwayat Absensi atau Gaji Terkait Karyawan ini --}}
    {{-- <div class="card mt-4">
        <div class="card-header">Riwayat Absensi Terakhir</div>
        <div class="card-body">
            ... (Loop data absensi $karyawan->absensi()->latest()->take(5)->get()) ...
        </div>
    </div> --}}
</div>
@endsection