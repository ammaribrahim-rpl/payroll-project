@extends('layouts.app')

@section('title', 'Data Gaji')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Data Gaji</h2>
        <a href="{{ route('admin.gaji.form_hitung') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Hitung Gaji
        </a>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('admin.gaji.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="karyawan_id" class="block text-sm font-medium text-gray-700">Karyawan</label>
                <select name="karyawan_id" id="karyawan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Karyawan</option>
                    @foreach($karyawanList as $karyawan)
                        <option value="{{ $karyawan->id }}" {{ request('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                            {{ $karyawan->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                <select name="bulan" id="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select name="tahun" id="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih Tahun</option>
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Gaji -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Periode
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Karyawan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Gaji Pokok
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Potongan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Gaji Bersih
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($gajiList as $gaji)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ DateTime::createFromFormat('!m', $gaji->bulan)->format('F') }} {{ $gaji->tahun }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $gaji->karyawan->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Rp {{ number_format($gaji->potongan, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold">
                        Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $gaji->tanggal_pembayaran ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $gaji->tanggal_pembayaran ? 'Dibayar' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.gaji.slip', $gaji) }}" class="text-blue-600 hover:text-blue-900">
                            Cetak Slip
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data gaji
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $gajiList->appends(request()->query())->links() }}
    </div>
</div>
@endsection