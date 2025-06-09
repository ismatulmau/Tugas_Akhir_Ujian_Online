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
    Schema::table('soals', function (Blueprint $table) {
        $table->string('opsi_e')->nullable()->change();
    });
}

public function down()
{
    Schema::table('soals', function (Blueprint $table) {
        $table->string('opsi_e')->nullable(false)->change();
    });
}

};
