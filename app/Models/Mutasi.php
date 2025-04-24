<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $table = 'mutasi';

    protected $fillable = ['warga_id', 'jenis', 'tanggal', 'alasan', 'tujuan'];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}

