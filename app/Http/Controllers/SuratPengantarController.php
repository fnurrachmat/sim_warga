<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPengantar;
use App\Models\Warga;
use Barryvdh\DomPDF\Facade\PDF;

class SuratPengantarController extends Controller
{
    public function index()
    {
        $surat = SuratPengantar::with('warga')->latest()->get();
        return view('surat.index', compact('surat'));
    }

    public function create()
    {
        $warga = Warga::all();
        return view('surat.create', compact('warga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'jenis_surat' => 'required|string|max:255',
            'keperluan' => 'nullable|string',
        ]);

        $surat = SuratPengantar::create([
            'warga_id' => $request->warga_id,
            'jenis_surat' => $request->jenis_surat,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dibuat.');
    }

    public function cetakPdf($id)
    {
        $surat = SuratPengantar::with('warga')->findOrFail($id);

        $pdf = PDF::loadView('surat.template', compact('surat'))->setPaper('a4');
        return $pdf->stream('surat-pengantar-' . $surat->id . '.pdf');
    }
}
