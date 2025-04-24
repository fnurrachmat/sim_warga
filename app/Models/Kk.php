<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kk extends Model
{
    protected $table = 'kk';

    protected $fillable = [
        'no_kk', 'kepala_keluarga', 'alamat', 'rt', 'rw',
        'kelurahan', 'kecamatan', 'kota', 'kode_pos'
    ];
}

