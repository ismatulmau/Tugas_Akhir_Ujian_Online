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
        Schema::create('soals', function (Blueprint $table) {
            $table->bigIncrements('id_soal'); // id soal
            $table->unsignedBigInteger('id_bank_soal')->references('id_bank_soal')->on('bank_soals')->onDelete('cascade'); // relasi ke bank soal
            $table->text('pertanyaan');
            $table->string('gambar_soal')->nullable();
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->string('opsi_e');
            $table->enum('jawaban_benar', ['A', 'B', 'C', 'D', 'E']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
