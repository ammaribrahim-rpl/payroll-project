@extends('layouts.app')

@section('title', 'Riwayat Absensi Saya')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Riwayat Absensi Saya</h4>
        </div>
        <div class="card-body">
            @if($riwayatAbsensi->isEmpty())
                <div class="alert alert-info">Belum ada riwayat absensi.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatAbsensi as $index => $absensi)
                            <tr>
                                <td>{{ $riwayatAbsensi->firstItem() + $index }}</td>
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
                    {{ $riwayatAbsensi->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection