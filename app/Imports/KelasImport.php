<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class KelasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // Cek apakah data dengan kode_mapel ini sudah ada
            if (!Kelas::where('kode_kelas', $row['kode_kelas'])->exists()) {
                return new Kelas([
                    'kode_kelas' => $row['kode_kelas'],
                    'level' => $row['level'],
                    'jurusan' => $row['jurusan'],
                    'nama_kelas' => $row['nama_kelas'],
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return null;
        }
    }
}


