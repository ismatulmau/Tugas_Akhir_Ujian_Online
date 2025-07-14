<?php

namespace App\Http\Controllers;

use App\Models\SettingUjian;
use App\Models\Jawaban;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapNilaiExport;

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

    public function hapusRekap($id_sett_ujian)
    {
        // Hapus semua jawaban untuk ujian tersebut
        Jawaban::where('id_sett_ujian', $id_sett_ujian)->delete();

        return redirect()->back()->with('success', 'Rekap nilai berhasil dihapus.');
    }
}
