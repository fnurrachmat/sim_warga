<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\SuratPengantar;
use App\Models\Keuangan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalWarga = Warga::count();
        $lakiLaki = Warga::where('jenis_kelamin', 'L')->count();
        $perempuan = Warga::where('jenis_kelamin', 'P')->count();
        $menikah = Warga::where('status_perkawinan', 'Menikah')->count();
        $belumMenikah = Warga::where('status_perkawinan', 'Belum Menikah')->count();
        $totalKK = Warga::distinct('no_kk')->count('no_kk');
        $totalSurat = SuratPengantar::count();

        $today = Carbon::today();

        $usiaAnak = Warga::whereBetween('tanggal_lahir', [$today->copy()->subYears(17), $today])->count();
        $usiaDewasaMuda = Warga::whereBetween('tanggal_lahir', [$today->copy()->subYears(40), $today->copy()->subYears(18)])->count();
        $usiaDewasa = Warga::whereBetween('tanggal_lahir', [$today->copy()->subYears(60), $today->copy()->subYears(41)])->count();
        $usiaLansia = Warga::where('tanggal_lahir', '<=', $today->copy()->subYears(60))->count();

        // Pendidikan
        $pendidikan = Warga::select('pendidikan_id', 'md.nama as nama_pendidikan', DB::raw('count(*) as total'))
        ->join('master_data as md', 'warga.pendidikan_id', '=', 'md.id')
        ->groupBy('pendidikan_id', 'md.nama')
        ->get();

        // Pekerjaan
        $pekerjaan = Warga::select('pekerjaan_id', 'md.nama as nama_pekerjaan', DB::raw('count(*) as total'))
        ->join('master_data as md', 'warga.pekerjaan_id', '=', 'md.id')
        ->groupBy('pekerjaan_id', 'md.nama')
        ->get();

        // Keuangan - Data 2 bulan terakhir
        $bulan_sekarang = date('m');
        $tahun_sekarang = date('Y');

        $bulan_akhir = $bulan_sekarang;
        $tahun_akhir = $tahun_sekarang;

        // Hitung bulan awal (2 bulan sebelumnya)
        $bulan_awal = (($bulan_sekarang - 1) <= 0) ? 12 - (1 - $bulan_sekarang) : $bulan_sekarang - 1;
        $tahun_awal = (($bulan_sekarang - 1) <= 0) ? $tahun_sekarang - 1 : $tahun_sekarang;

        // Tanggal awal dan akhir untuk tampilan
        $startDate = Carbon::createFromDate($tahun_awal, $bulan_awal, 1);
        $endDate = Carbon::createFromDate($tahun_akhir, $bulan_akhir, 1)->endOfMonth();

        // Query untuk data keuangan
        $query = Keuangan::query();

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
                    // Data di tahun akhir
                    ->orWhere(function($q3) use ($bulan_akhir, $tahun_akhir) {
                        $q3->whereYear('tanggal', $tahun_akhir)
                           ->whereMonth('tanggal', '<=', $bulan_akhir);
                    });
                });
            }
        });

        // Ambil data keuangan
        $keuangan = $query->get();

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $keuangan->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $keuangan->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoKeuangan = $totalPemasukan - $totalPengeluaran;

        // Hitung saldo awal (transaksi sebelum periode)
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

        // Total saldo = saldo awal + saldo periode
        $totalSaldo = $saldoAwal + $saldoKeuangan;

        // Transaksi terbaru (5 transaksi terakhir)
        $transaksiTerbaru = Keuangan::orderBy('tanggal', 'desc')->limit(5)->get();

        return view('dashboard', compact(
            'totalWarga', 'totalKK', 'totalSurat', 'lakiLaki', 'perempuan',
            'menikah', 'belumMenikah', 'usiaAnak', 'usiaDewasaMuda',
            'usiaDewasa', 'usiaLansia', 'pendidikan', 'pekerjaan',
            'totalPemasukan', 'totalPengeluaran', 'saldoKeuangan',
            'saldoAwal', 'totalSaldo', 'transaksiTerbaru', 'startDate', 'endDate',
            'bulan_awal', 'bulan_akhir', 'tahun_awal', 'tahun_akhir'
        ));
    }
}
