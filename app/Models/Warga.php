<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';

    protected $fillable = [
        'nama', 'nik', 'no_kk', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'alamat', 'agama', 'pendidikan', 'pekerjaan', 'status_perkawinan',
        'kewarganegaraan', 'status_dalam_keluarga', 'golongan_darah', 'telepon',
        'agama_id','pendidikan_id','pekerjaan_id','status_id','kewarganegaraan_id','statusdalamkeluarga_id','golongandarah_id'
    ];

    public function mutasi()
    {
        return $this->hasMany(Mutasi::class);
    }
}
