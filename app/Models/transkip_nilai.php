<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transkip_nilai extends Model
{
    use HasFactory;

    // WAJIB ADA: Daftarkan semua nama kolom database di sini
    protected $fillable = [
        'mahasiswa_id',
        'original_filename',
        'file_path',
        'status',
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}