<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'kode_kelas';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'kode_kelas',
        'level',
        'jurusan',
        'nama_kelas',
    ];

    public function mapels()
{
    return $this->belongsToMany(Mapel::class, 'kelas_mapel', 'kode_kelas', 'kode_mapel');
}

}
