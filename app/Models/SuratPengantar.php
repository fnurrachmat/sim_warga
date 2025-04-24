<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    use HasFactory;

    protected $table = 'surat_pengantar';

    protected $fillable = [
        'warga_id',
        'jenis_surat',
        'keperluan',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
