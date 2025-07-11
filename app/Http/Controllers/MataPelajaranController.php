<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MapelImport;
use App\Exports\MapelTemplateExport;

class MataPelajaranController extends Controller
{
    public function index()
    { 
        $mapels = Mapel::all();
        return view('admin.masterdata.mata-pelajaran.index', compact('mapels')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapels,kode_mapel',
            'nama_mapel' => 'required|string',
            'persen_uts' => 'required|string',
            'persen_uas' => 'required|string',
            'kkm' => 'required|string',

        ], [
            'kode_mapel.required' => 'Kode mapel harus diisi',
            'kode_mapel.unique' => 'Kode mapel sudah ada',
            'nama_mapel.required' => 'Nama mapel harus diisi',
            'persen_uts.required' => '% UTS harus diisi',
            'persen_uas.required' => '% UAS harus diisi',
            'kkm.required' => 'KKM harus diisi',
            

        ]);

        Mapel::create([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'persen_uts' => $request->persen_uts,
            'persen_uas' => $request->persen_uas,
            'kkm' => $request->kkm,

        ]);

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

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil diperbarui.');
    }

    public function destroy($kode_mapel)
    {
        $mapels = Mapel::findOrFail($kode_mapel);
        $mapels->delete();

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
