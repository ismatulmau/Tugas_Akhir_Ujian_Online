<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingUjian;
use App\Models\Jawaban;

class UjianController extends Controller
{
public function mulaiUjian($id_sett_ujian)
{
    $id_siswa = auth()->guard('siswa')->user()->id_siswa;

    // ✅ Jika tidak ada session verifikasi, redirect ke halaman data peserta dengan error
    if (session('ujian_terverifikasi') != $id_sett_ujian) {
        return redirect()->route('siswa.data-peserta')
            ->with('error', 'Masukkan token terlebih dahulu untuk mengakses ujian.');
    }

    // ✅ Cek apakah siswa sudah mengerjakan
    $sudahMengerjakan = \App\Models\Jawaban::where('id_sett_ujian', $id_sett_ujian)
        ->where('id_siswa', $id_siswa)
        ->exists();

    if ($sudahMengerjakan) {
        return redirect()->route('siswa.data-peserta')
            ->with('error', 'Anda sudah mengerjakan ujian ini sebelumnya.');
    }

    $ujian = SettingUjian::with(['bankSoal.soals'])->findOrFail($id_sett_ujian);
    $soals = $ujian->bankSoal->soals ?? collect();

    // ✅ Hapus session agar tidak bisa diakses ulang langsung
    session()->forget('ujian_terverifikasi');

    return view('siswa.mulai-ujian', compact('ujian', 'soals'));
}




public function submitUjian(Request $request, $id_sett_ujian)
{
    $jawabanSiswa = $request->input('jawaban', []);

    foreach ($jawabanSiswa as $id_soal => $jawaban) {
        Jawaban::create([
            'id_sett_ujian' => $id_sett_ujian,
            'id_siswa' => auth()->guard('siswa')->user()->id_siswa,
            'id_soal' => $id_soal,
            'jawaban' => $jawaban,
        ]);
    }

    return redirect()->route('siswa.konfirmasi-ujian');
}



}
