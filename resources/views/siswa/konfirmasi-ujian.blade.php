@extends('layouts.app-siswa')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 text-center">
                        <i class="fas fa-check-circle me-2"></i>Konfirmasi Penyelesaian Ujian
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3.5rem;"></i>
                    </div>

                    <h4 class="text-center text-dark mb-3">Ujian Telah Diselesaikan</h4>

                    <p class="text-muted text-center mb-4">
                        Terima kasih telah menyelesaikan ujian. Jawaban Anda telah tersimpan.
                    </p>
                    
                    @if(session('hasil_ujian'))
                    <div class="alert alert-light border mt-3 p-3">
                        <h6 class="fw-bold text-center mb-2">Hasil Ujian:</h6>
                        <div class="d-flex justify-content-between">
                            <span>Jumlah Benar:</span>
                            <span class="fw-bold">{{ session('hasil_ujian.jumlah_benar') }}/{{ session('hasil_ujian.total_soal') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Skor:</span>
                            <span class="fw-bold">{{ session('hasil_ujian.score') }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-sign-out-alt me-1"></i> Keluar dari Sistem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 8px;
    }
    .alert {
        border-radius: 6px;
        background-color: #f8fafc;
    }
</style>
@endpush