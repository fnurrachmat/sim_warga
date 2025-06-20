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

        // Default bulan (2 bulan terakhir)
        $bulan_sekarang = date('m');
        $tahun_sekarang = date('Y');

        $bulan_akhir = $request->filled('bulan_akhir') ? $request->bulan_akhir : $bulan_sekarang;
        $tahun_akhir = $request->filled('tahun_akhir') ? $request->tahun_akhir : $tahun_sekarang;

        // Hitung bulan awal (default 2 bulan sebelumnya)
        $bulan_awal = $request->filled('bulan_awal') ? $request->bulan_awal : (($bulan_sekarang - 1 <= 0) ? 12 - (1 - $bulan_sekarang) : $bulan_sekarang - 1);
        $tahun_awal = $request->filled('tahun_awal') ? $request->tahun_awal : (($bulan_sekarang - 1 <= 0) ? $tahun_sekarang - 1 : $tahun_sekarang);

        // Filter berdasarkan jenis (pemasukan/pengeluaran)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan bulan dan tahun
        $query->where(function($q) use ($bulan_awal, $tahun_awal, $bulan_akhir, $tahun_akhir) {
            // Jika tahun awal dan akhir sama
            if ($tahun_awal == $tahun_akhir) {
                $q->whereYear('tanggal', $tahun_awal)
                  ->whereMonth('tanggal', '>=', $bulan_awal)
                  ->whereMonth('tanggal', '<=', $bulan_akhir);
            } else {
                // Jika tahun berbeda
                $q->where(function($query) use ($bulan_awal, $tahun_awal, $bulan_akhir, $tahun_akhir) {
                    // Data di tahun awal
                    $query->where(function($q1) use ($bulan_awal, $tahun_awal) {
                        $q1->whereYear('tanggal', $tahun_awal)
                           ->whereMonth('tanggal', '>=', $bulan_awal);
                    })
                    // Data di tahun di antara (jika ada)
                    ->orWhere(function($q2) use ($tahun_awal, $tahun_akhir) {
                        if ($tahun_akhir - $tahun_awal > 1) {
                            for ($tahun = $tahun_awal + 1; $tahun < $tahun_akhir; $tahun++) {
                                $q2->orWhereYear('tanggal', $tahun);
                            }
                        }
                    })
                    // Data di tahun akhir
                    ->orWhere(function($q3) use ($bulan_akhir, $tahun_akhir) {
                        $q3->whereYear('tanggal', $tahun_akhir)
                           ->whereMonth('tanggal', '<=', $bulan_akhir);
                    });
                });
            }
        });

        // Ambil data keuangan
        $keuangan = $query->orderBy('tanggal', 'desc')->get();

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $keuangan->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $keuangan->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Ambil daftar kategori unik untuk filter
        $kategoriList = Keuangan::select('kategori')->distinct()->pluck('kategori');

        $saldoAwal = 0;
        if ($bulan_awal > 1 || $tahun_awal > date('Y') - 5) { // Jika bukan dari awal data
            $saldoAwalQuery = Keuangan::query()
                ->where(function($q) use ($bulan_awal, $tahun_awal) {
                    $q->whereYear('tanggal', '<', $tahun_awal)
                      ->orWhere(function($q2) use ($bulan_awal, $tahun_awal) {
                          $q2->whereYear('tanggal', $tahun_awal)
                             ->whereMonth('tanggal', '<', $bulan_awal);
                      });
                });

            $pemasukanAwal = $saldoAwalQuery->where('jenis', 'pemasukan')->sum('jumlah');
            $pengeluaranAwal = $saldoAwalQuery->where('jenis', 'pengeluaran')->sum('jumlah');
            $saldoAwal = $pemasukanAwal - $pengeluaranAwal;
        }

        // Daftar bulan untuk dropdown
        $daftarBulan = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
            // Tambahkan juga indeks numerik
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
            // Tambahkan format dengan leading zero
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
        ];

        // Daftar tahun (5 tahun ke belakang sampai tahun sekarang)
        $tahunSekarang = date('Y');
        $daftarTahun = range($tahunSekarang - 5, $tahunSekarang);

        return view('keuangan.index', compact(
            'keuangan', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir',
            'kategoriList', 'daftarBulan', 'daftarTahun',
            'bulan_awal', 'tahun_awal', 'bulan_akhir', 'tahun_akhir', 'saldoAwal'
        ));
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

        // Default bulan (2 bulan terakhir)
        $bulan_sekarang = date('m');
        $tahun_sekarang = date('Y');

        $bulan_akhir = $request->filled('bulan_akhir') ? $request->bulan_akhir : $bulan_sekarang;
        $tahun_akhir = $request->filled('tahun_akhir') ? $request->tahun_akhir : $tahun_sekarang;

        // Hitung bulan awal (default 2 bulan sebelumnya)
        $bulan_awal = $request->filled('bulan_awal') ? $request->bulan_awal : (($bulan_sekarang - 1 <= 0) ? 12 - (1 - $bulan_sekarang) : $bulan_sekarang - 1);
        $tahun_awal = $request->filled('tahun_awal') ? $request->tahun_awal : (($bulan_sekarang - 1 <= 0) ? $tahun_sekarang - 1 : $tahun_sekarang);

        // Pastikan bulan_awal dan bulan_akhir adalah string
        $bulan_awal = (string) $bulan_awal;
        $bulan_akhir = (string) $bulan_akhir;

        // Filter berdasarkan jenis (pemasukan/pengeluaran)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan bulan dan tahun
        $query->where(function($q) use ($bulan_awal, $tahun_awal, $bulan_akhir, $tahun_akhir) {
            // Jika tahun awal dan akhir sama
            if ($tahun_awal == $tahun_akhir) {
                $q->whereYear('tanggal', $tahun_awal)
                  ->whereMonth('tanggal', '>=', $bulan_awal)
                  ->whereMonth('tanggal', '<=', $bulan_akhir);
            } else {
                // Jika tahun berbeda
                $q->where(function($query) use ($bulan_awal, $tahun_awal, $bulan_akhir, $tahun_akhir) {
                    // Data di tahun awal
                    $query->where(function($q1) use ($bulan_awal, $tahun_awal) {
                        $q1->whereYear('tanggal', $tahun_awal)
                           ->whereMonth('tanggal', '>=', $bulan_awal);
                    })
                    // Data di tahun di antara (jika ada)
                    ->orWhere(function($q2) use ($tahun_awal, $tahun_akhir) {
                        if ($tahun_akhir - $tahun_awal > 1) {
                            for ($tahun = $tahun_awal + 1; $tahun < $tahun_akhir; $tahun++) {
                                $q2->orWhereYear('tanggal', $tahun);
                            }
                        }
                    })
                    // Data di tahun akhir
                    ->orWhere(function($q3) use ($bulan_akhir, $tahun_akhir) {
                        $q3->whereYear('tanggal', $tahun_akhir)
                           ->whereMonth('tanggal', '<=', $bulan_akhir);
                    });
                });
            }
        });

        // Ambil data keuangan
        $keuangan = $query->orderBy('tanggal', 'asc')->get(); // Ubah ke ASC untuk urutan kronologis

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $keuangan->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $keuangan->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Daftar bulan untuk nama bulan
        $daftarBulan = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
            // Tambahkan juga indeks numerik
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
            // Tambahkan format dengan leading zero
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
        ];

        // Jika perlu, tambahkan data saldo awal sebelum periode
        // Misalnya dengan menghitung saldo dari semua transaksi sebelum periode yang dipilih
        $saldoAwal = 0;
        if ($bulan_awal > 1 || $tahun_awal > date('Y') - 5) { // Jika bukan dari awal data
            $saldoAwalQuery = Keuangan::query()
                ->where(function($q) use ($bulan_awal, $tahun_awal) {
                    $q->whereYear('tanggal', '<', $tahun_awal)
                      ->orWhere(function($q2) use ($bulan_awal, $tahun_awal) {
                          $q2->whereYear('tanggal', $tahun_awal)
                             ->whereMonth('tanggal', '<', $bulan_awal);
                      });
                });

            $pemasukanAwal = $saldoAwalQuery->where('jenis', 'pemasukan')->sum('jumlah');
            $pengeluaranAwal = $saldoAwalQuery->where('jenis', 'pengeluaran')->sum('jumlah');
            $saldoAwal = $pemasukanAwal - $pengeluaranAwal;
        }

        $pdf = PDF::loadView('keuangan.pdf', compact(
            'keuangan', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir',
            'bulan_awal', 'tahun_awal', 'bulan_akhir', 'tahun_akhir', 'daftarBulan', 'saldoAwal'
        ));

        // Set paper ke landscape jika periode lebih dari 2 bulan
        $totalBulan = (($tahun_akhir - $tahun_awal) * 12) + ($bulan_akhir - $bulan_awal) + 1;
        if ($totalBulan > 2) {
            $pdf->setPaper('a4', 'landscape');
        } else {
            $pdf->setPaper('a4', 'portrait');
        }

        return $pdf->download('laporan-keuangan.pdf');
    }
}
