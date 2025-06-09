<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasFactory;
    protected $guard = 'siswa';
    protected $table = 'siswas';
    protected $fillable = ['nama_siswa', 
    'nomor_ujian', 
    'level', 
    'jurusan', 
    'kode_kelas', 
    'jenis_ujian', 
    'nomor_induk', 
    'gambar', 
    'password', 
    'jenis_kelamin', 
    'sesi_ujian', 
    'ruang_ujian', 
    'agama',
    'password_asli'];


    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    protected $primaryKey = 'id_siswa';
    protected $hidden = ['password'];
}
    