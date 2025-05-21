@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Dashboard Admin</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="bi bi-person-circle fs-3 text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Selamat datang, {{ Auth::user()->name }}!</h5>
                                    <p class="text-muted mb-0">Anda memiliki akses penuh ke semua fitur administrasi.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light mb-0">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi bi-calendar-date fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted">Tanggal Hari Ini</small>
                                            <div class="fw-bold">{{ now()->format('d F Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h5 class="mb-3">Navigasi Cepat:</h5>
                    <div class="list-group shadow-sm">
                        <a href="{{ route('admin.karyawan.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-people-fill text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Kelola Data Karyawan</h6>
                                <small class="text-muted">Tambah, edit, dan hapus data karyawan</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>
                        <a href="{{ route('admin.absensi.rekap') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-calendar-check text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Lihat Rekap Absensi</h6>
                                <small class="text-muted">Pantau kehadiran seluruh karyawan</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>
                        <a href="{{ route('admin.gaji.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-cash-coin text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Manajemen Penggajian</h6>
                                <small class="text-muted">Hitung dan kelola gaji karyawan</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="text-muted mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Untuk bantuan penggunaan sistem, silakan hubungi administrator.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection