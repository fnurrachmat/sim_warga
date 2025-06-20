<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\PDF;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Keuangan::query();

        // Filter berdasarkan jenis (pemasukan/pengeluaran)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        // Ambil data keuangan
        $keuangan = $query->orderBy('tanggal', 'desc')->get();

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $keuangan->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $keuangan->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Ambil daftar kategori unik untuk filter
        $kategoriList = Keuangan::select('kategori')->distinct()->pluck('kategori');

        return view('keuangan.index', compact('keuangan', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir', 'kategoriList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('keuangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $data = $request->except('bukti');

        // Upload bukti jika ada
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_keuangan', 'public');
            $data['bukti'] = $buktiPath;
        }

        Keuangan::create($data);

        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keuangan $keuangan)
    {
        return view('keuangan.edit', compact('keuangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keuangan $keuangan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $data = $request->except('bukti');

        // Upload bukti jika ada
        if ($request->hasFile('bukti')) {
            // Hapus file lama jika ada
            if ($keuangan->bukti) {
                Storage::disk('public')->delete($keuangan->bukti);
            }

            $buktiPath = $request->file('bukti')->store('bukti_keuangan', 'public');
            $data['bukti'] = $buktiPath;
        }

        $keuangan->update($data);

        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keuangan $keuangan)
    {
        // Hapus file bukti jika ada
        if ($keuangan->bukti) {
            Storage::disk('public')->delete($keuangan->bukti);
        }

        $keuangan->delete();

        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil dihapus');
    }

    /**
     * Export laporan keuangan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Keuangan::query();

        // Filter berdasarkan jenis (pemasukan/pengeluaran)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        // Ambil data keuangan
        $keuangan = $query->orderBy('tanggal', 'desc')->get();

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $keuangan->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $keuangan->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        $pdf = PDF::loadView('keuangan.pdf', compact('keuangan', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir'));

        return $pdf->download('laporan-keuangan.pdf');
    }
}
