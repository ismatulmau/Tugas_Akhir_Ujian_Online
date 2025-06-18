<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawabans';
    protected $primaryKey = 'id_jawaban';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_sett_ujian',
        'id_siswa',
        'id_soal',
        'jawaban',
    ];

    public function settingUjian()
    {
        return $this->belongsTo(SettingUjian::class, 'id_sett_ujian', 'id_sett_ujian');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }
}
