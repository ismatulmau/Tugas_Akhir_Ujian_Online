<?php

// App\Imports\MapelImport.php

namespace App\Imports;

use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class MapelImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // Cek apakah data dengan kode_mapel ini sudah ada
            if (!Mapel::where('kode_mapel', $row['kode_mapel'])->exists()) {
                return new Mapel([
                    'kode_mapel' => $row['kode_mapel'],
                    'nama_mapel' => $row['nama_mapel'],
                    'persen_uts' => $row['persen_uts'],
                    'persen_uas' => $row['persen_uas'],
                    'kkm'        => $row['kkm'],
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return null;
        }
    }
}


