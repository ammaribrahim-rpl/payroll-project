<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function rekap(Request $request)
    {
        $query = Absensi::with('karyawan.user')->orderBy('tanggal', 'desc');

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                  ->whereYear('tanggal', $request->tahun);
        } elseif ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
             $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }


        $rekapAbsensi = $query->paginate(20);
        $karyawanList = Karyawan::with('user')->get(); // Untuk filter dropdown

        return view('admin.absensi.rekap', compact('rekapAbsensi', 'karyawanList'));
    }

    // Opsional: CRUD Absensi oleh Admin jika diperlukan
    // public function create() { ... }
    // public function store(Request $request) { ... }
    // public function edit(Absensi $absensi) { ... }
    // public function update(Request $request, Absensi $absensi) { ... }
    // public function destroy(Absensi $absensi) { ... }
}