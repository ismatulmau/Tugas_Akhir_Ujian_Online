<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
                return new Siswa([
                    'nama_siswa' => $row['nama_siswa'],
                    'nomor_ujian' => $row['nomor_ujian'],
                    'level' => $row['level'],
                    'jurusan' => $row['jurusan'],
                    'kode_kelas' => $row['kode_kelas'],
                    'jenis_ujian' => $row['jenis_ujian'],
                    'nomor_induk' => $row['nomor_induk'],
                    'gambar' => $row['gambar'],
                    'password' => Hash::make($row['password']),
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'sesi_ujian' => $row['sesi_ujian'],
                    'ruang_ujian' => $row['ruang_ujian'],
                    'agama' => $row['agama'],
                    'password_asli' => $row['password'],
                ]);
            }
}


