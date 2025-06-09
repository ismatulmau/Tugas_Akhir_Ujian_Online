<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('siswas', function (Blueprint $table) {
        $table->bigIncrements('id_siswa');
        $table->string('nama_siswa');
        $table->string('nomor_ujian')->unique();
        $table->string('level');
        $table->string('jurusan');
        $table->string('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade');
        $table->string('jenis_ujian');
        $table->string('nomor_induk');
        $table->string('gambar')->nullable();
        $table->string('password');
        $table->string('jenis_kelamin');
        $table->string('sesi_ujian');
        $table->string('ruang_ujian');
        $table->string('agama');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
