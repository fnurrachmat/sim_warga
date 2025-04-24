<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\SuratPengantar;
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
        $pendidikan = Warga::select('pendidikan_id', DB::raw('count(*) as total'))
        ->groupBy('pendidikan_id')
        ->get();

        // Pekerjaan
        $pekerjaan = Warga::select('pekerjaan_id', DB::raw('count(*) as total'))
        ->groupBy('pekerjaan_id')
        ->get();

        return view('dashboard', compact('totalWarga', 'totalKK', 'totalSurat','lakiLaki','perempuan','menikah','belumMenikah','usiaAnak', 'usiaDewasaMuda', 'usiaDewasa', 'usiaLansia', 'pendidikan', 'pekerjaan'));
    }
}
