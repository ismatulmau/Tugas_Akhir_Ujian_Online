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
    Schema::table('bank_soals', function (Blueprint $table) {
        $table->string('kode_kelas')->nullable()->after('nama_bank_soal'); // atau after kolom lain sesuai kebutuhan
    });
}

public function down(): void
{
    Schema::table('bank_soals', function (Blueprint $table) {
        $table->dropColumn('kode_kelas');
    });
}
};
