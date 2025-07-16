<?php

// App\Imports\MapelImport.php

namespace App\Imports;

use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use App\Models\Kelas;

class MapelImport implements ToModel, WithHeadingRow
{
    public $berhasil = 0;
    public $duplikat = 0;

    public function model(array $row)
    {
        try {
            if (!Mapel::where('kode_mapel', $row['kode_mapel'])->exists()) {
                $mapel = new Mapel([
                    'kode_mapel' => $row['kode_mapel'],
                    'nama_mapel' => $row['nama_mapel'],
                    'persen_uts' => $row['persen_uts'],
                    'persen_uas' => $row['persen_uas'],
                    'kkm'        => $row['kkm'],
                ]);
                $mapel->save();

                // Tambahkan relasi ke kelas jika ada
                if (!empty($row['kelas'])) {
                    $kodeKelasArray = array_map('trim', explode(',', $row['kelas']));

                    $kelasIds = Kelas::whereIn('kode_kelas', $kodeKelasArray)->pluck('kode_kelas')->toArray();

                    // Cek jika ada kode yang tidak ditemukan
                    $foundKelas = array_keys($kelasIds);
                    $notFoundKelas = array_diff($kodeKelasArray, $foundKelas);

                    if (!empty($notFoundKelas)) {
                        Log::warning('Kode kelas tidak ditemukan: ' . implode(', ', $notFoundKelas));
                    }

                    $mapel->kelas()->syncWithoutDetaching(array_values($kelasIds));

                }


                $this->berhasil++;
                return null; // karena sudah disimpan manual
            } else {
                $this->duplikat++;
            }
        } catch (\Exception $e) {
            Log::error('Import Mata Pelajaran error: ' . $e->getMessage());
        }

        return null;
    }
}
