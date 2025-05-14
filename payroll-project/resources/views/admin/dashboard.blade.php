@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Karyawan -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Total Karyawan</h3>
                    <p class="text-2xl font-semibold text-gray-600">{{ App\Models\Karyawan::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Absensi Hari Ini -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Hadir Hari Ini</h3>
                    <p class="text-2xl font-semibold text-gray-600">
                        {{ App\Models\Absensi::whereDate('tanggal', today())->where('status', 'hadir')->count() }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Gaji Bulan Ini -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Total Gaji Bulan Ini</h3>
                    <p class="text-2xl font-semibold text-gray-600">
                        Rp {{ number_format(App\Models\Gaji::whereMonth('created_at', now()->month)->sum('gaji_bersih'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.karyawan.create') }}" class="bg-blue-500 text-white text-center py-2 px-4 rounded hover:bg-blue-600">
                Tambah Karyawan
            </a>
            <a href="{{ route('admin.gaji.form_hitung') }}" class="bg-green-500 text-white text-center py-2 px-4 rounded hover:bg-green-600">
                Hitung Gaji
            </a>
            <a href="{{ route('admin.absensi.rekap') }}" class="bg-yellow-500 text-white text-center py-2 px-4 rounded hover:bg-yellow-600">
                Lihat Rekap Absensi
            </a>
        </div>
    </div>
</div>
@endsection