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
        Schema::create('jawabans', function (Blueprint $table) {
            $table->bigIncrements('id_jawaban');
            $table->unsignedBigInteger('id_sett_ujian');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_soal');
            $table->text('jawaban')->nullable(); // Bisa dikosongkan jika belum menjawab
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_sett_ujian')->references('id_sett_ujian')->on('setting_ujians')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswas')->onDelete('cascade');
            $table->foreign('id_soal')->references('id_soal')->on('soals')->onDelete('cascade');

            // Optional: pastikan satu siswa tidak menjawab soal yang sama lebih dari sekali
            $table->unique(['id_sett_ujian', 'id_siswa', 'id_soal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
