<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class BankSoal extends Model
{
    use HasFactory;

    protected $table = 'bank_soals';
    protected $primaryKey = 'id_bank_soal';
    public $incrementing = true;
    protected $keyType = 'integer';

    protected $fillable = [
        'nama_bank_soal',
        'kode_kelas',
        'level',
        'kode_mapel',
        'jurusan',
        'opsi_jawaban',
        'jml_soal',
    ];

    //Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    //Relasi ke model Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'kode_mapel', 'kode_mapel');
    }

    public function soals()
{
    return $this->hasMany(Soal::class, 'id_bank_soal', 'id_bank_soal');
}

public function settingUjian()
{
    return $this->hasOne(SettingUjian::class, 'id_bank_soal', 'id_bank_soal');
}

protected static function booted()
{
    static::deleting(function ($banksoal) {
        // Ambil semua soal terkait
        foreach ($banksoal->soals as $soal) {
            // Hapus gambar jika ada
            if ($soal->gambar_soal && Storage::disk('public')->exists($soal->gambar_soal)) {
                Storage::disk('public')->delete($soal->gambar_soal);
            }

            // Hapus soalnya
            $soal->delete();
        }

        // Jika kamu juga ingin menghapus file lainnya (misalnya gambar pembahasan), bisa ditambahkan di sini
    });
}


}