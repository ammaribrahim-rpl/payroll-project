@extends('layouts.app')

@section('title', 'Rekap Absensi Karyawan')

@section('content')
<div class="container">
    <h3>Rekap Absensi Karyawan</h3>
    <hr>
    <div class="card mb-4">
        <div class="card-header">Filter Data Absensi</div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.absensi.rekap') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="karyawan_id" class="form-label">Pilih Karyawan (Opsional)</label>
                        <select name="karyawan_id" id="karyawan_id" class="form-select">
                            <option value="">Semua Karyawan</option>
                            @foreach($karyawanList as $k)
                                <option value="{{ $k->id }}" {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->user->name }} ({{ $k->nik }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="bulan" class="form-label">Bulan (Opsional)</label>
                        <select name="bulan" id="bulan" class="form-select">
                            <option value="">Semua Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tahun" class="form-label">Tahun (Opsional)</label>
                        <input type="number" name="tahun" id="tahun" class="form-control" placeholder="YYYY" value="{{ request('tahun', date('Y')) }}" min="2000" max="{{ date('Y') + 1 }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Filter</button>
                         <a href="{{ route('admin.absensi.rekap') }}" class="btn btn-secondary w-100 mt-2"><i class="bi bi-arrow-clockwise"></i> Reset</a>
                    </div>
                </div>
                 <div class="row g-3 align-items-end mt-2">
                     <div class="col-md-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai (Opsional)</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                    </div>
                 </div>
                 <small class="form-text text-muted mt-2">Filter bulan & tahun akan diabaikan jika tanggal mulai & selesai diisi.</small>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($rekapAbsensi->isEmpty())
                <div class="alert alert-info">Tidak ada data absensi yang cocok dengan filter Anda.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>NIK</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapAbsensi as $index => $absensi)
                            <tr>
                                <td>{{ $rekapAbsensi->firstItem() + $index }}</td>
                                <td>{{ $absensi->karyawan->user->name }}</td>
                                <td>{{ $absensi->karyawan->nik }}</td>
                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('dddd, D MMM YYYY') }}</td>
                                <td>{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</td>
                                <td>{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}</td>
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
                                <td>{{ $absensi->keterangan ?: '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $rekapAbsensi->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection