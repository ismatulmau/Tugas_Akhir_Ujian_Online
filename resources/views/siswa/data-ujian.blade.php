@extends('layouts.app-siswa')

@section('title', 'Konfirmasi Data Ujian')

@section('content')

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@php
use Carbon\Carbon;
$sekarang = Carbon::now();
$waktuMulai = Carbon::parse($ujian->waktu_mulai);
$waktuSelesai = Carbon::parse($ujian->waktu_selesai);
$bisaMulai = $sekarang->gte($waktuMulai);
$masihBisaUjian = $sekarang->lte($waktuSelesai);
@endphp

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="text-center mb-4">
                <i class="fas fa-clipboard-list fa-3x text-primary mb-2"></i>
                <h4 class="fw-bold">Detail Ujian</h4>
                <p class="text-muted">Silakan periksa data ujian sebelum mulai mengerjakan.</p>
            </div>

            <div class="row g-4">
                <!-- Detail Ujian -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h5 class="text-center mb-4 border-bottom pb-3">Konfirmasi Data Ujian</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Kode Ujian</label>
                                    <input type="text" class="form-control bg-light" value="{{ $ujian->bankSoal->nama_bank_soal ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mata Pelajaran</label>
                                    <input type="text" class="form-control bg-light" value="{{ $ujian->bankSoal->mapel->nama_mapel ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Kelas</label>
                                    <input type="text" class="form-control bg-light" value="{{ $ujian->bankSoal->level ?? '-' }} ({{ $ujian->bankSoal->jurusan ?? '-' }})" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jenis Tes</label>
                                    <input type="text" class="form-control bg-light" value="{{ $ujian->jenis_tes }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Waktu Mulai</label>
                                    <input type="text" class="form-control bg-light" value="{{ $waktuMulai->translatedFormat('d F Y, H:i') }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Waktu Selesai</label>
                                    <input type="text" class="form-control bg-light" value="{{ $waktuSelesai->translatedFormat('d F Y, H:i') }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Durasi</label>
                                    <input type="text" class="form-control bg-light" value="{{ $ujian->durasi }} menit" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Token</label>
                                    <input type="text" class="form-control bg-white border-1 text-primary fw-semibold" value="{{ $ujian->token }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi dan Tombol -->
                <div class="col-md-4 d-flex flex-column justify-content-start">
                    <div class="card border-0 shadow-sm mb-3 p-3 text-center">
                        <i class="fas fa-clock fa-2x text-secondary mb-2"></i>
                        <p class="mb-2">
                            <small>Waktu sekarang:</small><br>
                            <strong>{{ $sekarang->translatedFormat('d F Y, H:i') }}</strong>
                        </p>
                        @if(!$masihBisaUjian)
                            <span class="badge bg-danger">Waktu ujian telah berakhir</span>
                        @elseif($bisaMulai)
                            <span class="badge bg-success">Ujian sudah dimulai</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum dimulai</span>
                        @endif
                    </div>

                    <div class="alert alert-warning small text-center">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Tombol <strong>MULAI</strong> hanya aktif setelah waktu mulai ujian.
                        @if(!$masihBisaUjian)
                        <div class="alert alert-danger mt-3 small text-center">
                            <i class="fas fa-times-circle me-1"></i>
                            Ujian sudah berakhir, Anda tidak dapat mengerjakannya.
                        </div>
                        @endif
                    </div>

                    <form action="{{ route('ujian.mulai', $ujian->id_sett_ujian) }}" method="GET" class="mt-auto">
                        <button type="submit" class="btn btn-success fw-semibold w-100" {{ ($bisaMulai && $masihBisaUjian) ? '' : 'disabled' }}>
                            <i class="fas fa-play me-1"></i> Mulai Mengerjakan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
