<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class JadwalUjianImport implements ToCollection
{
    public $jadwal = [];

    private function formatJam($value)
{
    if (is_numeric($value)) {
        // Konversi dari angka desimal (Excel Time)
        $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
        return $timestamp->format('H:i');
    }

    // Jika sudah string format "07:00", langsung return
    return $value;
}


    public function collection(Collection $rows)
{
    foreach ($rows->skip(1) as $row) {
        // Skip baris jika semua kolom kosong atau tidak lengkap
        if (
            empty($row[0]) &&
            empty($row[1]) &&
            empty($row[2]) &&
            empty($row[3]) &&
            empty($row[4])
        ) {
            continue;
        }

        // Format tanggal
        $tanggal = null;
        if (!empty($row[1])) {
            try {
                $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d');
            } catch (\Exception $e) {
                $tanggal = null;
            }
        }

        $this->jadwal[] = [
            'hari' => $row[0],
            'tanggal' => $tanggal,
            'jam_mulai' => $this->formatJam($row[2]),
            'jam_selesai' => $this->formatJam($row[3]),
            'mapel' => $row[4],
        ];
    }
}

}
