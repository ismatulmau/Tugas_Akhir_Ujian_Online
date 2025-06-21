<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public $berhasil = 0;
    public $duplikat = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (
                Siswa::where('nomor_ujian', $row['nomor_ujian'])->exists() ||
                Siswa::where('nomor_induk', $row['nomor_induk'])->exists()
            ) {
                $this->duplikat++;
                continue; // lewati baris duplikat
            }

            Siswa::create([
                'nama_siswa'     => $row['nama_siswa'],
                'nomor_ujian'    => $row['nomor_ujian'],
                'level'          => $row['level'],
                'jurusan'        => $row['jurusan'],
                'kode_kelas'     => $row['kode_kelas'],
                'nomor_induk'    => $row['nomor_induk'],
                'gambar'         => $row['gambar'] ?? null,
                'jenis_kelamin'  => $row['jenis_kelamin'],
                'sesi_ujian'     => $row['sesi_ujian'],
                'ruang_ujian'    => $row['ruang_ujian'],
                'agama'          => $row['agama'],
                'password'       => Hash::make($row['password']),
                'password_asli'  => $row['password'],
            ]);

            $this->berhasil++;
        }
    }
}
