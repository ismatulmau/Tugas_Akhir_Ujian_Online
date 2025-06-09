<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soals'; 
    protected $primaryKey = 'id_soal'; 
    protected $fillable = [
        'id_bank_soal',
        'pertanyaan',
        'gambar_soal',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',
        'jawaban_benar',
    ];

    /**
     * Relasi: Satu soal dimiliki oleh satu bank soal
     */
    public function bankSoal()
    {
        return $this->belongsTo(BankSoal::class, 'id_bank_soal');
    }
    
}
