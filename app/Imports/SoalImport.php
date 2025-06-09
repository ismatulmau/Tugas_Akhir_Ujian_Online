<?php

namespace App\Imports;

use App\Models\Soal;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalImport implements ToModel, WithHeadingRow
{
    protected $idBankSoal;

    public function __construct($idBankSoal)
    {
        $this->idBankSoal = $idBankSoal;
    }

    public function model(array $row)
    {
        return new Soal([
            'id_bank_soal' => $this->idBankSoal,
            'pertanyaan' => $row['pertanyaan'],
            'gambar_soal' => $row['gambar_soal'] ?? null,
            'opsi_a' => $row['opsi_a'],
            'opsi_b' => $row['opsi_b'],
            'opsi_c' => $row['opsi_c'],
            'opsi_d' => $row['opsi_d'],
            'opsi_e' => $row['opsi_e'],
            'jawaban_benar' => strtoupper($row['jawaban_benar']),
        ]);
    }
}

