<?php

namespace App\Exports;

use App\Models\Jawaban;
use App\Models\Soal;
use App\Models\SettingUjian;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapNilaiExport implements FromArray, WithEvents
{
    protected $id_sett_ujian;
    protected $setting;

    public function __construct($id_sett_ujian)
    {
        $this->id_sett_ujian = $id_sett_ujian;
    }

    public function array(): array
    {
        $this->setting = SettingUjian::with('bankSoal.mapel')->findOrFail($this->id_sett_ujian);
        $s = $this->setting;
        $mapel = $s->bankSoal->mapel->nama_mapel ?? '-';

        $info = [
            ['REKAP NILAI UJIAN'],
            [''],
            ['Nama Bank Soal', ': ' . $s->bankSoal->nama_bank_soal, 'Mata Pelajaran', ': ' . $mapel],
            ['Level', ': ' . $s->bankSoal->level . ' - ' . $s->bankSoal->jurusan, 'Jenis Tes', ': ' . $s->jenis_tes],
            ['Waktu Mulai', ': ' . $s->waktu_mulai, 'Waktu Selesai', ': ' . $s->waktu_selesai],
            ['Durasi', ': ' . $s->durasi . ' menit', 'Sesi', ': ' . $s->sesi],
            ['Token', ': ' . $s->token],
            [''],
            // Header (satu baris saja sekarang)
            ['No', 'No. Ujian', 'Nama Siswa', 'Kelas', 'Jurusan', 'Sesi', 'Jumlah Soal', 'Terjawab', 'Jawaban Benar', 'Total Nilai'],
        ];

        $rekap = [];
        $jawabanSiswa = Jawaban::where('id_sett_ujian', $this->id_sett_ujian)
            ->with(['siswa.kelas', 'soal'])
            ->get()
            ->groupBy('id_siswa');

        $i = 1;
        foreach ($jawabanSiswa as $jawabanGroup) {
            $siswa = $jawabanGroup->first()->siswa;
            $jumlahBenar = $jawabanGroup->filter(function ($jawaban) {
                return $jawaban->jawaban === optional($jawaban->soal)->jawaban_benar;
            })->count();

            $jumlahDijawab = $jawabanGroup->count();
            $totalSoal = $s->bankSoal->jml_soal ?? 0;
            $nilai = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100, 2) : 0;

            $rekap[] = [
                $i++,
                $siswa->nomor_ujian,
                $siswa->nama_siswa,
                $siswa->kelas->nama_kelas ?? '-',
                $siswa->kelas->jurusan ?? '-',
                $s->sesi,
                $totalSoal,
                $jumlahDijawab,
                $jumlahBenar,
                $nilai,
            ];
        }

        return array_merge($info, $rekap);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge judul
                $sheet->mergeCells('A1:J1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Merge header karena tidak ada sub header sekarang
                $sheet->getStyle('A9:J9')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => '0000FF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Border seluruh isi tabel
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A9:J{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Auto-size semua kolom A sampai J
                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}

