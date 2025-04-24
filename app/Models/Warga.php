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

    public function pendidikanRef()
    {
        return $this->belongsTo(MasterData::class, 'pendidikan');
    }

    public function pekerjaanRef()
    {
        return $this->belongsTo(MasterData::class, 'pekerjaan');
    }

    public function agamaRef()
    {
        return $this->belongsTo(MasterData::class, 'agama');
    }

    public function statusPerkawinanRef()
    {
        return $this->belongsTo(MasterData::class, 'status_perkawinan');
    }

    public function kewarganegaraanRef()
    {
        return $this->belongsTo(MasterData::class, 'kewarganegaraan');
    }

    public function statusDalamKeluargaRef()
    {
        return $this->belongsTo(MasterData::class, 'status_dalam_keluarga');
    }

    public function golonganDarahRef()
    {
        return $this->belongsTo(MasterData::class, 'golongan_darah');
    }

}
