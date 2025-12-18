<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Dosen;

class Nilai extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'perusahaan_id',
        'nilai',
        'semester',
        'tahun_ajaran',
        'kategori',
        'sks',
    ];

    /**
     * Default attribute values for model instances.
     */
    protected $attributes = [
        //
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'tahun_ajaran' => 'integer',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}
