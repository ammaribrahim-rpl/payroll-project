@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4>Dashboard Admin</h4></div>
                <div class="card-body">
                    <p>Selamat datang, {{ Auth::user()->name }}!</p>
                    <p>Anda memiliki akses penuh ke semua fitur administrasi.</p>
                    <hr>
                    <h5>Navigasi Cepat:</h5>
                    <div class="list-group">
                        <a href="{{ route('admin.karyawan.index') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-people-fill"></i> Kelola Data Karyawan
                        </a>
                        <a href="{{ route('admin.absensi.rekap') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-calendar-check"></i> Lihat Rekap Absensi
                        </a>
                        <a href="{{ route('admin.gaji.index') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-cash-coin"></i> Manajemen Penggajian
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection