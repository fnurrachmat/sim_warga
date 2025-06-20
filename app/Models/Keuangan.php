<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'tanggal',
        'keterangan',
        'jenis', // pemasukan atau pengeluaran
        'jumlah',
        'kategori', // iuran bulanan, sumbangan, acara, dll
        'bukti', // path ke file bukti (opsional)
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
