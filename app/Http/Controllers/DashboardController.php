<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\BankSoal;
use App\Models\SettingUjian;
use App\Models\RekapNilai;
use Illuminate\Http\Request;
use App\Models\Jawaban;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahKelas = Kelas::count();
        $jumlahMapel = Mapel::count();
        $jumlahSiswa = Siswa::count();
        $jumlahBankSoal = BankSoal::count();
        $jumlahUjian = SettingUjian::count();
        $jumlahRekapNilai = Jawaban::distinct('id_sett_ujian')->count('id_sett_ujian');
       

        return view('admin.dashboard', compact(
            'jumlahKelas',
            'jumlahMapel',
            'jumlahSiswa',
            'jumlahBankSoal',
            'jumlahUjian',
            'jumlahRekapNilai'
            
        ));
    }
}
