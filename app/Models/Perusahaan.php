<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'provinsi',
        'telepon',
        'email',
        'jurusan',
        'logo',
    ];
}
