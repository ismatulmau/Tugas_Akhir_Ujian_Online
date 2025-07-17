<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Kelas;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MapelImport;
use App\Exports\MapelTemplateExport;
use Illuminate\Support\Facades\DB;

class MataPelajaranController extends Controller
{
   public function index()
{
    $mapels = Mapel::with('kelas')->get(); // dengan relasi
    $kelas = Kelas::all(); 
    $jurusanList = Kelas::select('jurusan')->distinct()->pluck('jurusan');

    return view('admin.masterdata.mata-pelajaran.index', compact('mapels', 'kelas', 'jurusanList'));
}

   public function store(Request $request)
{
    $request->validate([
        'kode_mapel' => 'required|unique:mapels,kode_mapel',
        'nama_mapel' => 'required|string',
        'persen_uts' => 'required|string',
        'persen_uas' => 'required|string',
        'kkm' => 'required|string',
        'kelas' => 'required|array|min:1',
    ], [
        'kelas_id.required' => 'Pilih minimal satu kelas.',
        'kode_mapel.required' => 'Kode mapel harus diisi',
            'kode_mapel.unique' => 'Kode mapel sudah ada',
            'nama_mapel.required' => 'Nama mapel harus diisi',
            'persen_uts.required' => '% UTS harus diisi',
            'persen_uas.required' => '% UAS harus diisi',
            'kkm.required' => 'KKM harus diisi',
    ]);

    DB::transaction(function () use ($request) {
        $mapel = Mapel::create([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'persen_uts' => $request->persen_uts,
            'persen_uas' => $request->persen_uas,
            'kkm' => $request->kkm,
        ]);

        // Simpan ke tabel pivot kelas_mapel
        $mapel->kelas()->attach($request->kelas); // simpan ke tabel pivot
    });

    return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil ditambahkan');
}

    public function edit($kode_mapel)
    {
        $mapels = Mapel::findOrFail($kode_mapel);
        return view('admin.masterdata.mata-pelajaran.edit_mapel', compact('mapels'));
    }

    public function update(Request $request, $kode_mapel)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapels,kode_mapel,' . $kode_mapel . ',kode_mapel',
            'nama_mapel' => 'required|string',
            'persen_uts' => 'required|string',
            'persen_uas' => 'required|string',
            'kkm' => 'required|string',
        ]);

        $mapels = Mapel::findOrFail($kode_mapel);
        $mapels->update([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'persen_uts' => $request->persen_uts,
            'persen_uas' => $request->persen_uas,
            'kkm' => $request->kkm,
        ]);

        $mapels->kelas()->sync($request->kelas);

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil diperbarui.');
    }

   public function destroy($kode_mapel)
{
    $mapel = Mapel::findOrFail($kode_mapel);

    // Hapus relasi dari tabel pivot terlebih dahulu
    $mapel->kelas()->detach();

    // Kemudian hapus mapel
    $mapel->delete();

    return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil dihapus.');
}


    public function downloadTemplate()
{
    return Excel::download(new MapelTemplateExport, 'Template_Import_Mapel.xlsx');
}

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        $import = new MapelImport();
        Excel::import($import, $request->file('file'));

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
