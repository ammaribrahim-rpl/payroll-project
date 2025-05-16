<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Uncomment jika Anda menggunakan verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth; // Pastikan ini di-import jika Anda menggunakan Auth di dalam model, meskipun tidak umum

class User extends Authenticatable // implements MustVerifyEmail (jika pakai verifikasi email)
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gaji_pokok',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array // Penamaan method yang benar adalah casts() bukan getCasts()
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Otomatis hashing password saat diset
        ];
    }

    // Relasi ke Absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    // Helper untuk cek role
    public function isAdmin(): bool // Tambahkan return type hint untuk kejelasan
    {
        return $this->role === 'admin';
    }

    public function isKaryawan(): bool // Tambahkan return type hint untuk kejelasan
    {
        return $this->role === 'karyawan';
    }
}