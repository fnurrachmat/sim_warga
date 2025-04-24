<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Pastikan mengimpor DB dari sini

class MasterDataTableSeeder extends Seeder

{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_data')->insert([
            ['jenis' => 'agama', 'nama' => 'Islam'],
            ['jenis' => 'agama', 'nama' => 'Kristen'],
            ['jenis' => 'agama', 'nama' => 'Hindu'],
            ['jenis' => 'agama', 'nama' => 'Budha'],
            ['jenis' => 'pendidikan', 'nama' => 'SD'],
            ['jenis' => 'pendidikan', 'nama' => 'SMP'],
            ['jenis' => 'pendidikan', 'nama' => 'SMA'],
            ['jenis' => 'pendidikan', 'nama' => 'S1'],
            ['jenis' => 'pendidikan', 'nama' => 'S2'],
            ['jenis' => 'pekerjaan', 'nama' => 'PNS'],
            ['jenis' => 'pekerjaan', 'nama' => 'Swasta'],
            ['jenis' => 'pekerjaan', 'nama' => 'Freelance'],
            ['jenis' => 'status', 'nama' => 'Belum Kawin'],
            ['jenis' => 'status', 'nama' => 'Kawin'],
            ['jenis' => 'kewarganegaraan', 'nama' => 'WNI'],
            ['jenis' => 'kewarganegaraan', 'nama' => 'WNA'],
            ['jenis' => 'StatusDalamKeluarga', 'nama' => 'Kepala Keluarga'],
            ['jenis' => 'StatusDalamKeluarga', 'nama' => 'Isri'],
            ['jenis' => 'StatusDalamKeluarga', 'nama' => 'Anak'],
            ['jenis' => 'Golongan Darah', 'nama' => 'A'],
            ['jenis' => 'Golongan Darah', 'nama' => 'B'],
            ['jenis' => 'Golongan Darah', 'nama' => 'AB'],
            ['jenis' => 'Golongan Darah', 'nama' => 'O'],
        ]);

    }
}
