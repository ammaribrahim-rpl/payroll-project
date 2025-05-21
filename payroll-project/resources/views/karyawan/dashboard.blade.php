@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar / Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="bg-primary text-white p-4 text-center">
                        <div class="avatar mb-3">
                            <div class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                        <p class="mb-0 opacity-75">{{ Auth::user()->karyawan->jabatan ?? 'Karyawan' }}</p>
                    </div>
                    
                    <div class="p-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Informasi Karyawan</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-light rounded-3 p-2 me-3">
                                <i class="bi bi-envelope text-primary"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Email</div>
                                <div>{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-light rounded-3 p-2 me-3">
                                <i class="bi bi-person-badge text-primary"></i>
                            </div>
                            <div>
                                <div class="small text-muted">ID Karyawan</div>
                                <div>{{ Auth::user()->karyawan->id ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-light rounded-3 p-2 me-3">
                                <i class="bi bi-calendar-check text-primary"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Tanggal Bergabung</div>
                                <div>{{ Auth::user()->created_at->isoFormat('D MMMM YYYY') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-8">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Date Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light rounded-3 p-3 me-3">
                            <i class="bi bi-calendar-week text-primary fs-4"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Hari Ini</div>
                            <h5 class="mb-0">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</h5>
                        </div>
                        <div class="ms-auto">
                            <div id="live-clock" class="fs-5 fw-bold text-primary">00:00:00</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Attendance Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-check me-2 text-primary"></i>
                        Presensi Hari Ini
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $karyawan = Auth::user()->karyawan;
                        $absensiHariIni = $karyawan ? $karyawan->absensi()->whereDate('tanggal', today())->first() : null;
                    @endphp
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'border-success bg-success bg-opacity-10' : 'bg-light' }} border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-box {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'bg-success text-white' : 'bg-white text-primary' }} rounded-3 p-2 me-2">
                                            <i class="bi {{ $absensiHariIni && $absensiHariIni->jam_masuk ? 'bi-check-circle' : 'bi-box-arrow-in-right' }}"></i>
                                        </div>
                                        <h6 class="mb-0">Presensi Masuk</h6>
                                    </div>
                                    
                                    @if (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                                        <p class="small text-muted mb-3">Silakan lakukan presensi masuk</p>
                                        <form method="POST" action="{{ route('karyawan.absensi.masuk') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bi bi-box-arrow-in-right me-1"></i> Presensi Masuk
                                            </button>
                                        </form>
                                    @else
                                        <div class="text-success mb-2">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            <span class="fw-medium">Sudah Presensi</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-white rounded-3 p-2 me-2">
                                                <i class="bi bi-clock text-success"></i>
                                            </div>
                                            <div>
                                                <div class="small text-muted">Waktu Masuk</div>
                                                <div class="fw-medium">{{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') }} WIB</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100 {{ $absensiHariIni && $absensiHariIni->jam_pulang ? 'border-danger bg-danger bg-opacity-10' : 'bg-light' }} border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-box {{ $absensiHariIni && $absensiHariIni->jam_pulang ? 'bg-danger text-white' : 'bg-white text-primary' }} rounded-3 p-2 me-2">
                                            <i class="bi {{ $absensiHariIni && $absensiHariIni->jam_pulang ? 'bi-check-circle' : 'bi-box-arrow-left' }}"></i>
                                        </div>
                                        <h6 class="mb-0">Presensi Pulang</h6>
                                    </div>
                                    
                                    @if ($absensiHariIni && $absensiHariIni->jam_masuk && !$absensiHariIni->jam_pulang)
                                        <p class="small text-muted mb-3">Silakan lakukan presensi pulang</p>
                                        <form method="POST" action="{{ route('karyawan.absensi.pulang') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-box-arrow-left me-1"></i> Presensi Pulang
                                            </button>
                                        </form>
                                    @elseif($absensiHariIni && $absensiHariIni->jam_pulang)
                                        <div class="text-danger mb-2">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            <span class="fw-medium">Sudah Presensi</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-white rounded-3 p-2 me-2">
                                                <i class="bi bi-clock text-danger"></i>
                                            </div>
                                            <div>
                                                <div class="small text-muted">Waktu Pulang</div>
                                                <div class="fw-medium">{{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i') }} WIB</div>
                                            </div>
                                        </div>
                                    @else
                                        <p class="small text-muted mb-3">Belum dapat melakukan presensi pulang</p>
                                        <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                            <i class="bi bi-lock me-1"></i> Presensi Pulang
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white p-4 border-0">
                    <a href="{{ route('karyawan.absensi.riwayat') }}" class="btn btn-outline-primary">
                        <i class="bi bi-clock-history me-1"></i> Lihat Riwayat Absensi
                    </a>
                </div>
            </div>
            
            <!-- Quick Stats Card -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up me-2 text-primary"></i>
                        Statistik Kehadiran
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card bg-primary bg-opacity-10 border-0 rounded-4 h-100">
                                <div class="card-body p-3 text-center">
                                    <div class="icon-box bg-primary text-white rounded-circle mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-calendar-check fs-5"></i>
                                    </div>
                                    <h3 class="mb-1 fw-bold text-primary">{{ $karyawan ? $karyawan->absensi()->whereMonth('tanggal', now()->month)->count() : 0 }}</h3>
                                    <p class="mb-0 small">Kehadiran Bulan Ini</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success bg-opacity-10 border-0 rounded-4 h-100">
                                <div class="card-body p-3 text-center">
                                    <div class="icon-box bg-success text-white rounded-circle mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-clock-history fs-5"></i>
                                    </div>
                                    <h3 class="mb-1 fw-bold text-success">{{ $karyawan ? $karyawan->absensi()->whereMonth('tanggal', now()->month)->whereNotNull('jam_masuk')->whereRaw('TIME(jam_masuk) <= ?', ['08:00:00'])->count() : 0 }}</h3>
                                    <p class="mb-0 small">Tepat Waktu</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning bg-opacity-10 border-0 rounded-4 h-100">
                                <div class="card-body p-3 text-center">
                                    <div class="icon-box bg-warning text-white rounded-circle mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-exclamation-circle fs-5"></i>
                                    </div>
                                    <h3 class="mb-1 fw-bold text-warning">{{ $karyawan ? $karyawan->absensi()->whereMonth('tanggal', now()->month)->whereNotNull('jam_masuk')->whereRaw('TIME(jam_masuk) > ?', ['08:00:00'])->count() : 0 }}</h3>
                                    <p class="mb-0 small">Terlambat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds}`;
    }
    
    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial call
</script>
@endpush
@endsection