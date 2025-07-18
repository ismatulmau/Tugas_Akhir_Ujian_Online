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
    Schema::table('data_sekolahs', function (Blueprint $table) {
        $table->text('alamat')->nullable()->after('nama_sekolah'); // sesuaikan posisi kolom jika perlu
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('data_sekolahs', function (Blueprint $table) {
        $table->dropColumn('alamat');
    });
}
};
