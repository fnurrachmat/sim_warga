<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWargaTable extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('agama', 50)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('status_perkawinan', 50)->nullable();
            $table->string('kewarganegaraan', 50)->nullable();
            $table->string('status_dalam_keluarga', 50)->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
}
