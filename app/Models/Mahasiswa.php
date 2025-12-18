<?php

namespace App\Models;

// 1. Ganti import ini
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

// 2. Ubah 'extends Model' menjadi 'extends Authenticatable'
class Mahasiswa extends Authenticatable
{
    use Notifiable;

    protected $table = 'mahasiswas';
    
    // Tambahkan ini agar Auth tahu field password-nya (jika nama kolomnya bukan 'password')
    // Jika kolom di database namanya 'password', baris ini tidak perlu.
    // protected $password = 'password'; 

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'email',
        'telepon',
        'alamat',
        'password',
        'angkatan',
        'prodi_id',
        'photo',
        'status_validasi',
        'bimbingan_count',
        'seminar_progress',
        'attendance_percentage',
    ];

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'nim';
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}