<?php

namespace App\Http\Controllers;

use App\Models\SettingUjian;
use App\Models\Jawaban;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapNilaiExport;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapNilaiController extends Controller
{
    // Tampilkan daftar setting ujian yang sudah ada jawaban
    public function index()
    {
        $settings = SettingUjian::with(['bankSoal.mapel'])
            ->whereHas('jawaban') // hanya ujian yang sudah dikerjakan
            ->latest()
            ->get();

        return view('admin.rekap.index', compact('settings'));
    }

    // Export ke Excel berdasarkan id_sett_ujian
    public function exportExcel($id_sett_ujian)
    {
        // Ambil data setting ujian beserta relasi ke bank soal
        $setting = SettingUjian::with('bankSoal')->findOrFail($id_sett_ujian);

        $jenisTes = strtoupper(str_replace(' ', '_', $setting->jenis_tes));
        $namaBankSoal = strtoupper(str_replace(' ', '_', $setting->bankSoal->nama_bank_soal));
        $level = strtoupper(str_replace(' ', '_', $setting->bankSoal->level));
        $jurusan = strtoupper(str_replace(' ', '_', $setting->bankSoal->jurusan));

        $namaFile = "REKAP_NILAI_{$jenisTes}_{$namaBankSoal}_{$level}_{$jurusan}.xlsx";

        return Excel::download(new RekapNilaiExport($id_sett_ujian), $namaFile);
    }

    public function exportPdf($id_sett_ujian)
    {
        $setting = SettingUjian::with('bankSoal.mapel')->findOrFail($id_sett_ujian);

        $jawabanSiswa = Jawaban::where('id_sett_ujian', $id_sett_ujian)
            ->with(['siswa.kelas', 'soal'])
            ->get()
            ->groupBy('id_siswa');

        $rekap = [];

        foreach ($jawabanSiswa as $jawabanGroup) {
            $siswa = $jawabanGroup->first()->siswa;
            $jumlahBenar = $jawabanGroup->filter(function ($jawaban) {
                return $jawaban->jawaban === optional($jawaban->soal)->jawaban_benar;
            })->count();

            $jumlahDijawab = $jawabanGroup->count();
            $totalSoal = $setting->bankSoal->jml_soal ?? 0;
            $nilai = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100, 2) : 0;

            $rekap[] = [
                'nomor_ujian' => $siswa->nomor_ujian,
                'nama_siswa' => $siswa->nama_siswa,
                'kelas' => $siswa->kelas->nama_kelas ?? '-',
                'jurusan' => $siswa->kelas->jurusan ?? '-',
                'sesi' => $setting->sesi,
                'jml_soal' => $totalSoal,
                'terjawab' => $jumlahDijawab,
                'benar' => $jumlahBenar,
                'nilai' => $nilai,
            ];
        }

        $pdf = Pdf::loadView('admin.rekap.rekapPDF', compact('setting', 'rekap'))
            ->setPaper('A4', 'landscape');

        $jenisTes = strtoupper(str_replace(' ', '_', $setting->jenis_tes));
        $namaBankSoal = strtoupper(str_replace(' ', '_', $setting->bankSoal->nama_bank_soal));
        $level = strtoupper(str_replace(' ', '_', $setting->bankSoal->level));
        $jurusan = strtoupper(str_replace(' ', '_', $setting->bankSoal->jurusan));

        $namaFile = "REKAP_NILAI_{$jenisTes}_{$namaBankSoal}_{$level}_{$jurusan}.pdf";

        return $pdf->download($namaFile);
    }

    public function hapusRekap($id_sett_ujian)
    {
        // Hapus semua jawaban untuk ujian tersebut
        Jawaban::where('id_sett_ujian', $id_sett_ujian)->delete();

        return redirect()->back()->with('success', 'Rekap nilai berhasil dihapus.');
    }
}
