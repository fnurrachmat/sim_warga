<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use App\Models\Warga;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ArsipSuratController extends Controller
{
    public function index()
    {
        // Ambil semua arsip surat
        $arsipSurat = ArsipSurat::with('warga')->get();
        return view('arsip.index', compact('arsipSurat'));
    }

    public function create()
    {
        // Ambil daftar warga untuk dipilih
        $warga = Warga::all();
        return view('arsip.create', compact('warga'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'jenis_surat' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_path' => 'nullable|string', // Path file PDF jika ada
        ]);

        // Simpan arsip surat
        ArsipSurat::create($request->all());

        return redirect()->route('arsip.index')->with('success', 'Arsip Surat berhasil disimpan!');
    }

    public function cetakUlang($id)
    {
        // Ambil data arsip surat berdasarkan ID
        $arsip = ArsipSurat::findOrFail($id);

        // Data untuk disertakan dalam PDF
        $data = [
            'arsip' => $arsip,
            'warga' => $arsip->warga,  // Ambil data warga terkait
        ];

        // Generate PDF
        $pdf = Pdf::loadView('arsip.surat_pdf', $data);

        // Return PDF untuk diunduh
        return $pdf->download('Surat_Pengantar_' . $arsip->id . '.pdf');
    }
}
