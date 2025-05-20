@extends('layouts.app')

@section('title', 'Manajemen Penggajian')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Histori Penggajian</h3>
        <a href="{{ route('admin.gaji.form_hitung') }}" class="btn btn-success"><i class="bi bi-calculator"></i> Hitung Gaji Baru</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Filter Histori Gaji</div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.gaji.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
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
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select">
                            <option value="">Semua Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" name="tahun" id="tahun" class="form-control" placeholder="YYYY" value="{{ request('tahun', date('Y')) }}" min="2000" max="{{ date('Y') + 1 }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Filter</button>
                         <a href="{{ route('admin.gaji.index') }}" class="btn btn-secondary w-100 mt-2"><i class="bi bi-arrow-clockwise"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($gajiList->isEmpty())
                <div class="alert alert-info">Tidak ada data gaji yang cocok dengan filter Anda atau belum ada gaji yang dihitung.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Periode</th>
                                <th>Gaji Pokok</th>
                                <th>Potongan</th>
                                <th>Gaji Bersih</th>
                                <th>Tgl. Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gajiList as $index => $gaji)
                            <tr>
                                <td>{{ $gajiList->firstItem() + $index }}</td>
                                <td>{{ $gaji->karyawan->user->name }}</td>
                                <td>{{ \Carbon\Carbon::create()->month($gaji->bulan)->isoFormat('MMMM') }} {{ $gaji->tahun }}</td>
                                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                                <td class="fw-bold">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                                <td>{{ $gaji->tanggal_pembayaran ? \Carbon\Carbon::parse($gaji->tanggal_pembayaran)->isoFormat('D MMM YYYY') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.gaji.slip', $gaji->id) }}" class="btn btn-sm btn-info" title="Lihat Slip" target="_blank"><i class="bi bi-receipt"></i> Slip</a>
                                    {{-- Tambahkan aksi lain jika perlu, misal edit status pembayaran --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $gajiList->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection