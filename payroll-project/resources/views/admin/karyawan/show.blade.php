@extends('layouts.app')

@section('title', 'Detail Karyawan: ' . $karyawan->user->name)

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Detail Karyawan: {{ $karyawan->user->name }}</h3>
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
        
        <div class="card-body p-4">
            <div class="row">
                <!-- Profile Summary -->
                <div class="col-md-12 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle p-3 me-3">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">{{ $karyawan->user->name }}</h4>
                            <p class="text-muted mb-0">{{ $karyawan->posisi }} | NIK: {{ $karyawan->nik }}</p>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> Edit Data
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-person-badge text-primary me-2"></i>
                                Informasi Akun Login
                            </h5>
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
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-file-earmark-person text-primary me-2"></i>
                                Informasi Detail Karyawan
                            </h5>
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
                                    <td>: <strong class="text-success">Rp {{ number_format($karyawan->gaji_pokok, 2, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Terakhir diperbarui: {{ $karyawan->updated_at->diffForHumans() }}</small>
                </div>
                <div>
                    <a href="{{ route('admin.absensi.rekap') }}?karyawan_id={{ $karyawan->id }}" class="btn btn-sm btn-outline-primary me-2">
                        <i class="bi bi-calendar-check"></i> Lihat Absensi
                    </a>
                    <a href="{{ route('admin.gaji.index') }}?karyawan_id={{ $karyawan->id }}" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-cash-coin"></i> Lihat Gaji
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Opsional: Tampilkan Riwayat Absensi atau Gaji Terkait Karyawan ini --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <h5 class="mb-0">Riwayat Absensi Terakhir</h5>
        </div>
        <div class="card-body">
            @if(isset($absensi) && $absensi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensi ?? [] as $a)
                            <tr>
                                <td>{{ $a->tanggal->isoFormat('D MMM YYYY') }}</td>
                                <td>{{ $a->jam_masuk ?? '-' }}</td>
                                <td>{{ $a->jam_pulang ?? '-' }}</td>
                                <td>
                                    @if($a->jam_masuk && $a->jam_pulang)
                                        <span class="badge bg-success">Hadir</span>
                                    @elseif($a->jam_masuk)
                                        <span class="badge bg-warning">Belum Pulang</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Hadir</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada data absensi untuk karyawan ini.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection