<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    protected $fillable = [
        'tanggal',
        'waktu',
        'lokasi',
        'topik',
        'deskripsi',
        'status',
        'mahasiswa_id',
        'dosen_id',
        'kaprodi_id'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }


}
