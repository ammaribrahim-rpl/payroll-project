@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h3 class="fw-bold text-primary mb-1">Data Karyawan</h3>
                            <p class="text-muted mb-0">Manajemen data karyawan perusahaan</p>
                        </div>
                        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bi bi-plus-circle"></i> Tambah Karyawan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if($karyawanList->isEmpty())
                <div class="alert alert-info m-4 mb-0">
                    <i class="bi bi-info-circle me-2"></i> Belum ada data karyawan.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="py-3">Nama</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">NIK</th>
                                <th class="py-3">Posisi</th>
                                <th class="py-3">Tgl Masuk</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($karyawanList as $index => $karyawan)
                            <tr>
                                <td class="px-4">{{ $karyawanList->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-2">
                                            {{ strtoupper(substr($karyawan->user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-medium">{{ $karyawan->user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $karyawan->user->email }}</td>
                                <td>{{ $karyawan->nik }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $karyawan->posisi }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('D MMM YYYY') }}</td>
                                <td class="px-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.karyawan.show', $karyawan->id) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p-4">
                    {{ $karyawanList->links() }}
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
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection