<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->foreignId('agama_id')->nullable()->constrained('master_data')->onDelete('set null');
            $table->foreignId('pendidikan_id')->nullable()->constrained('master_data')->onDelete('set null');
            $table->foreignId('pekerjaan_id')->nullable()->constrained('master_data')->onDelete('set null');
            $table->foreignId('status_id')->nullable()->constrained('master_data')->onDelete('set null');
            $table->foreignId('kewarganegaraan_id')->nullable()->constrained('master_data')->onDelete('set null');
            $table->foreignId('statusdalamkeluarga_id')->nullable()->constrained('master_data')->onDelete('set null');
            $table->foreignId('golongandarah_id')->nullable()->constrained('master_data')->onDelete('set null');
            // Tambahkan field lainnya sesuai kebutuhan
        });
    }

    public function down()
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->dropForeign(['agama_id', 'pendidikan_id', 'pekerjaan_id', 'status_id', 'kewarganegaraan_id', 'statusdalamkeluarga_id', 'golongandarah_id']);
            // Drop field lainnya jika ada
        });
    }

};
