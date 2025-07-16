<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSekolah extends Model
{
    // Jika nama tabel tidak sesuai dengan konvensi Laravel (jamak)
    protected $table = 'data_sekolahs';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'logo',
        'semester',
        'tahun_pelajaran',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'jenis_tes',
    ];

}
