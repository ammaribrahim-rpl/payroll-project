@extends('layouts.app')

@section('title', 'Hitung Gaji')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Hitung Gaji Karyawan</h2>

    @if(session('hasil_perhitungan'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
        <p class="font-bold">Hasil Perhitungan:</p>
        <ul class="mt-2">
            @foreach(session('hasil_perhitungan') as $hasil)
                <li>
                    {{ $hasil['karyawan'] }}: 
                    @if($hasil['status'] === 'success')
                        Berhasil (Gaji Bersih: Rp {{ number_format($hasil['gaji_bersih'], 0, ',', '.') }})
                    @else
                        {{ $hasil['message'] }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.gaji.proses_hitung') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                    <select name="bulan" id="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('bulan') border-red-500 @enderror">
                        <option value="">Pilih Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ old('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    @error('bulan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <select name="tahun" id="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tahun') border-red-500 @enderror">
                        <option value="">Pilih Tahun</option>
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ old('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    @error('tahun')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="karyawan_id" class="block text-sm font-medium text-gray-700">Karyawan</label>
                    <select name="karyawan_id" id="karyawan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('karyawan_id') border-red-500 @enderror">
                        <option value="">Semua Karyawan</option>
                        @foreach($karyawanList as $karyawan)
                            <option value="{{ $karyawan->id }}" {{ old('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                {{ $karyawan->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('karyawan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="keterangan_gaji" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea name="keterangan_gaji" id="keterangan_gaji" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('keterangan_gaji') border-red-500 @enderror">{{ old('keterangan_gaji', 'Perhitungan otomatis') }}</textarea>
                    @error('keterangan_gaji')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="force_recalculate" id="force_recalculate" 
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="force_recalculate" class="ml-2 block text-sm text-gray-900">
                        Hitung ulang untuk yang sudah ada
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.gaji.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Hitung Gaji
                </button>
            </div>
        </form>
    </div>
</div>
@endsection