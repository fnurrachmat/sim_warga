<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKkTable extends Migration
{
    public function up(): void
    {
        Schema::create('kk', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 16)->unique();
            $table->string('kepala_keluarga', 100);
            $table->text('alamat');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('kelurahan', 100);
            $table->string('kecamatan', 100);
            $table->string('kota', 100);
            $table->string('kode_pos', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kk');
    }
}
