<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function presensiMasuk(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        $today = Carbon::today();

        // Cek apakah sudah ada absensi masuk hari ini
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
                                ->whereDate('tanggal', $today)
                                ->first();

        if ($absensiHariIni && $absensiHariIni->jam_masuk) {
            return back()->with('error', 'Anda sudah melakukan presensi masuk hari ini.');
        }

        if (!$absensiHariIni) {
            Absensi::create([
                'karyawan_id' => $karyawan->id,
                'tanggal' => $today,
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'hadir', // Default status hadir saat masuk
            ]);
        } else {
            // Jika record ada tapi jam_masuk null (misal izin/sakit dibuat admin)
            // Ini opsional, tergantung alur. Untuk simpel, kita overwrite jika belum ada jam masuk.
            $absensiHariIni->update([
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'hadir',
            ]);
        }


        return back()->with('success', 'Presensi masuk berhasil dicatat.');
    }

    public function presensiPulang(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        $today = Carbon::today();

        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
                                ->whereDate('tanggal', $today)
                                ->first();

        if (!$absensiHariIni || !$absensiHariIni->jam_masuk) {
            return back()->with('error', 'Anda belum melakukan presensi masuk hari ini.');
        }

        if ($absensiHariIni->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan presensi pulang hari ini.');
        }

        $absensiHariIni->update([
            'jam_pulang' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Presensi pulang berhasil dicatat.');
    }

    public function riwayat(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        $riwayatAbsensi = Absensi::where('karyawan_id', $karyawan->id)
                                 ->orderBy('tanggal', 'desc')
                                 ->paginate(10); // Paginasi
        return view('karyawan.absensi.riwayat', compact('riwayatAbsensi'));
    }
}