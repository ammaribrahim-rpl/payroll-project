<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .slip-title {
            font-size: 20px;
            text-decoration: underline;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            width: 200px;
            font-weight: bold;
        }
        .info-value {
            flex: 1;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            margin-top: 60px;
            margin-bottom: 5px;
        }
        @media print {
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-name">PT. PAYROLL SYSTEM</div>
            <div class="slip-title">SLIP GAJI</div>
            <div style="margin-top: 10px;">
                Periode: {{ DateTime::createFromFormat('!m', $gaji->bulan)->format('F') }} {{ $gaji->tahun }}
            </div>
        </div>

        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Nama Karyawan</div>
                <div class="info-value">: {{ $gaji->karyawan->user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIK</div>
                <div class="info-value">: {{ $gaji->karyawan->nik }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Posisi</div>
                <div class="info-value">: {{ $gaji->karyawan->posisi }}</div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gaji Pokok</td>
                    <td class="text-right">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Total Hari Hadir</td>
                    <td class="text-right">{{ $gaji->total_hadir }} hari</td>
                </tr>
                <tr>
                    <td>Total Izin</td>
                    <td class="text-right">{{ $gaji->total_izin }} hari</td>
                </tr>
                <tr>
                    <td>Total Sakit</td>
                    <td class="text-right">{{ $gaji->total_sakit }} hari</td>
                </tr>
                <tr>
                    <td>Total Tanpa Keterangan</td>
                    <td class="text-right">{{ $gaji->total_tanpa_keterangan }} hari</td>
                </tr>
                <tr>
                    <td>Potongan ({{ $gaji->total_tanpa_keterangan }} x Rp 50.000)</td>
                    <td class="text-right">Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>TOTAL GAJI BERSIH</td>
                    <td class="text-right">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        @if($gaji->keterangan_gaji)
        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Keterangan</div>
                <div class="info-value">: {{ $gaji->keterangan_gaji }}</div>
            </div>
        </div>
        @endif

        <div class="signature-section">
            <div class="signature-box">
                <div>{{ now()->format('d F Y') }}</div>
                <div>Karyawan</div>
                <div class="signature-line"></div>
                <div>{{ $gaji->karyawan->user->name }}</div>
            </div>
            <div class="signature-box">
                <div>{{ now()->format('d F Y') }}</div>
                <div>HRD</div>
                <div class="signature-line"></div>
                <div>_________________</div>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>