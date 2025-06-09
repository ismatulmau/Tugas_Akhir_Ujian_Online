<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapels';
    protected $primaryKey = 'kode_mapel';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'persen_uts',
        'persen_uas',
        'kkm',
    ];

    
}

