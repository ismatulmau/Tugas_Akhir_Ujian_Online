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
    Schema::table('bank_soals', function (Blueprint $table) {
        $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif');
    });
}

public function down()
{
    Schema::table('bank_soals', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
