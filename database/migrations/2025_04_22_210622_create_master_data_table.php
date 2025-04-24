<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('master_data', function (Blueprint $table) {
        $table->id();
        $table->string('jenis'); // Untuk kategori seperti 'agama', 'pendidikan', dll
        $table->string('nama');  // Nilai untuk masing-masing jenis
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('master_data');
}

};
