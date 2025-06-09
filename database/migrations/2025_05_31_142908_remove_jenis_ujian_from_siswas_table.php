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
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('jenis_ujian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('jenis_ujian')->nullable(); // Sesuaikan tipe data sesuai kebutuhan
        });
    }
};