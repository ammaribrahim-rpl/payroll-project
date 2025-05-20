@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Selamat Datang, {{ Auth::user()->name }}!</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5>Presensi Hari Ini ({{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }})</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @php
                                $karyawan = Auth::user()->karyawan;
                                $absensiHariIni = $karyawan ? $karyawan->absensi()->whereDate('tanggal', today())->first() : null;
                            @endphp

                            @if (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                                <form method="POST" action="{{ route('karyawan.absensi.masuk') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-box-arrow-in-right"></i> Presensi Masuk
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-success w-100" disabled>
                                    <i class="bi bi-check-circle"></i> Sudah Presensi Masuk ({{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') }})
                                </button>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                             @if ($absensiHariIni && $absensiHariIni->jam_masuk && !$absensiHariIni->jam_pulang)
                                <form method="POST" action="{{ route('karyawan.absensi.pulang') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-box-arrow-left"></i> Presensi Pulang
                                    </button>
                                </form>
                            @elseif($absensiHariIni && $absensiHariIni->jam_pulang)
                                <button type="button" class="btn btn-danger w-100" disabled>
                                     <i class="bi bi-check-circle"></i> Sudah Presensi Pulang ({{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i') }})
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary w-100" disabled>
                                    Presensi Pulang (Belum Masuk)
                                </button>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <a href="{{ route('karyawan.absensi.riwayat') }}" class="btn btn-info"><i class="bi bi-clock-history"></i> Lihat Riwayat Absensi Saya</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection