<?php

use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\SettingUjianController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\SoalController;


Route::get('/', function () {
    return redirect()->route('login');
});

// Route Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Admin 
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Daftar Kelas
    Route::get('/kelas/index', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{kode_kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{kode_kelas}/update', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kode_kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    Route::post('/kelas/import', [KelasController::class, 'import'])->name('kelas.import');

    //Daftar Siswa
    Route::get('/siswa/index', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id_siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id_siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id_siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak-kartu');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::post('/siswa/upload-gambar-massal', [SiswaController::class, 'uploadGambarMassal'])->name('siswa.uploadGambarMassal');

    //Daftar Mapel 
    Route::get('/mapel/index', [MataPelajaranController::class, 'index'])->name('mapel.index');
    Route::post('/mapel/store', [MataPelajaranController::class, 'store'])->name('mapel.store');
    Route::get('/mapel/{kode_mapel}/edit', [MataPelajaranController::class, 'edit'])->name('mapel.edit');
    Route::put('/mapel/{kode_mapel}', [MataPelajaranController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{kode_mapel}', [MataPelajaranController::class, 'destroy'])->name('mapel.destroy');
    Route::post('/mapel/import', [MataPelajaranController::class, 'import'])->name('mapel.import');

    // Setting Ujian
    Route::get('/setting-ujian/index', [SettingUjianController::class, 'index'])->name('setting-ujian.index');
    Route::post('/setting-ujian/store', [SettingUjianController::class, 'store'])->name('setting-ujian.store');
    Route::put('/setting-ujian/{id_sett_ujian}', [SettingUjianController::class, 'update'])->name('setting-ujian.update');



    // Jadwal Ujian
    Route::get('/jadwal-ujian', [SettingUjianController::class, 'jadwalUjian'])->name('jadwal.ujian');


    // Bank Soal
    Route::get('/bank-soal/index', [BankSoalController::class, 'index'])->name('bank-soal.index');
    Route::post('/bank-soal/store', [BankSoalController::class, 'store'])->name('bank-soal.store');
    Route::get('/bank-soal/{id_bank_soal}/edit', [BankSoalController::class, 'edit'])->name('bank-soal.edit');
    Route::put('/bank-soal/{id_bank_soal}', [BankSoalController::class, 'update'])->name('bank-soal.update');
    Route::delete('/bank-soal/{id_bank_soal}', [BankSoalController::class, 'destroy'])->name('bank-soal.destroy');
    Route::post('/bank-soal/{id_bank_soal}/toggle-status', [BankSoalController::class, 'toggleStatus'])->name('bank-soal.toggle-status');


    //soal
    Route::get('/soal/{id_bank_soal}', [SoalController::class, 'index'])->name('soal.index');
    Route::post('/soal/store', [SoalController::class, 'store'])->name('soal.store');
    Route::put('/soal/{id_soal}', [SoalController::class, 'update'])->name('soal.update');
    Route::delete('/soal/{id_soal}', [SoalController::class, 'destroy'])->name('soal.destroy');
    Route::post('/soal/import', [SoalController::class, 'import'])->name('soal.import');
    Route::post('/soal/upload-gambar-soal', [SoalController::class, 'uploadGambarSoal'])->name('soal.uploadGambarSoal');
    Route::delete('/soal/kosongkan/{id_bank_soal}', [SoalController::class, 'kosongkan'])->name('soal.kosongkan');
});

// Siswa 
Route::middleware('siswa')->group(function () {
    Route::get('/siswa/data-peserta', [SiswaController::class, 'dataPeserta'])->name('siswa.data-peserta');
    Route::post('/siswa/cari-ujian', [SiswaController::class, 'cariUjian'])->name('siswa.cari-ujian');

    Route::get('/ujian/{id_sett_ujian}/mulai', [UjianController::class, 'mulaiUjian'])->name('ujian.mulai');
    Route::post('/ujian/{id_sett_ujian}/submit', [UjianController::class, 'submitUjian'])->name('ujian.submit');


});

