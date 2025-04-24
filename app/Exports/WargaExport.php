<?php

namespace App\Exports;

use App\Models\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;

class WargaExport implements FromCollection
{
    public function collection()
    {
        return Warga::all();
    }
}
