<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankSoal;
use App\Models\Kelas;
use App\Models\Mapel;

class BankSoalController extends Controller
{
    public function index()
    {
        $banksoals = BankSoal::all();
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $jurusan = Kelas::select('jurusan')->distinct()->orderBy('jurusan')->get();
        return view('admin.bank-soal.banksoal.index', compact('banksoals', 'kelas', 'jurusan', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank_soal' => 'required|max:50',
            'kode_kelas' => 'required|string',
            'level' => 'required|in:X,XI,XII', // Validasi level
            'kode_mapel' => 'required|exists:mapels,kode_mapel',
            'jurusan' => 'required|string|max:50',
            'opsi_jawaban' => 'required|string',
            'jml_soal' => 'required|string',
        ],  [
            'nama_bank_soal.required' => 'Nama bank soal harus diisi',
            'nama_bank_soal.max' => 'Nama bank soal maksimal 50 karakter',
            'kode_kelas.required' => 'Kelas harus diisi',
            'level.required' => 'Level harus diisi',
            'level.in' => 'Level harus salah satu dari: X, XI, atau XII',
            'kode_mapel.required' => 'Kode mapel harus diisi',
            'kode_mapel.exists' => 'Kode mapel tidak ditemukan',
            'jurusan.required' => 'Jurusan harus diisi',
            'jurusan.max' => 'Jurusan maksimal 50 karakter',
            'opsi_jawaban.required' => 'Opsi jawaban harus diisi',
            'jml_soal.required' => 'Jumlah soal harus diisi',
        ]);


        // Cek apakah sudah ada bank soal dengan level dan jurusan yang sama
        $cekDuplikat = BankSoal::where('nama_bank_soal', $request->nama_bank_soal)
            ->where('kode_kelas', $request->kode_kelas)
            ->where('level', $request->level)
            ->where('jurusan', $request->jurusan)
            ->exists();

        if ($cekDuplikat) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['duplicate' => 'Bank soal untuk level ' . $request->level .  $request->kode_kelas. ' dan jurusan ' . $request->jurusan . ' sudah ada.']);
        }

        BankSoal::create([
            'nama_bank_soal' => $request->nama_bank_soal,
            'kode_kelas' => $request->kode_kelas,
            'level' => $request->level,
            'kode_mapel' => $request->kode_mapel,
            'jurusan' => $request->jurusan,
            'opsi_jawaban' => $request->opsi_jawaban,
            'jml_soal' => $request->jml_soal,
        ]);

        return redirect()->route('bank-soal.index')->with('success', 'Data bank soal berhasil disimpan.');
    }

    public function edit($id_bank_soal)
    {
        $banksoal = BankSoal::findOrFail($id_bank_soal);
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        return view('admin.bank-soal.banksoal.edit_banksoal', compact('banksoal', 'kelas', 'mapels'));
    }

    public function update(Request $request, $id_bank_soal)
    {
        $request->validate([
            'nama_bank_soal' => 'required|max:50',
            'kode_kelas' => 'required|string',
            'level' => 'required|in:X,XI,XII',
            'kode_mapel' => 'required|exists:mapels,kode_mapel',
            'jurusan' => 'required|string|max:50',
            'opsi_jawaban' => 'required|string',
            'jml_soal' => 'required|string',
        ],  [
            'nama_bank_soal.required' => 'Nama bank soal harus diisi',
            'nama_bank_soal.max' => 'Nama bank soal maksimal 50 karakter',
            'kode_kelas.required' => 'Kelas harus diisi',
            'level.required' => 'Level harus diisi',
            'level.in' => 'Level harus salah satu dari: X, XI, atau XII',
            'kode_mapel.required' => 'Kode mapel harus diisi',
            'kode_mapel.exists' => 'Kode mapel tidak ditemukan',
            'jurusan.required' => 'Jurusan harus diisi',
            'jurusan.max' => 'Jurusan maksimal 50 karakter',
            'opsi_jawaban.required' => 'Opsi jawaban harus diisi',
            'jml_soal.required' => 'Jumlah soal harus diisi',
        ]);

        $banksoal = BankSoal::findOrFail($id_bank_soal);

        // Cek duplikat dengan mengabaikan data yang sedang diupdate
        $cekDuplikat = BankSoal::where('nama_bank_soal', $request->nama_bank_soal)
            ->where('kode_kelas', $request->kode_kelas)
            ->where('level', $request->level)
            ->where('jurusan', $request->jurusan)
            ->where('id_bank_soal', '!=', $id_bank_soal) // abaikan data saat ini
            ->exists();

        if ($cekDuplikat) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['duplicate' => 'Bank soal untuk level ' . $request->level . ', Kelas ' . $request->kode_kelas. ' dan jurusan ' . $request->jurusan . ' sudah ada']);
        }

        $banksoal->update([
            'nama_bank_soal' => $request->nama_bank_soal,
            'kode_kelas' => $request->kode_kelas,
            'level' => $request->level,
            'kode_mapel' => $request->kode_mapel,
            'jurusan' => $request->jurusan,
            'opsi_jawaban' => $request->opsi_jawaban,
            'jml_soal' => $request->jml_soal,
        ]);

        return redirect()->route('bank-soal.index')->with('success', 'Data bank soal berhasil diperbarui.');
    }

    public function destroy($id_bank_soal)
    {
        $banksoal = BankSoal::findOrFail($id_bank_soal);
        $banksoal->delete();

        return redirect()->route('bank-soal.index')->with('success', 'Data bank soal berhasil dihapus.');
    }

public function toggleStatus($id_bank_soal)
{
    $banksoal = BankSoal::withCount('soals')->with('settingUjian')->findOrFail($id_bank_soal);

    // Jika akan mengaktifkan
    if ($banksoal->status !== 'aktif') {
        // Cek apakah ada bank soal lain yang aktif dengan level dan jurusan yang sama
        $sudahAktif = BankSoal::where('level', $banksoal->level)
            ->where('jurusan', $banksoal->jurusan)
            ->where('kode_kelas', $banksoal->kode_kelas)
            ->where('status', 'aktif')
            ->where('id_bank_soal', '!=', $id_bank_soal)
            ->exists();

        if ($sudahAktif) {
            return back()->with('error', 'Bank soal untuk level ' . $banksoal->level . ', Kelas' . $banksoal->kode_kelas.  ' dan jurusan ' . $banksoal->jurusan . ' sudah ada yang aktif.');
        }

        // Cek apakah memiliki soal
        if ($banksoal->soals_count == 0) {
            return back()->with('error', 'Bank soal harus memiliki minimal 1 soal untuk diaktifkan');
        }

        // Aktifkan
        $banksoal->status = 'aktif';
        $banksoal->save();

        return back()->with('success', 'Bank soal berhasil diaktifkan.');
    } else {
    // Nonaktifkan bank soal
    $banksoal->status = 'nonaktif';
    $banksoal->save();

    // Ubah status setting ujian terkait menjadi nonaktif
    if ($banksoal->settingUjian) {
    $banksoal->settingUjian->status = 'nonaktif'; // ubah status setting jadi nonaktif
    $banksoal->settingUjian->save();
}

    return back()->with('success', 'Bank soal dinonaktifkan .');
}
}



}
