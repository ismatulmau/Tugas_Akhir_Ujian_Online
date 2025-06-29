<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\SettingUjian;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\SiswaTemplateExport;

class SiswaController extends Controller
{
    public function index()
{
    $kelas = Kelas::all();
    $jurusan = Kelas::select('jurusan')->distinct()->orderBy('jurusan')->get();

    $siswas = Siswa::with(['kelas' => function($query) {
            $query->orderBy('nama_kelas');
        }])
        ->orderByRaw("FIELD(level, 'X', 'XI', 'XII')")
        ->orderBy('nama_siswa')
        ->get();

    return view('admin.masterdata.daftar-siswa.index', compact('siswas', 'kelas', 'jurusan'));
}


    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|max:50',
            'nomor_ujian' => 'required|string|max:255|unique:siswas',
            'level' => 'required|in:X,XI,XII',
            'jurusan' => 'required|string|max:50',
            'kode_kelas' => 'required|exists:kelas,kode_kelas',
            'nomor_induk' => 'required|string|unique:siswas',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_kelamin' => 'required|in:L,P',
            'password' => 'required|min:6|max:8',
            'sesi_ujian' => 'required|string',
            'ruang_ujian' => 'required|string',
            'agama' => 'required|string',
        ],  [
            'nama_siswa.required' => 'Nama siswa harus diisi',
            'nama_siswa.max' => 'Nama siswa maksimal 50 karakter',
            'nomor_ujian.required' => 'Nomor ujian harus diisi',
            'nomor_ujian.max' => 'Nomor ujian maksimal 255 karakter',
            'level.required' => 'Level harus diisi',
            'jurusan.required' => 'Jurusan harus diisi',
            'jurusan.max' => 'Jurusan maksimal 50 karakter',
            'kode_kelas.required' => 'Kode kelas harus diisi',
            'kode_kelas.exists' => 'Kode kelas tidak ditemukan',
            'nomor_induk.required' => 'Nomor induk harus diisi',
            'gambar.string' => 'gambar harus berupa teks (path)',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi',
            'password.required' => 'Password harus diisi',
            'password.max' => 'Password maksimal 8 karakter',
            'sesi_ujian.required' => 'Sesi ujian harus diisi',
            'ruang_ujian.required' => 'Ruang ujian harus diisi',
            'agama.required' => 'Agama harus diisi',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
    $file = $request->file('gambar');
    $namaAsli = $file->getClientOriginalName();
    $path = $file->storeAs('siswa_images', $namaAsli, 'public');
    $gambarPath = $path;
}

        Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'nomor_ujian' => $request->nomor_ujian,
            'level' => $request->level,
            'jurusan' => $request->jurusan,
            'kode_kelas' => $request->kode_kelas,
            'nomor_induk' => $request->nomor_induk,
            'gambar' => $gambarPath, // Gunakan variabel $gambarPath bukan $request->gambar
            'jenis_kelamin' => $request->jenis_kelamin,
            'password' => Hash::make($request->password),
            'sesi_ujian' => $request->sesi_ujian,
            'ruang_ujian' => $request->ruang_ujian,
            'agama' => $request->agama,
            'password_asli' => $request->password, // simpan password asli
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil disimpan.');
    }

    public function edit($id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        $kelas = Kelas::all();
        return view('admin.masterdata.daftar-siswa.edit_siswa', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);

        $request->validate([
            'nama_siswa' => 'required|max:50',
            'nomor_ujian' => 'required|string|max:255|unique:siswas,nomor_ujian,' . $id_siswa . ',id_siswa',
            'level' => 'required|in:X,XI,XII',
            'jurusan' => 'required|string|max:15',
            'kode_kelas' => 'required|exists:kelas,kode_kelas',
            'nomor_induk' => 'required|string|unique:siswas,nomor_induk,' . $id_siswa . ',id_siswa',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_kelamin' => 'required|in:L,P',
            'password' => 'nullable|min:6|max:8',
            'sesi_ujian' => 'required|string',
            'ruang_ujian' => 'required|string',
            'agama' => 'required|string',
        ]);

        $data = [
            'nama_siswa' => $request->nama_siswa,
            'nomor_ujian' => $request->nomor_ujian,
            'level' => $request->level,
            'jurusan' => $request->jurusan,
            'kode_kelas' => $request->kode_kelas,
            'nomor_induk' => $request->nomor_induk,
            'jenis_kelamin' => $request->jenis_kelamin,
            'sesi_ujian' => $request->sesi_ujian,
            'ruang_ujian' => $request->ruang_ujian,
            'agama' => $request->agama,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password_asli'] = $request->password;
        }

        if ($request->hasFile('gambar')) {
    // Hapus gambar lama
    if ($siswa->gambar && Storage::disk('public')->exists($siswa->gambar)) {
        Storage::disk('public')->delete($siswa->gambar);
    }

    // Simpan gambar baru
    $file = $request->file('gambar');
    $namaAsli = $file->getClientOriginalName();
    $path = $file->storeAs('siswa_images', $namaAsli, 'public');
    $data['gambar'] = $path;
}

        $siswa->update($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }


    public function destroy($id_siswa)
{
    $siswa = Siswa::findOrFail($id_siswa);
    
    // Hapus gambar dari storage jika ada
    if ($siswa->gambar) {
        $gambarPath = public_path('storage/' . $siswa->gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }
    }
    
    $siswa->delete();

    return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
}

    public function downloadTemplate()
{
    return Excel::download(new SiswaTemplateExport, 'Template_Import_Siswa.xlsx');
}

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        $import = new SiswaImport();
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

    //upload foto siswa
    public function uploadGambarMassal(Request $request)
    {
        $request->validate([
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $files = $request->file('gambar');
        $berhasil = 0;
        $gagal = [];

        foreach ($files as $file) {
            $namaFile = $file->getClientOriginalName(); // contoh: isma.jpeg

            // Pencocokan dengan kolom 'gambar' di database
            $siswa = Siswa::where('gambar', $namaFile)->first();

            if ($siswa) {
                $file->move(public_path('storage/siswa_images'), $namaFile);

                // Perbarui path gambar jika belum lengkap
                $siswa->gambar = 'siswa_images/' . $namaFile;
                $siswa->save();

                $berhasil++;
            } else {
                $gagal[] = $namaFile;
            }
        }

        if (count($gagal)) {
            return back()->with('warning', "Sebagian berhasil ($berhasil foto). Gagal menyimpan: " . implode(', ', $gagal));
        }

        return back()->with('success', "Semua gambar berhasil diupload dan disimpan ke database ($berhasil foto).");
    }

public function cetakKartu(Request $request)
{
    $request->validate([
        'jurusan' => 'required',
        'nama_kelas' => 'required',
        'jenis_ujian' => 'required',
        'tahun_pelajaran' => 'required|string',
        'nama_kepala' => 'required|string',
        'nip_kepala' => 'required|string',
        'jadwal' => 'array',
        'jadwal.*.hari' => 'nullable|string',
        'jadwal.*.tanggal' => 'nullable|date',
        'jadwal.*.jam' => 'nullable|string',
        'jadwal.*.mapel' => 'nullable|string',
    ]);

    $query = Siswa::query();

    if ($request->jurusan !== 'all') {
        $query->where('jurusan', $request->jurusan);
    }

    if ($request->nama_kelas !== 'all') {
    $query->where('kode_kelas', function ($sub) use ($request) {
        $sub->select('kode_kelas')->from('kelas')->where('nama_kelas', $request->nama_kelas);
    });
}

    $siswas = $query->get();

    if ($siswas->isEmpty()) {
        return back()->with('error', 'Tidak ada data siswa untuk kriteria tersebut');
    }

   $jadwalUjian = collect($request->jadwal)
    ->filter(fn($item) => !empty($item['hari']) || !empty($item['tanggal']) || !empty($item['jam']) || !empty($item['mapel']))
    ->groupBy(function ($item) {
        $hari = $item['hari'] ?? '-';
        $tanggal = $item['tanggal'] ?? '-';
        return $hari . '|' . $tanggal;
    });


    $pdf = Pdf::loadView('siswa.cetak-kartu', [
        'siswas' => $siswas,
        'jenis_ujian' => $request->jenis_ujian,
        'tahun_pelajaran' => $request->tahun_pelajaran,
        'nama_kepala' => $request->nama_kepala,
        'nip_kepala' => $request->nip_kepala,
        'jadwalUjian' => $jadwalUjian,
    ]);

    return $pdf->stream('kartu-ujian-' . now()->format('Ymd') . '.pdf');
}

    public function dataPeserta()
{
    $siswa = Auth::guard('siswa')->user();

    // Muat relasi kelas (pastikan model Siswa memiliki relasi `kelas()`)
    $siswa->load('kelas');

    return view('siswa.data-peserta', compact('siswa'));
}

public function dataUjian(Request $request)
{
    $request->validate([
        'token' => 'required',
    ]);

    $token = $request->token;

    $ujian = SettingUjian::with('bankSoal')->where('token', $token)->first();

    if (!$ujian) {
        return redirect()->back()->with('error', 'Token tidak valid!');
    }

    $id_siswa = Auth::guard('siswa')->user()->id_siswa;

    // Jika belum mengerjakan, tampilkan view data ujian
   session(['ujian_terverifikasi' => $ujian->id_sett_ujian]);
return view('siswa.data-ujian', compact('ujian'));
}
}
