<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingUjian extends Model
{
    protected $table = 'setting_ujians';
    protected $primaryKey = 'id_sett_ujian';
    public $incrementing = true;
    protected $keyType = 'integer';

    protected $fillable = [
        'id_bank_soal',
        'jenis_tes',
        'semester',
        'sesi',
        'waktu_mulai',
        'waktu_selesai',
        'durasi',
        'token',
    ];

    public function bankSoal()
{
    return $this->belongsTo(BankSoal::class, 'id_bank_soal', 'id_bank_soal');
}

}
