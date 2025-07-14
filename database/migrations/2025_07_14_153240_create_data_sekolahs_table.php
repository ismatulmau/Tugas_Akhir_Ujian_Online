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
    Schema::create('data_sekolahs', function (Blueprint $table) {
        $table->id();
        $table->string('nama_sekolah');
        $table->string('logo')->nullable();
        $table->string('semester');
        $table->string('tahun_pelajaran');
        $table->string('nama_kepala_sekolah');
        $table->string('nip_kepala_sekolah');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sekolahs');
    }
};
