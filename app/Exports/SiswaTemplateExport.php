<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class SiswaTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithColumnWidths
{
    public function array(): array
    {
        return []; // Mengembalikan array kosong untuk template
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa', 
            'Nomor Ujian', 
            'Level', 
            'Jurusan',
            'Kode Kelas', 
            'Nomor Induk', 
            'Gambar', 
            'Password', 
            'Jenis Kelamin', 
            'Sesi Ujian', 
            'Ruang Ujian', 
            'Agama'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestColumn = 'M'; // Kolom terakhir (M sesuai dengan jumlah kolom)

        // Styling untuk header
        $sheet->getStyle('A1:'.$highestColumn.'1')->applyFromArray([
            'font' => [
                'bold' => true, 
                'color' => ['rgb' => 'FFFFFF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'], // Warna biru
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ],
            ],
        ]);

        // Set tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 30,  // Nama Siswa (diperkecil dari 50)
            'C' => 15,  // Nomor Ujian
            'D' => 10,  // Level
            'E' => 15, // Jurusan
            'F' => 15, // Kode Kelas
            'G' => 15, // Nomor Induk
            'H' => 15,  // Gambar
            'I' => 15,  // Password
            'J' => 15,  // Jenis Kelamin
            'K' => 15,  // Sesi Ujian
            'L' => 15,  // Ruang Ujian
            'M' => 15   // Agama
        ];
    }
}