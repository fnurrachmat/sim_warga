<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    protected $table = 'master_data';

    protected $fillable = [
        'jenis',
        'nama',
    ];

    public $timestamps = false;
}
