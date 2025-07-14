<?php

namespace App\Http\Controllers;

use App\Imports\KelasImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KelasTemplateExport;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderByRaw("FIELD(level, 'X', 'XI', 'XII')")->get();
        return view('admin.masterdata.daftar-kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|unique:kelas,kode_kelas',
            'level' => 'required|in:X,XI,XII',
            'jurusan' => 'required|string',
            'nama_kelas' => 'required|string',

        ], [
            'kode_kelas.required' => 'Kode kelas harus diisi',
            'kode_kelas.unique' => 'Kode kelas sudah ada, gagal menambahkan data',
            'level.required' => 'Level harus diisi',
            'level.in' => 'Level harus salah satu dari: X, XI, atau XII',
            'jurusan.required' => 'Jurusan harus diisi',
            'nama_kelas.required' => 'Nama kelas harus diisi',

        ]);

        Kelas::create([
            'kode_kelas' => $request->kode_kelas,
            'level' => $request->level,
            'jurusan' => $request->jurusan,
            'nama_kelas' => $request->nama_kelas,

        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function edit($kode_kelas)
    {
        $kelas = Kelas::findOrFail($kode_kelas);
        return view('admin.masterdata.daftar-kelas.edit_kelas', compact('kelas'));
    }

    public function update(Request $request, $kode_kelas)
    {
        
        $request->validate([
            'kode_kelas' => 'required|unique:kelas,kode_kelas,'.$kode_kelas.',kode_kelas',
            'level' => 'required|in:X,XI,XII',
            'jurusan' => 'required|string|max:15',
            'nama_kelas' => 'required|string',
        ], [
            'kode_kelas.unique' => 'Kode kelas ini sudah digunakan',
            // Tambahkan pesan error lainnya sesuai kebutuhan
        ]);
    
        try {
            $kelas = Kelas::findOrFail($kode_kelas);
            $kelas->update([
                'kode_kelas' => $request->kode_kelas,
                'level' => $request->level,
                'jurusan' => $request->jurusan,
                'nama_kelas' => $request->nama_kelas,
            ]);
            
            return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: '.$e->getMessage());
        }
    }

    public function destroy($kode_kelas)
    {
        $kelas = Kelas::findOrFail($kode_kelas);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }

    public function downloadTemplate()
{
    return Excel::download(new KelasTemplateExport, 'Template_Import_Kelas.xlsx');
}

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        $import = new KelasImport();
        Excel::import($import, $request->file('file'));

        // ❗ Jika ada level tidak valid, lempar exception
        if (!empty($import->levelTidakValid)) {
            $invalidLevels = implode(', ', array_unique($import->levelTidakValid));
            return redirect()->back()->with('error', "Import gagal. Ditemukan level tidak valid: $invalidLevels. Hanya level X, XI, dan XII yang diperbolehkan.");
        }

        $total = $import->berhasil + $import->duplikat;
        $message = "Import selesai. Total data: $total. 
                    Berhasil: $import->berhasil. 
                    Duplikat: $import->duplikat.";

        return redirect()->back()->with('success', $message);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat impor: ' . $e->getMessage());
    }
}

}
