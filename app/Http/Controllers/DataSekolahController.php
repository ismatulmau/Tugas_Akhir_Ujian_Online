<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSekolah;
use Illuminate\Support\Facades\Storage;

class DataSekolahController extends Controller
{
    public function index()
    {
        $data = DataSekolah::first();
        return view('admin.masterdata.data-sekolah.index', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required',
            'semester' => 'required',
            'tahun_pelajaran' => 'required',
            'nama_kepala_sekolah' => 'required',
            'nip_kepala_sekolah' => 'required',
        ]);

        $data = DataSekolah::first() ?? new DataSekolah();

        if ($request->hasFile('logo')) {
            if ($data->logo) Storage::delete('public/' . $data->logo);
            $data->logo = $request->file('logo')->store('logos', 'public');
        }

        $data->nama_sekolah = $request->nama_sekolah;
        $data->semester = $request->semester;
        $data->tahun_pelajaran = $request->tahun_pelajaran;
        $data->nama_kepala_sekolah = $request->nama_kepala_sekolah;
        $data->nip_kepala_sekolah = $request->nip_kepala_sekolah;
        $data->save();

        return back()->with('success', 'Data sekolah berhasil disimpan.');
    }
}
