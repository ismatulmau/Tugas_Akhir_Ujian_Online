@extends('layouts.app-siswa')

@section('title', 'Konfirmasi Data Peserta')

@section('content')

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="text-center mb-4">
                <i class="fas fa-user-graduate fa-3x text-primary mb-2"></i>
                <h4 class="fw-bold">Sistem Ujian Online</h4>
                <p class="text-muted">Silakan periksa dan konfirmasi data peserta sebelum mengikuti ujian.</p>
            </div>

            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-body px-4 py-4">

                    <h5 class="text-center fw-bold mb-4 border-bottom pb-3">Konfirmasi Data Peserta</h5>

                    <form action="{{ route('siswa.data-ujian') }}" method="POST">
                        @csrf

                        <!-- Data Siswa -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor Ujian</label>
                            <input type="text" class="form-control bg-light" value="{{ $siswa->nomor_ujian }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Peserta</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $siswa->nama_siswa }} | {{ $siswa->kelas->nama_kelas ?? '-' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly>
                        </div>
                        @if($token_ujian)
                        <div class="alert alert-info">
                            <strong>Token Ujian Anda:</strong> {{ $token_ujian }}
                            <br><small>Silakan ketikkan ulang token ini untuk memulai ujian.</small>
                        </div>
                        @endif

                        <!-- Token -->
                        <div class="mb-4">
                            <label for="token" class="form-label fw-semibold">Token Ujian</label>

                            @if($token_ujian)
                            <input type="text" name="token" id="token" class="form-control"
                                placeholder="Masukkan token ujian (contoh: ABC123)" required>
                            @else
                            <div class="alert alert-warning small">
                                Token ujian belum tersedia. Silakan hubungi pengawas atau admin.
                            </div>
                            <input type="text" class="form-control" placeholder="Token belum tersedia" disabled>
                            @endif
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold" {{ !$token_ujian ? 'disabled' : '' }}>
                                <i class="fas fa-sign-in-alt me-2"></i>Submit
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection