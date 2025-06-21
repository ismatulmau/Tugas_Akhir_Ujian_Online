<?php

namespace App\Http\Controllers;

use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Models\BankSoal;
use App\Models\Soal;
use App\Exports\SoalTemplateExport;

use Illuminate\Http\Request;

class SoalController extends Controller
{

    public function index($id_bank_soal)
    {
        $banksoal = BankSoal::with('mapel')->findOrFail($id_bank_soal);
        $soals = Soal::where('id_bank_soal', $id_bank_soal)->get();

        return view('admin.bank-soal.soal.index', compact('banksoal', 'soals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bank_soal' => 'required|exists:bank_soals,id_bank_soal',
            'pertanyaan' => 'required|string',
            'gambar_soal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'opsi_e' => 'nullable|string',
            'jawaban_benar' => 'required|in:A,B,C,D,E',
        ], [
            'id_bank_soal.required' => 'Bank soal wajib dipilih.',
            'id_bank_soal.exists' => 'Bank soal tidak valid.',
            'pertanyaan.required' => 'Pertanyaan tidak boleh kosong.',
            'gambar_soal.image' => 'File harus berupa gambar.',
            'gambar_soal.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'gambar_soal.max' => 'Ukuran gambar maksimal 2MB.',
            'opsi_a.required' => 'Opsi A wajib diisi.',
            'opsi_b.required' => 'Opsi B wajib diisi.',
            'opsi_c.required' => 'Opsi C wajib diisi.',
            'opsi_d.required' => 'Opsi D wajib diisi.',
            'jawaban_benar.required' => 'Jawaban benar wajib dipilih.',
            'jawaban_benar.in' => 'Jawaban benar harus salah satu dari A, B, C, D, atau E.',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar_soal')) {
            $file = $request->file('gambar_soal');
            $namaAsli = $file->getClientOriginalName();
            $file->move(public_path('storage/soal_images'), $namaAsli);
            $gambarPath = 'soal_images/' . $namaAsli;
        }

        Soal::create([
            'id_bank_soal' => $request->id_bank_soal,
            'pertanyaan' => $request->pertanyaan,
            'gambar_soal' => $gambarPath,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'opsi_e' => $request->opsi_e,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }
    public function update(Request $request, $id_soal)
    {
        $soal = Soal::findOrFail($id_soal);

        $request->validate([
            'pertanyaan' => 'required|string',
            'gambar_soal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'opsi_e' => 'nullable|string',
            'jawaban_benar' => 'required|in:A,B,C,D,E',
        ], [
            'pertanyaan.required' => 'Pertanyaan tidak boleh kosong.',
            'gambar_soal.image' => 'File harus berupa gambar.',
            'gambar_soal.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'gambar_soal.max' => 'Ukuran gambar maksimal 2MB.',
            'opsi_a.required' => 'Opsi A wajib diisi.',
            'opsi_b.required' => 'Opsi B wajib diisi.',
            'opsi_c.required' => 'Opsi C wajib diisi.',
            'opsi_d.required' => 'Opsi D wajib diisi.',
            'jawaban_benar.required' => 'Jawaban benar wajib dipilih.',
            'jawaban_benar.in' => 'Jawaban benar harus salah satu dari A, B, C, D, atau E.',
        ]);

        if ($request->hasFile('gambar_soal')) {
            // Hapus gambar lama
            if ($soal->gambar_soal && Storage::disk('public')->exists($soal->gambar_soal)) {
                Storage::disk('public')->delete($soal->gambar_soal);
            }
            $file = $request->file('gambar_soal');
            $namaAsli = $file->getClientOriginalName();
            $file->move(public_path('storage/soal_images'), $namaAsli);
            $soal->gambar_soal = 'soal_images/' . $namaAsli;
        }

        $soal->update([
            'pertanyaan' => $request->pertanyaan,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'opsi_e' => $request->opsi_e,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil diperbarui.');
    }
    public function destroy($id_soal)
    {
        $soal = Soal::findOrFail($id_soal);
        $bankSoal = $soal->banksoal;

        // Hapus gambar jika ada
        if ($soal->gambar_soal && Storage::disk('public')->exists($soal->gambar_soal)) {
    Storage::disk('public')->delete($soal->gambar_soal);
}

        $soal->delete();

        // Cek apakah jumlah soal sekarang 0
        if ($bankSoal->soals()->count() == 0) {
            $bankSoal->status = 'nonaktif';
            $bankSoal->save();
        }

        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new SoalTemplateExport, 'Template_Import_Soal.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Dapatkan id_bank_soal dari URL atau request hidden input (sesuaikan jika perlu)
        $idBankSoal = $request->input('id_bank_soal');

        // Import file
        Excel::import(new SoalImport($idBankSoal), $request->file('file'));

        return back()->with('success', 'Soal berhasil diimport.');
    }

    public function uploadGambarSoal(Request $request)
    {
        $request->validate([
            'gambar_soal.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $files = $request->file('gambar_soal');
        $berhasil = 0;
        $gagal = [];

        foreach ($files as $file) {
            $namaFile = $file->getClientOriginalName();

            // Validasi format gambar selain dari aturan Laravel
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $ext = strtolower($file->getClientOriginalExtension());
            if (!in_array($ext, $allowedExtensions)) {
                $gagal[] = "$namaFile (format tidak didukung)";
                continue;
            }

            // Pencocokan dengan kolom 'gambar_soal' di database
            $soal = Soal::where('gambar_soal', $namaFile)->first();

            if ($soal) {
                $file->move(public_path('storage/soal_images'), $namaFile);
                $soal->gambar_soal = 'soal_images/' . $namaFile;
                $soal->save();
                $berhasil++;
            } else {
                $gagal[] = "$namaFile (Nama atau format gambar tidak sesuai dengan nama gambar yang di import)";
            }
        }

        if (count($gagal)) {
            return back()->with('warning', "Sebagian berhasil ($berhasil foto). Gagal menyimpan: " . implode(', ', $gagal));
        }

        return back()->with('success', "Semua gambar berhasil diupload dan disimpan ke database ($berhasil foto).");
    }

    public function kosongkan($id_bank_soal)
    {
        // Ambil semua soal berdasarkan id_bank_soal
        $soals = Soal::where('id_bank_soal', $id_bank_soal)->get();

        // Hapus file gambar jika ada
        foreach ($soals as $soal) {
            if ($soal->gambar_soal && Storage::disk('public')->exists($soal->gambar_soal)) {
    Storage::disk('public')->delete($soal->gambar_soal);
}
        }

        // Hapus semua soal
        Soal::where('id_bank_soal', $id_bank_soal)->delete();

        return redirect()->back()->with('success', 'Semua soal berhasil dihapus.');
    }
}
