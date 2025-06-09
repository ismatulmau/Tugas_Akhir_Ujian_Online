@extends('layouts.app-siswa')

@section('title', 'Konfirmasi Data Ujian')

@section('content')

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="text-center mb-4">
                <i class="fas fa-clipboard-list fa-3x text-primary mb-2"></i>
                <h4 class="fw-bold">Detail Ujian</h4>
                <p class="text-muted">Silakan periksa data ujian sebelum mulai mengerjakan.</p>
            </div>

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body px-4 py-4">
                    <h5 class="text-center mb-4 border-bottom pb-3">Konfirmasi Data Ujian</h5>

                    <form action="{{ route('ujian.mulai', $ujian->id_sett_ujian) }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bank Soal</label>
                                <input type="text" class="form-control bg-light" value="{{ $ujian->bankSoal->nama_bank_soal ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mata Pelajaran</label>
                                <input type="text" class="form-control bg-light" value="{{ $ujian->bankSoal->mapel->nama_mapel ?? '-' }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Tes</label>
                                <input type="text" class="form-control bg-light" value="{{ $ujian->jenis_tes }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sesi</label>
                                <input type="text" class="form-control bg-light" value="{{ $ujian->sesi }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Waktu Mulai</label>
                                <input type="text" class="form-control bg-light" value="{{ \Carbon\Carbon::parse($ujian->waktu_mulai)->translatedFormat('d F Y, H:i') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Waktu Selesai</label>
                                <input type="text" class="form-control bg-light" value="{{ \Carbon\Carbon::parse($ujian->waktu_selesai)->translatedFormat('d F Y, H:i') }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Durasi</label>
                                <input type="text" class="form-control bg-light" value="{{ $ujian->durasi }} menit" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Token</label>
                                <input type="text" class="form-control bg-light-subtle py-2 px-3 rounded-2 border-0 text-primary fw-bold" value="{{ $ujian->token }}" readonly>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success fw-semibold">
                                <i class="fas fa-play me-1"></i> Mulai Mengerjakan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
