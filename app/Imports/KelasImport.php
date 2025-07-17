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
    public $levelTidakValid = []; 
    protected $levelValid = ['X', 'XI', 'XII'];

    public function model(array $row)
{
    try {
        // Abaikan baris kosong (tidak ada data penting)
        if (
            empty($row['kode_kelas']) &&
            empty($row['level']) &&
            empty($row['jurusan']) &&
            empty($row['nama_kelas'])
        ) {
            return null;
        }

        $level = strtoupper(trim($row['level']));

        if (!in_array($level, $this->levelValid)) {
            // Hanya tambahkan jika benar-benar tidak kosong
            if ($level !== '') {
                $this->levelTidakValid[] = $level;
            }
            return null;
        }

        if (!Kelas::where('kode_kelas', $row['kode_kelas'])->exists()) {
            $this->berhasil++;
            return new Kelas([
                'kode_kelas' => $row['kode_kelas'],
                'level' => $level,
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