<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingUjian;
use App\Models\Jawaban;

class UjianController extends Controller
{
    public function mulaiUjian($id_sett_ujian)
{
    $siswa = auth()->guard('siswa')->user();

    if (session('ujian_terverifikasi') != $id_sett_ujian) {
        return redirect()->route('siswa.data-peserta')
            ->with('error', 'Masukkan token terlebih dahulu untuk mengakses ujian.');
    }

    $ujian = SettingUjian::with(['bankSoal'])->findOrFail($id_sett_ujian);

    if (
    $ujian->bankSoal->jurusan !== $siswa->jurusan ||
    $ujian->bankSoal->level !== $siswa->level ||
    ($ujian->bankSoal->kode_kelas !== 'ALL' && $ujian->bankSoal->kode_kelas !== $siswa->kode_kelas)
) {
    return redirect()->route('siswa.data-peserta')
        ->with('error', 'Ujian ini tidak sesuai dengan jurusan, kelas atau tingkat Anda.');
}


    if ($ujian->status !== 'aktif' || $ujian->bankSoal->status !== 'aktif') {
        return redirect()->route('siswa.data-peserta')
            ->with('error', 'Ujian ini sudah tidak tersedia atau sudah dinonaktifkan.');
    }

    $sudahMengerjakan = \App\Models\Jawaban::where('id_sett_ujian', $id_sett_ujian)
        ->where('id_siswa', $siswa->id_siswa)
        ->exists();

    if ($sudahMengerjakan) {
        return redirect()->route('siswa.data-peserta')
            ->with('error', 'Anda sudah mengerjakan ujian ini sebelumnya.');
    }

    $jmlSoal = $ujian->bankSoal->jml_soal;
    $sessionKey = 'soal_ujian_' . $siswa->id_siswa . '_' . $id_sett_ujian;

    if (session()->has($sessionKey)) {
        $soalIds = session($sessionKey);
        $soals = \App\Models\Soal::whereIn('id_soal', $soalIds)->get()->sortBy(function ($soal) use ($soalIds) {
            return array_search($soal->id_soal, $soalIds);
        });
    } else {
        $soals = $ujian->bankSoal->soals()->inRandomOrder()->limit($jmlSoal)->get();
        $soalIds = $soals->pluck('id_soal')->toArray();
        session([$sessionKey => $soalIds]);
    }

    return view('siswa.mulai-ujian', compact('ujian', 'soals'));
}




    public function submitUjian(Request $request, $id_sett_ujian)
    {
        $id_siswa = auth()->guard('siswa')->user()->id_siswa;
        $jawabanSiswa = $request->input('jawaban', []);

        foreach ($jawabanSiswa as $id_soal => $jawaban) {
            Jawaban::create([
                'id_sett_ujian' => $id_sett_ujian,
                'id_siswa' => $id_siswa,
                'id_soal' => $id_soal,
                'jawaban' => $jawaban,
            ]);
        }

        // Ambil setting ujian dan relasi bank soal untuk ambil jml_soal
        $settingUjian = \App\Models\SettingUjian::with('bankSoal')->findOrFail($id_sett_ujian);

        // Hitung jumlah jawaban benar
        $jawaban = Jawaban::where('id_sett_ujian', $id_sett_ujian)
            ->where('id_siswa', $id_siswa)
            ->with('soal')
            ->get();

        $jumlahBenar = $jawaban->filter(function ($j) {
            return $j->jawaban === optional($j->soal)->jawaban_benar;
        })->count();

        // Ambil total soal dari jml_soal di bank_soals
        $totalSoal = $settingUjian->bankSoal->jml_soal ?? 0;

        $score = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100, 2) : 0;

        // Simpan data di session untuk ditampilkan di halaman konfirmasi
        session()->put('hasil_ujian', [
            'jumlah_benar' => $jumlahBenar,
            'total_soal' => $totalSoal,
            'score' => $score
        ]);

        // Hapus session verifikasi agar tidak bisa akses ulang
        session()->forget('ujian_terverifikasi');

        return redirect()->route('siswa.konfirmasi-ujian');
    }
}
