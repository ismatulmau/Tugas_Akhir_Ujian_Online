<?php

namespace App\Http\Controllers;

use App\Models\SettingUjian;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\DataSekolah;

class SettingUjianController extends Controller
{
    public function index()
{
    $dataSekolah = DataSekolah::first();
    $banksoals = BankSoal::with(['mapel', 'soals', 'settingUjian' => function ($query) {
        $query->where('status', 'aktif');
    }])
    ->where('status', 'aktif') // hanya bank soal aktif
    ->get();

    return view('admin.status-tes.setting-ujian.index', compact('banksoals', 'dataSekolah'));
}


public function store(Request $request)
{
    // Validasi input tanpa token karena akan dibuat otomatis
    $request->validate([
        'id_bank_soal'   => 'required|exists:bank_soals,id_bank_soal',
        'jenis_tes'      => 'required|string',
        'semester'       => 'required|integer',
        'sesi'           => 'required|string',
        'waktu_mulai'    => 'required|date',
        'waktu_selesai'  => 'required|date|after:waktu_mulai',
    ], [
        'required' => 'Kolom :attribute wajib diisi.',
        'after'    => 'Waktu selesai harus setelah waktu mulai.',
    ]);

    // Hitung durasi dalam menit
    $durasi = (strtotime($request->waktu_selesai) - strtotime($request->waktu_mulai)) / 60;

    // Fungsi untuk generate token unik
    $token = $this->generateUniqueToken();

    try {
        // Simpan data ke database
        SettingUjian::create([
            'id_bank_soal'   => $request->id_bank_soal,
            'jenis_tes'      => $request->jenis_tes,
            'semester'       => $request->semester,
            'sesi'           => $request->sesi,
            'waktu_mulai'    => $request->waktu_mulai,
            'waktu_selesai'  => $request->waktu_selesai,
            'durasi'         => $durasi,
            'token'          => $token,
        ]);

        return redirect()->back()->with('success', 'Ujian berhasil disetting dengan token: ' . $token);
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Gagal menyimpan setting ujian: ' . $e->getMessage()]);
    }
}

// Fungsi untuk generate token unik 6 karakter (bisa kamu modifikasi sesuai format)
private function generateUniqueToken($length = 6)
{
    do {
        $token = strtoupper(Str::random($length)); // contoh hasil: AB12CD
    } while (SettingUjian::where('token', $token)->exists());

    return $token;
}

    public function update(Request $request, $id_sett_ujian)
    {

        $request->validate([
            'jenis_tes' => 'required|string',
            'semester' => 'required|integer',
            'sesi' => 'required|string',
            'token' => 'required|string|unique:setting_ujians,token,' . $id_sett_ujian . ',id_sett_ujian',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ], [
            'token.unique' => 'Token sudah digunakan, silakan gunakan token lain.',
            'required' => 'Kolom :attribute wajib diisi.',
            'after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        $setting = SettingUjian::findOrFail($id_sett_ujian);

        $durasi = (strtotime($request->waktu_selesai) - strtotime($request->waktu_mulai)) / 60;

        $setting->update([
            'jenis_tes' => $request->jenis_tes,
            'semester' => $request->semester,
            'sesi' => $request->sesi,
            'token' => $request->token,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'durasi' => $durasi,
        ]);

        return redirect()->back()->with('success', 'Setting ujian berhasil diperbarui.');
    }


    public function jadwalUjian()
{
    $jadwals = SettingUjian::with(['bankSoal.mapel'])
        ->where('status', 'aktif') // hanya tampilkan setting ujian yang aktif
        ->whereHas('bankSoal', function ($query) {
            $query->where('status', 'aktif'); // dan bank soal juga harus aktif
        })
        ->latest()
        ->get();

    return view('admin.status-tes.setting-ujian.jadwal-ujian', compact('jadwals'));
}


//     public function historiUjian()
// {
//     $jadwals = SettingUjian::with(['bankSoal.mapel'])
//         ->where('status', 'nonaktif')
//         ->latest()
//         ->get();

//     return view('admin.status-tes.setting-ujian.histori-ujian', compact('jadwals'));
// }

}
