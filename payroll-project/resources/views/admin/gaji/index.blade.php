@extends('layouts.app')

@section('title', 'Hitung Gaji Karyawan')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h3 class="fw-bold text-primary mb-1">Hitung Gaji Bulanan Karyawan</h3>
                            <p class="text-muted mb-0">Proses perhitungan gaji berdasarkan periode</p>
                        </div>
                        <a href="{{ route('admin.gaji.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-clock-history me-1"></i> Histori Gaji
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('hasil_perhitungan'))
        <div class="card border-0 shadow-sm mb-4 border-start border-info border-4">
            <div class="card-body p-4">
                <h5 class="card-title text-info mb-3">
                    <i class="bi bi-info-circle-fill me-2"></i>Hasil Perhitungan Sebelumnya
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Karyawan</th>
                                <th>Status</th>
                                <th>Gaji Bersih</th>
                                <th>Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('hasil_perhitungan') as $hasil)
                                <tr>
                                    <td class="fw-medium">{{ $hasil['karyawan'] }}</td>
                                    <td>
                                        @if($hasil['status'] == 'success')
                                            <span class="badge bg-success">Sukses</span>
                                        @elseif($hasil['status'] == 'skipped')
                                            <span class="badge bg-warning text-dark">Dilewati</span>
                                        @else
                                            <span class="badge bg-danger">Gagal</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($hasil['gaji_bersih']))
                                            <span class="fw-bold">Rp {{ number_format($hasil['gaji_bersih'], 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $hasil['message'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-calculator me-2"></i>Form Perhitungan Gaji
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.gaji.proses_hitung') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="karyawan_id" class="form-label fw-medium">Pilih Karyawan</label>
                            <select name="karyawan_id" id="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror">
                                <option value="">Semua Karyawan Aktif</option>
                                @foreach($karyawanList as $k)
                                    <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->user->name }} ({{ $k->nik }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Jika tidak dipilih, gaji akan dihitung untuk semua karyawan.</small>
                            @error('karyawan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bulan" class="form-label fw-medium">Bulan <span class="text-danger">*</span></label>
                            <select name="bulan" id="bulan" class="form-select @error('bulan') is-invalid @enderror" required>
                                <option value="">Pilih Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('bulan', date('m')) == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>
                                @endfor
                            </select>
                            @error('bulan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tahun" class="form-label fw-medium">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="YYYY" value="{{ old('tahun', date('Y')) }}" required min="2000" max="{{ date('Y') + 1 }}">
                            @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label for="keterangan_gaji" class="form-label fw-medium">Keterangan Tambahan</label>
                            <textarea name="keterangan_gaji" id="keterangan_gaji" class="form-control @error('keterangan_gaji') is-invalid @enderror" rows="3" placeholder="Masukkan catatan atau keterangan tambahan jika diperlukan">{{ old('keterangan_gaji') }}</textarea>
                            <small class="form-text text-muted">Opsional</small>
                            @error('keterangan_gaji') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-light border mt-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="force_recalculate" name="force_recalculate" value="1" {{ old('force_recalculate') ? 'checked' : '' }}>
                        <label class="form-check-label" for="force_recalculate">
                            <strong>Hitung Ulang Gaji</strong> - Jika sudah ada data gaji untuk periode ini, data lama akan ditimpa
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-calculator-fill me-1"></i> Proses Hitung Gaji
                    </button>
                    <a href="{{ route('admin.gaji.index') }}" class="btn btn-outline-secondary">
                        Kembali ke Histori Gaji
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="icon-circle bg-primary text-white me-3">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">Komponen Gaji</h6>
                            <p class="mb-0 text-muted small">Gaji pokok, tunjangan, bonus</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="icon-circle bg-success text-white me-3">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">Absensi</h6>
                            <p class="mb-0 text-muted small">Kehadiran, izin, sakit, cuti</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="icon-circle bg-info text-white me-3">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">Potongan</h6>
                            <p class="mb-0 text-muted small">Pajak, BPJS, pinjaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .btn {
        border-radius: 0.5rem;
    }
    
    .form-control, .form-select {
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endsection