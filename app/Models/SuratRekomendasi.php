<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratRekomendasi extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'nomor_surat',
        'tanggal_surat',
        'isi_surat',
        'persyaratan',
        'status',
        'catatan',
        'dokumen',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
