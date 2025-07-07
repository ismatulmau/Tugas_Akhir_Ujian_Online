<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use App\Models\Kelas;

class KelasImport implements ToModel, WithHeadingRow
{
    public $berhasil = 0;
    public $duplikat = 0;

    public function model(array $row)
    {
        try {
            if (!Kelas::where('kode_kelas', $row['kode_kelas'])->exists()) {
                $this->berhasil++;
                return new Kelas([
                    'kode_kelas' => $row['kode_kelas'],
                    'level' => $row['level'],
                    'jurusan' => $row['jurusan'],
                    'nama_kelas' => $row['nama_kelas'],
                ]);
            } else {
                $this->duplikat++;
            }
        } catch (\Exception $e) {
            Log::error('Import Kelas error: ' . $e->getMessage());
        }

        return null;
    }
}
