karyawan/dashboard.blade.php
@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard Karyawan</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Absensi Hari Ini -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Absensi Hari Ini</h3>
            
            @php
                $absensiHariIni = Auth::user()->karyawan->absensi()
                    ->whereDate('tanggal', today())
                    ->first();
            @endphp

            <div class="space-y-4">
                @if(!$absensiHariIni || !$absensiHariIni->jam_masuk)
                    <form action="{{ route('karyawan.absensi.masuk') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Presensi Masuk
                        </button>
                    </form>
                @else
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        Anda sudah presensi masuk pukul {{ $absensiHariIni->jam_masuk }}
                    </div>
                @endif

                @if($absensiHariIni && $absensiHariIni->jam_masuk && !$absensiHariIni->jam_pulang)
                    <form action="{{ route('karyawan.absensi.pulang') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Presensi Pulang
                        </button>
                    </form>
                @elseif($absensiHariIni && $absensiHariIni->jam_pulang)
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                        Anda sudah presensi pulang pukul {{ $absensiHariIni->jam_pulang }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Pribadi -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">NIK</dt>
                    <dd class="text-base text-gray-900">{{ Auth::user()->karyawan->nik }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Posisi</dt>
                    <dd class="text-base text-gray-900">{{ Auth::user()->karyawan->posisi }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                    <dd class="text-base text-gray-900">{{ Auth::user()->karyawan->tanggal_masuk->format('d M Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Statistik Absensi Bulan Ini -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Absensi Bulan Ini</h3>
        
        @php
            $absensi = Auth::user()->karyawan->absensi()
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->get();
            
            $statistics = [
                'hadir' => $absensi->where('status', 'hadir')->count(),
                'izin' => $absensi->where('status', 'izin')->count(),
                'sakit' => $absensi->where('status', 'sakit')->count(),
                'tanpa_keterangan' => $absensi->where('status', 'tanpa_keterangan')->count(),
            ];
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <p class="text-2xl font-bold text-green-600">{{ $statistics['hadir'] }}</p>
                <p class="text-sm text-gray-600">Hadir</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $statistics['izin'] }}</p>
                <p class="text-sm text-gray-600">Izin</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $statistics['sakit'] }}</p>
                <p class="text-sm text-gray-600">Sakit</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-red-600">{{ $statistics['tanpa_keterangan'] }}</p>
                <p class="text-sm text-gray-600">Tanpa Keterangan</p>
            </div>
        </div>
    </div>
</div>
@endsection