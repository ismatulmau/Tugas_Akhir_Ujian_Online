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
        Schema::create('setting_ujians', function (Blueprint $table) {
    $table->bigIncrements('id_sett_ujian');
    $table->unsignedBigInteger('id_bank_soal');
    $table->string('jenis_tes'); // UTS / UAS
    $table->string('semester');
    $table->string('sesi');
    $table->datetime('waktu_mulai');
    $table->datetime('waktu_selesai');
    $table->integer('durasi');
    $table->string('token');
    $table->timestamps();

    $table->foreign('id_bank_soal')->references('id_bank_soal')->on('bank_soals')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_ujians');
    }
};
