<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingUjian;
use App\Models\Jawaban;

class UjianController extends Controller
{
    public function mulaiUjian($id_sett_ujian)
{
    $ujian = SettingUjian::with(['bankSoal.soals'])->findOrFail($id_sett_ujian);

    $soals = $ujian->bankSoal->soals ?? collect();

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

    return redirect()->route('siswa.data-peserta')->with('success', 'Jawaban berhasil dikumpulkan.');
}



}
