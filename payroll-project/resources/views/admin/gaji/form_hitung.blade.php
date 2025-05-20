@extends('layouts.app')

@section('title', 'Hitung Gaji Karyawan')

@section('content')
<div class="container">
    <h3>Hitung Gaji Bulanan Karyawan</h3>
    <hr>

    @if(session('hasil_perhitungan'))
        <div class="alert alert-info">
            <h5>Hasil Perhitungan Sebelumnya:</h5>
            <ul>
                @foreach(session('hasil_perhitungan') as $hasil)
                    <li>
                        Karyawan: {{ $hasil['karyawan'] }} - Status: <span class="fw-bold {{ $hasil['status'] == 'success' ? 'text-success' : ($hasil['status'] == 'skipped' ? 'text-warning' : 'text-danger') }}">{{ ucfirst($hasil['status']) }}</span>.
                        @if(isset($hasil['gaji_bersih']))
                            Gaji Bersih: Rp {{ number_format($hasil['gaji_bersih'], 0, ',', '.') }}.
                        @endif
                        Pesan: {{ $hasil['message'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card">
        <div class="card-header">Form Perhitungan Gaji</div>
        <div class="card-body">
            <form action="{{ route('admin.gaji.proses_hitung') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="karyawan_id" class="form-label">Pilih Karyawan (Opsional)</label>
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
                    <div class="col-md-4">
                        <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                        <select name="bulan" id="bulan" class="form-select @error('bulan') is-invalid @enderror" required>
                            <option value="">Pilih Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('bulan', date('m')) == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>
                            @endfor
                        </select>
                        @error('bulan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="YYYY" value="{{ old('tahun', date('Y')) }}" required min="2000" max="{{ date('Y') + 1 }}">
                        @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="keterangan_gaji" class="form-label">Keterangan Tambahan (Opsional)</label>
                    <textarea name="keterangan_gaji" id="keterangan_gaji" class="form-control @error('keterangan_gaji') is-invalid @enderror" rows="2">{{ old('keterangan_gaji') }}</textarea>
                    @error('keterangan_gaji') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="force_recalculate" name="force_recalculate" value="1" {{ old('force_recalculate') ? 'checked' : '' }}>
                    <label class="form-check-label" for="force_recalculate">
                        Hitung Ulang Gaji (Jika sudah ada data gaji untuk periode ini, akan ditimpa)
                    </label>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-calculator-fill"></i> Proses Hitung Gaji</button>
                    <a href="{{ route('admin.gaji.index') }}" class="btn btn-secondary">Kembali ke Histori Gaji</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection