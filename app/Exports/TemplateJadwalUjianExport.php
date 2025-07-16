<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateJadwalUjianExport implements FromArray, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['Hari', 'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Mapel'], // header
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // Baris header
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D9EDF7'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}