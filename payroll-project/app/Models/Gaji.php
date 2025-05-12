<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji'; // Eksplisit nama tabel

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'tahun',
        'total_hadir',
        'total_izin',
        'total_sakit',
        'total_tanpa_keterangan',
        'gaji_pokok',
        'potongan',
        'gaji_bersih',
        'keterangan_gaji',
        'tanggal_pembayaran',
    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'potongan' => 'decimal:2',
        'gaji_bersih' => 'decimal:2',
        'tanggal_pembayaran' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}