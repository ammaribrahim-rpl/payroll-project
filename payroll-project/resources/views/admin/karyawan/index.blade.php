@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Data Karyawan</h2>
        <a href="{{ route('admin.karyawan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Tambah Karyawan
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        NIK
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Posisi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Gaji Pokok
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($karyawanList as $karyawan)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $karyawan->nik }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $karyawan->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $karyawan->user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $karyawan->posisi }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.karyawan.show', $karyawan) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Detail
                        </a>
                        <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Edit
                        </a>
                        <form action="{{ route('admin.karyawan.destroy', $karyawan) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data karyawan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $karyawanList->links() }}
    </div>
</div>
@endsection