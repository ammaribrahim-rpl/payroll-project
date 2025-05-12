<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan'; // Eksplisit nama tabel

    protected $fillable = [
        'user_id',
        'nik',
        'alamat',
        'no_telepon',
        'posisi',
        'tanggal_masuk',
        'gaji_pokok',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'gaji_pokok' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function gaji()
    {
        return $this->hasMany(Gaji::class);
    }
}