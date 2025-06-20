<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keuangan;
use Carbon\Carbon;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data kategori
        $kategoriPemasukan = ['Iuran Bulanan', 'Sumbangan', 'Donasi', 'Denda', 'Lain-lain'];
        $kategoriPengeluaran = ['Kebersihan', 'Keamanan', 'Acara', 'Perbaikan', 'Administrasi', 'Lain-lain'];

        // Tanggal awal (3 bulan ke belakang)
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();

        // Generate data pemasukan
        for ($date = clone $startDate; $date <= $endDate; $date->addDays(rand(1, 5))) {
            // Iuran bulanan di awal bulan
            if ($date->day <= 10) {
                Keuangan::create([
                    'tanggal' => clone $date,
                    'keterangan' => 'Iuran bulanan RT ' . $date->format('F Y'),
                    'jenis' => 'pemasukan',
                    'jumlah' => rand(50, 100) * 10000, // 500rb - 1jt
                    'kategori' => 'Iuran Bulanan',
                ]);
            }

            // Pemasukan acak
            if (rand(1, 10) > 7) { // 30% kemungkinan ada pemasukan tambahan
                Keuangan::create([
                    'tanggal' => clone $date,
                    'keterangan' => 'Pemasukan ' . $kategoriPemasukan[array_rand($kategoriPemasukan)],
                    'jenis' => 'pemasukan',
                    'jumlah' => rand(10, 50) * 10000, // 100rb - 500rb
                    'kategori' => $kategoriPemasukan[array_rand($kategoriPemasukan)],
                ]);
            }
        }

        // Generate data pengeluaran
        for ($date = clone $startDate; $date <= $endDate; $date->addDays(rand(2, 7))) {
            Keuangan::create([
                'tanggal' => clone $date,
                'keterangan' => 'Pengeluaran untuk ' . $kategoriPengeluaran[array_rand($kategoriPengeluaran)],
                'jenis' => 'pengeluaran',
                'jumlah' => rand(5, 40) * 10000, // 50rb - 400rb
                'kategori' => $kategoriPengeluaran[array_rand($kategoriPengeluaran)],
            ]);

            // Pengeluaran acak tambahan
            if (rand(1, 10) > 8) { // 20% kemungkinan ada pengeluaran tambahan
                Keuangan::create([
                    'tanggal' => clone $date,
                    'keterangan' => 'Pengeluaran tambahan untuk ' . $kategoriPengeluaran[array_rand($kategoriPengeluaran)],
                    'jenis' => 'pengeluaran',
                    'jumlah' => rand(5, 20) * 10000, // 50rb - 200rb
                    'kategori' => $kategoriPengeluaran[array_rand($kategoriPengeluaran)],
                ]);
            }
        }
    }
}
