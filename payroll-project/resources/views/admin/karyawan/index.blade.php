@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Karyawan</h3>
        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Karyawan</a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($karyawanList->isEmpty())
                <div class="alert alert-info">Belum ada data karyawan.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Posisi</th>
                                <th>Tgl Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($karyawanList as $index => $karyawan)
                            <tr>
                                <td>{{ $karyawanList->firstItem() + $index }}</td>
                                <td>{{ $karyawan->user->name }}</td>
                                <td>{{ $karyawan->user->email }}</td>
                                <td>{{ $karyawan->nik }}</td>
                                <td>{{ $karyawan->posisi }}</td>
                                <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('D MMM YYYY') }}</td>
                                <td>
                                    <a href="{{ route('admin.karyawan.show', $karyawan->id) }}" class="btn btn-sm btn-info" title="Lihat"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $karyawanList->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection