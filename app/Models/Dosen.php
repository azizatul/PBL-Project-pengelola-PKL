<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $fillable = [
        'nama_dosen',
        'nip',
        'email',
        'alamat',
        'telepon',
        'photo',
    ];
}
