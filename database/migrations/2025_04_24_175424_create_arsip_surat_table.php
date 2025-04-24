<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('arsip_surats', function (Blueprint $table) {
        $table->id();
        $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
        $table->string('jenis_surat');
        $table->text('keterangan')->nullable();
        $table->string('file_path')->nullable(); // Path PDF bila perlu
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_surats');
    }
};
