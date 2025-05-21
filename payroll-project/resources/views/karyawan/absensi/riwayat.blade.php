@extends('layouts.app')

@section('title', 'Riwayat Absensi Saya')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h4 class="mb-1 fw-bold">
                        <i class="bi bi-clock-history text-primary me-2"></i>Riwayat Absensi Saya
                    </h4>
                    <p class="text-muted mb-0">Lihat dan pantau riwayat kehadiran Anda</p>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="{{ route('karyawan.dashboard') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
            
            <!-- Filter Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('karyawan.absensi.riwayat') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="bulan" class="form-label small fw-medium">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select">
                                @php
                                    $bulanIni = request('bulan', date('m'));
                                    $bulanList = [
                                        '01' => 'Januari',
                                        '02' => 'Februari',
                                        '03' => 'Maret',
                                        '04' => 'April',
                                        '05' => 'Mei',
                                        '06' => 'Juni',
                                        '07' => 'Juli',
                                        '08' => 'Agustus',
                                        '09' => 'September',
                                        '10' => 'Oktober',
                                        '11' => 'November',
                                        '12' => 'Desember'
                                    ];
                                @endphp
                                @foreach($bulanList as $value => $label)
                                    <option value="{{ $value }}" {{ $bulanIni == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun" class="form-label small fw-medium">Tahun</label>
                            <select name="tahun" id="tahun" class="form-select">
                                @php
                                    $tahunIni = request('tahun', date('Y'));
                                    $tahunMulai = 2020;
                                    $tahunAkhir = date('Y');
                                @endphp
                                @for($tahun = $tahunAkhir; $tahun >= $tahunMulai; $tahun--)
                                    <option value="{{ $tahun }}" {{ $tahunIni == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label small fw-medium">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-filter me-1"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-calendar-check text-primary fs-4"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Total Kehadiran</div>
                                    <h4 class="mb-0 fw-bold">{{ $riwayatAbsensi->where('status', 'hadir')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-check-circle text-success fs-4"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Tepat Waktu</div>
                                    <h4 class="mb-0 fw-bold">{{ $riwayatAbsensi->where('status', 'hadir')->filter(function($item) { 
                                        return $item->jam_masuk && \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') <= '08:00'; 
                                    })->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-exclamation-circle text-warning fs-4"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Terlambat</div>
                                    <h4 class="mb-0 fw-bold">{{ $riwayatAbsensi->where('status', 'hadir')->filter(function($item) { 
                                        return $item->jam_masuk && \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') > '08:00'; 
                                    })->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-x-circle text-danger fs-4"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Tidak Hadir</div>
                                    <h4 class="mb-0 fw-bold">{{ $riwayatAbsensi->whereIn('status', ['izin', 'sakit', 'alpha'])->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Attendance History Card -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-list-check me-2 text-primary"></i>
                            Detail Riwayat Absensi
                        </h5>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" onclick="window.print()">
                                <i class="bi bi-printer me-1"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($riwayatAbsensi->isEmpty())
                        <div class="p-4 text-center">
                            <div class="py-5">
                                <div class="icon-box bg-light rounded-circle mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-calendar-x text-muted fs-1"></i>
                                </div>
                                <h5 class="text-muted">Belum ada riwayat absensi</h5>
                                <p class="text-muted mb-0">Riwayat absensi Anda akan muncul di sini</p>
                            </div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4" style="width: 60px">No</th>
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Jam Masuk</th>
                                        <th class="py-3 px-4">Jam Pulang</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatAbsensi as $index => $absensi)
                                    <tr>
                                        <td class="py-3 px-4">{{ $riwayatAbsensi->firstItem() + $index }}</td>
                                        <td class="py-3 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-box bg-light rounded-3 p-2 me-2">
                                                    <i class="bi bi-calendar-date text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('dddd') }}</div>
                                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('D MMM YYYY') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($absensi->jam_masuk)
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-box {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') <= '08:00' ? 'bg-success text-white' : 'bg-warning text-white' }} rounded-3 p-2 me-2">
                                                        <i class="bi {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') <= '08:00' ? 'bi-check-circle' : 'bi-exclamation-circle' }}"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') }}</div>
                                                        <div class="small {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') <= '08:00' ? 'text-success' : 'text-warning' }}">
                                                            {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') <= '08:00' ? 'Tepat Waktu' : 'Terlambat' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($absensi->jam_pulang)
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-box bg-info text-white rounded-3 p-2 me-2">
                                                        <i class="bi bi-box-arrow-left"></i>
                                                    </div>
                                                    <div class="fw-medium">{{ \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') }}</div>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($absensi->status == 'hadir')
                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    {{ ucfirst($absensi->status) }}
                                                </span>
                                            @elseif($absensi->status == 'izin')
                                                <span class="badge bg-info rounded-pill px-3 py-2">
                                                    <i class="bi bi-info-circle-fill me-1"></i>
                                                    {{ ucfirst($absensi->status) }}
                                                </span>
                                            @elseif($absensi->status == 'sakit')
                                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                    <i class="bi bi-thermometer-half me-1"></i>
                                                    {{ ucfirst($absensi->status) }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                                    <i class="bi bi-x-circle-fill me-1"></i>
                                                    {{ ucfirst($absensi->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($absensi->keterangan)
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" data-bs-toggle="tooltip" title="{{ $absensi->keterangan }}">
                                                    {{ $absensi->keterangan }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-top">
                            {{ $riwayatAbsensi->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
@endsection