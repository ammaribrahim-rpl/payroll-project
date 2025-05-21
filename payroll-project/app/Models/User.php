<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Jika Anda menggunakan Sanctum

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan kolom 'role' ada di $fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke Karyawan jika ada
     */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class); // Pastikan model Karyawan di-import jika perlu
    }

    /**
     * Cek apakah user adalah admin.
     *
     * @return bool
     */
    public function isAdmin() // <--- TAMBAHKAN METHOD INI
    {
        return $this->role === 'admin'; // Sesuaikan 'admin' jika nilai di database berbeda
    }

    /**
     * Cek apakah user adalah karyawan.
     *
     * @return bool
     */
    public function isKaryawan() // <--- TAMBAHKAN METHOD INI JUGA
    {
        return $this->role === 'karyawan'; // Sesuaikan 'karyawan' jika nilai di database berbeda
    }
}