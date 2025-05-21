@extends('layouts.app')

@section('title', 'Rekap Absensi Karyawan')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h3 class="fw-bold text-primary mb-1">Rekap Absensi Karyawan</h3>
                            <p class="text-muted mb-0">Laporan kehadiran karyawan berdasarkan periode</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true" aria-controls="filterCollapse">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                            <button class="btn btn-outline-success" onclick="window.print()">
                                <i class="bi bi-printer me-1"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="collapse show" id="filterCollapse">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0 fw-semibold">Filter Data Absensi</h5>
            </div>
            <div class="card-body p-4">
                <form method="GET" action="{{ route('admin.absensi.rekap') }}">
                    <div class="row g-3">
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="karyawan_id" class="form-label fw-medium">Pilih Karyawan</label>
                                <select name="karyawan_id" id="karyawan_id" class="form-select">
                                    <option value="">Semua Karyawan</option>
                                    @foreach($karyawanList as $k)
                                        <option value="{{ $k->id }}" {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->user->name }} ({{ $k->nik }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Opsional</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="bulan" class="form-label fw-medium">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="">Semua Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>
                                    @endfor
                                </select>
                                <small class="form-text text-muted">Opsional</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="tahun" class="form-label fw-medium">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control" placeholder="YYYY" value="{{ request('tahun', date('Y')) }}" min="2000" max="{{ date('Y') + 1 }}">
                                <small class="form-text text-muted">Opsional</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="tanggal_mulai" class="form-label fw-medium">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                                <small class="form-text text-muted">Opsional</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="tanggal_selesai" class="form-label fw-medium">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                                <small class="form-text text-muted">Opsional</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-light border mt-3 mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Filter bulan & tahun akan diabaikan jika tanggal mulai & selesai diisi.
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-filter me-1"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('admin.absensi.rekap') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if($rekapAbsensi->isEmpty())
                <div class="alert alert-info m-4 mb-0">
                    <i class="bi bi-info-circle me-2"></i> Tidak ada data absensi yang cocok dengan filter Anda.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="py-3">Nama Karyawan</th>
                                <th class="py-3">NIK</th>
                                <th class="py-3">Tanggal</th>
                                <th class="py-3">Jam Masuk</th>
                                <th class="py-3">Jam Pulang</th>
                                <th class="py-3">Status</th>
                                <th class="px-4 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapAbsensi as $index => $absensi)
                            <tr>
                                <td class="px-4">{{ $rekapAbsensi->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-2">
                                            {{ strtoupper(substr($absensi->karyawan->user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-medium">{{ $absensi->karyawan->user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $absensi->karyawan->nik }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('D MMM YYYY') }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('dddd') }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($absensi->jam_masuk)
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($absensi->jam_pulang)
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-clock-history me-1"></i>
                                            {{ \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($absensi->status == 'hadir')
                                        <span class="badge bg-success">{{ ucfirst($absensi->status) }}</span>
                                    @elseif($absensi->status == 'izin')
                                        <span class="badge bg-info">{{ ucfirst($absensi->status) }}</span>
                                    @elseif($absensi->status == 'sakit')
                                        <span class="badge bg-warning text-dark">{{ ucfirst($absensi->status) }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($absensi->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-4">
                                    @if($absensi->keterangan)
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $absensi->keterangan }}">
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
                <div class="d-flex justify-content-between align-items-center p-4">
                    <div>
                        <small class="text-muted">Menampilkan {{ $rekapAbsensi->firstItem() }} - {{ $rekapAbsensi->lastItem() }} dari {{ $rekapAbsensi->total() }} data</small>
                    </div>
                    <div>
                        {{ $rekapAbsensi->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
        border-bottom: 1px solid rgba(0,0,0,.05);
    }
    
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .btn {
        border-radius: 0.5rem;
    }
    
    @media print {
        .btn, .collapse, form, .pagination {
            display: none !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        
        .container {
            width: 100% !important;
            max-width: 100% !important;
        }
    }
</style>
@endsection