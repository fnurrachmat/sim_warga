<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'warga_id',
        'jenis_surat',
        'keterangan',
        'file_path',
    ];

    // Relasi ke Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
