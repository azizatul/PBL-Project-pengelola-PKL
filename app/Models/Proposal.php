<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'file_name',
        'file_type',
        'status',
        'komentar',
        'dosen_id',
        'mahasiswa_id',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the dosen that owns the proposal.
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }

    /**
     * Get the mahasiswa that owns the proposal.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
