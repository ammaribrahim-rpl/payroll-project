@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Karyawan</h2>
        <a href="{{ route('admin.karyawan.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi User</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                        <dd class="text-base text-gray-900">{{ $karyawan->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-base text-gray-900">{{ $karyawan->user->email }}</dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Karyawan</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIK</dt>
                        <dd class="text-base text-gray-900">{{ $karyawan->nik }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Posisi</dt>
                        <dd class="text-base text-gray-900">{{ $karyawan->posisi }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Masuk</dt>
                        <dd class="text-base text-gray-900">{{ $karyawan->tanggal_masuk->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Gaji Pokok</dt>
                        <dd class="text-base text-gray-900">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Kontak</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                    <dd class="text-base text-gray-900">{{ $karyawan->no_telepon ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                    <dd class="text-base text-gray-900">{{ $karyawan->alamat ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Edit
            </a>
            <form action="{{ route('admin.karyawan.destroy', $karyawan) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Riwayat Absensi Terbaru -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Absensi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jam Masuk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jam Pulang
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($karyawan->absensi()->latest()->limit(5)->get() as $absensi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->tanggal->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->jam_masuk ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->jam_pulang ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $absensi->status === 'hadir' ? 'bg-green-100 text-green-800' : 
                                   ($absensi->status === 'izin' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($absensi->status === 'sakit' ? 'bg-blue-100 text-blue-800' : 
                                   'bg-red-100 text-red-800')) }}">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Belum ada riwayat absensi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection