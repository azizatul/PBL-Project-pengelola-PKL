<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'provinsi',
        'telepon',
        'email',
        'jurusan',
        'logo'
    ];

    public function mahasiswas()
    {
        return $this->hasMany(User::class, 'mitra_id');
    }
}
