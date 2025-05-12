<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    // Konstanta untuk potongan, bisa ditaruh di config
    const POTONGAN_PER_HARI_TANPA_KETERANGAN = 50000; // Contoh

    public function index(Request $request)
    {
        $query = Gaji::with('karyawan.user')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc');

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->where('bulan', $request->bulan)->where('tahun', $request->tahun);
        }

        $gajiList = $query->paginate(15);
        $karyawanList = Karyawan::with('user')->get();

        return view('admin.gaji.index', compact('gajiList', 'karyawanList'));
    }


    public function showFormHitung()
    {
        $karyawanList = Karyawan::with('user')->get();
        return view('admin.gaji.form_hitung', compact('karyawanList'));
    }

    public function prosesHitungGaji(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:' . (date('Y') - 5) . '|max:' . (date('Y') + 1),
            'karyawan_id' => 'nullable|exists:karyawan,id', // Bisa untuk semua atau satu karyawan
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $karyawanQuery = Karyawan::query();
        if ($request->filled('karyawan_id')) {
            $karyawanQuery->where('id', $request->karyawan_id);
        }
        $karyawanUntukDigaji = $karyawanQuery->get();

        if ($karyawanUntukDigaji->isEmpty()) {
            return back()->with('error', 'Tidak ada karyawan yang dipilih atau ditemukan.');
        }

        $hasilPerhitungan = [];
        DB::beginTransaction();
        try {
            foreach ($karyawanUntukDigaji as $karyawan) {
                // Cek apakah gaji sudah dihitung untuk periode ini
                $gajiSudahAda = Gaji::where('karyawan_id', $karyawan->id)
                                    ->where('bulan', $bulan)
                                    ->where('tahun', $tahun)
                                    ->first();
                if ($gajiSudahAda && !$request->has('force_recalculate')) { // Tambah opsi force_recalculate jika mau
                    $hasilPerhitungan[] = [
                        'karyawan' => $karyawan->user->name,
                        'status' => 'skipped',
                        'message' => 'Gaji sudah dihitung sebelumnya.'
                    ];
                    continue;
                }


                $absensiBulanIni = Absensi::where('karyawan_id', $karyawan->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get();

                $totalHadir = $absensiBulanIni->where('status', 'hadir')->count();
                $totalIzin = $absensiBulanIni->where('status', 'izin')->count();
                $totalSakit = $absensiBulanIni->where('status', 'sakit')->count();
                $totalTanpaKeterangan = $absensiBulanIni->where('status', 'tanpa_keterangan')->count();

                // Hitung total hari kerja dalam sebulan (misal, tanpa weekend)
                // Untuk simplifikasi, kita bisa gunakan hari kalender atau tentukan hari kerja tetap
                // $jumlahHariKerjaSebulan = Carbon::create($tahun, $bulan, 1)->daysInMonth;
                // Atau, jika ada hari libur nasional, bisa lebih kompleks.
                // Di sini, kita hanya fokus pada potongan berdasarkan 'tanpa_keterangan'

                $gajiPokok = $karyawan->gaji_pokok;
                $potongan = $totalTanpaKeterangan * self::POTONGAN_PER_HARI_TANPA_KETERANGAN;
                $gajiBersih = $gajiPokok - $potongan;
                
                // Pastikan gaji bersih tidak negatif
                $gajiBersih = max(0, $gajiBersih);

                Gaji::updateOrCreate(
                    [
                        'karyawan_id' => $karyawan->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ],
                    [
                        'total_hadir' => $totalHadir,
                        'total_izin' => $totalIzin,
                        'total_sakit' => $totalSakit,
                        'total_tanpa_keterangan' => $totalTanpaKeterangan,
                        'gaji_pokok' => $gajiPokok,
                        'potongan' => $potongan,
                        'gaji_bersih' => $gajiBersih,
                        'keterangan_gaji' => $request->keterangan_gaji ?? 'Perhitungan otomatis',
                        // 'tanggal_pembayaran' => Carbon::now() // atau null dulu, diisi saat pembayaran
                    ]
                );
                 $hasilPerhitungan[] = [
                    'karyawan' => $karyawan->user->name,
                    'status' => 'success',
                    'gaji_bersih' => $gajiBersih,
                    'message' => 'Gaji berhasil dihitung/diperbarui.'
                ];
            }
            DB::commit();
            // return redirect()->route('admin.gaji.index')->with('success', 'Perhitungan gaji selesai.');
            return back()->with('success', 'Perhitungan gaji selesai.')->with('hasil_perhitungan', $hasilPerhitungan);


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghitung gaji: ' . $e->getMessage());
        }
    }

    public function cetakSlip(Gaji $gaji)
    {
        $gaji->load('karyawan.user'); // Eager load data karyawan dan user
        // Ini akan menampilkan view HTML. Untuk PDF, Anda butuh library seperti DomPDF atau Snappy.
        return view('admin.gaji.slip', compact('gaji'));
    }
}