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
    Schema::create('bank_soals', function (Blueprint $table) {
        $table->bigIncrements('id_bank_soal');
        $table->string('nama_bank_soal');
        $table->string('level');
        $table->string('kode_mapel')->references('kode_mapel')->on('mapels')->onDelete('cascade');
        $table->string('jurusan');
        $table->string('opsi_jawaban');
        $table->string('jml_soal');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soals');
    }
};
