<?php

namespace App\Http\Controllers;
use App\Models\Warga;
use App\Models\MasterData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WargaExport;



class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $warga = $query->orderBy('nama')->get();
        return view('warga.index', compact('warga'));
    }


    public function create()
    {
        $agamas = MasterData::where('jenis', 'agama')->get();
        $pendidikans = MasterData::where('jenis', 'pendidikan')->get();
        $pekerjaans = MasterData::where('jenis', 'pekerjaan')->get();
        $statuss = MasterData::where('jenis', 'status')->get();
        $kewarganegaraans = MasterData::where('jenis', 'kewarganegaraan')->get();
        $statusdalamkeluargas = MasterData::where('jenis', 'StatusDalamKeluarga')->get();
        $golongandarahs = MasterData::where('jenis', 'Golongan Darah')->get();

        return view('warga.create', compact('agamas', 'pendidikans', 'pekerjaans', 'statuss', 'kewarganegaraans', 'statusdalamkeluargas', 'golongandarahs'));
    }

        public function edit(Warga $warga)
    {
        $agamas = MasterData::where('jenis', 'agama')->get();
        $pendidikans = MasterData::where('jenis', 'pendidikan')->get();
        $pekerjaans = MasterData::where('jenis', 'pekerjaan')->get();
        $statuss = MasterData::where('jenis', 'status')->get();
        $kewarganegaraans = MasterData::where('jenis', 'kewarganegaraan')->get();
        $statusdalamkeluargas = MasterData::where('jenis', 'StatusDalamKeluarga')->get();
        $golongandarahs = MasterData::where('jenis', 'Golongan Darah')->get();

        return view('warga.edit', compact('warga', 'agamas', 'pendidikans', 'pekerjaans', 'statuss', 'kewarganegaraans', 'statusdalamkeluargas', 'golongandarahs'));
    }


        public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:warga',
            'no_kk' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama_id' => 'required|exists:master_data,id',
            'pendidikan_id' => 'required|exists:master_data,id',
            'pekerjaan_id' => 'required|exists:master_data,id',
            'status_id' => 'required|exists:master_data,id',
            'kewarganegaraan_id' => 'required|exists:master_data,id',
            'statusdalamkeluarga_id' => 'required|exists:master_data,id',
            'golongandarah_id' => 'required|exists:master_data,id',
            // 'status_perkawinan' => 'nullable|string',
            // 'kewarganegaraan' => 'nullable|string',
            // 'status_dalam_keluarga' => 'nullable|string',
            'golongan_darah' => 'nullable|string',
            'telepon' => 'nullable|string',
        ]);

        Warga::create($request->all());

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil disimpan!');
    }





    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:warga,nik,' . $warga->id,
            'no_kk' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama_id' => 'required|exists:master_data,id',
            'pendidikan_id' => 'required|exists:master_data,id',
            'pekerjaan_id' => 'required|exists:master_data,id',
            'status_perkawinan' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'status_dalam_keluarga' => 'nullable|string',
            'golongan_darah' => 'nullable|string',
            'telepon' => 'nullable|string',
        ]);

        $warga->update($request->all());

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $warga = Warga::findOrFail($id);
        $warga->delete();

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil dihapus!');
    }

    public function exportPdf()
{
    $warga = Warga::all();
    $pdf = PDF::loadView('warga.export_pdf', compact('warga'));
    return $pdf->download('data_warga.pdf');
}

public function exportExcel()
{
    return Excel::download(new WargaExport, 'data_warga.xlsx');
}

// Tampilkan daftar keluarga unik
public function keluargaIndex(Request $request)
{
    $query = Warga::select('no_kk')->groupBy('no_kk');

    if ($request->filled('search')) {
        $query->where('no_kk', 'like', '%' . $request->search . '%');
    }

    $keluarga = $query->get();

    return view('keluarga.index', compact('keluarga'));
}

// Detail anggota keluarga berdasarkan no_kk
public function keluargaDetail($no_kk)
{
    $anggota = Warga::where('no_kk', $no_kk)->get();

    return view('keluarga.detail', compact('anggota', 'no_kk'));
}

public function keluargaExportPdf($no_kk)
{
    $anggota = Warga::where('no_kk', $no_kk)->get();

    $pdf = PDF::loadView('keluarga.pdf', compact('anggota', 'no_kk'))->setPaper('a4', 'portrait');

    return $pdf->stream('kartu-keluarga-' . $no_kk . '.pdf');
}



}
