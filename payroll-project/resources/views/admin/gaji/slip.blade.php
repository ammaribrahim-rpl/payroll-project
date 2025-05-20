<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->user->name }} - {{ \Carbon\Carbon::create()->month($gaji->bulan)->isoFormat('MMMM') }} {{ $gaji->tahun }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; margin: 0; padding: 0; }
        .container-slip { max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; }
        .header-slip { text-align: center; margin-bottom: 20px; }
        .header-slip h3 { margin: 0; font-size: 1.5em; }
        .header-slip p { margin: 5px 0; }
        .info-karyawan, .detail-gaji { margin-bottom: 20px; }
        .info-karyawan table, .detail-gaji table { width: 100%; }
        .info-karyawan th, .detail-gaji th { text-align: left; padding: 5px; width: 30%; border-bottom: 1px solid #eee;}
        .info-karyawan td, .detail-gaji td { padding: 5px; border-bottom: 1px solid #eee;}
        .total-gaji th, .total-gaji td { font-weight: bold; background-color: #f8f9fa; }
        .footer-slip { margin-top: 30px; text-align: center; font-size: 0.9em; }
        .signature-area { margin-top: 50px; }
        .signature-block { display: inline-block; width: 45%; text-align: center; }
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .btn-print { display: none; }
            .container-slip { border: none; margin:0; padding:0; }
        }
    </style>
</head>
<body>
    <div class="container-slip">
        <div class="text-end mb-3">
            <button onclick="window.print()" class="btn btn-sm btn-primary btn-print"><i class="bi bi-printer"></i> Cetak</button>
        </div>

        <div class="header-slip">
            <h3>SLIP GAJI KARYAWAN</h3>
            <p>PERIODE: {{ \Carbon\Carbon::create()->month($gaji->bulan)->isoFormat('MMMM') }} {{ $gaji->tahun }}</p>
            <p>PT. Nama Perusahaan Anda</p> {{-- Ganti dengan nama perusahaan Anda --}}
        </div>

        <div class="info-karyawan">
            <h5>Informasi Karyawan</h5>
            <table>
                <tr>
                    <th>Nama Karyawan</th>
                    <td>: {{ $gaji->karyawan->user->name }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>: {{ $gaji->karyawan->nik }}</td>
                </tr>
                <tr>
                    <th>Posisi</th>
                    <td>: {{ $gaji->karyawan->posisi }}</td>
                </tr>
                 <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>: {{ $gaji->tanggal_pembayaran ? \Carbon\Carbon::parse($gaji->tanggal_pembayaran)->isoFormat('D MMMM YYYY') : 'Belum Dibayar' }}</td>
                </tr>
            </table>
        </div>

        <div class="detail-gaji">
            <h5>Rincian Gaji</h5>
            <table>
                <thead>
                    <tr>
                        <th style="width:70%;">Keterangan</th>
                        <th style="width:30%; text-align:right;">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td style="text-align:right;">{{ number_format($gaji->gaji_pokok, 2, ',', '.') }}</td>
                    </tr>
                    {{-- Anda bisa menambahkan komponen gaji lain di sini jika ada (tunjangan, lembur, dll) --}}
                    <tr>
                        <td class="text-danger">Potongan (Ketidakhadiran, dll.)</td>
                        <td class="text-danger" style="text-align:right;">(-) {{ number_format($gaji->potongan, 2, ',', '.') }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="total-gaji">
                        <th>Total Gaji Diterima (Gaji Bersih)</th>
                        <td style="text-align:right;">{{ number_format($gaji->gaji_bersih, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($gaji->keterangan_gaji)
        <div class="mt-3">
            <strong>Keterangan Tambahan:</strong>
            <p>{{ $gaji->keterangan_gaji }}</p>
        </div>
        @endif

        <div class="signature-area row">
            <div class="col-6 text-center">
                <p>Diterima oleh,</p>
                <br><br><br>
                <p>( {{ $gaji->karyawan->user->name }} )</p>
            </div>
            <div class="col-6 text-center">
                <p>{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
                <p>Disetujui oleh,</p>
                <br><br><br>
                <p>( Nama Atasan / HRD )</p> {{-- Ganti dengan nama yang relevan --}}
            </div>
        </div>

        <div class="footer-slip">
            <p>Ini adalah slip gaji yang dicetak secara otomatis oleh sistem.</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"></script> {{-- Hanya untuk ikon print --}}
</body>
</html>