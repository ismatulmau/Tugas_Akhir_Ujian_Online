@extends('layouts.app-siswa')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0 text-center">
                        <i class="fas fa-check-circle me-2"></i>Konfirmasi Penyelesaian Ujian
                    </h4>
                </div>

                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>

                    <h3 class="text-dark mb-4">Ujian Telah Diselesaikan</h3>

                    <p class="text-muted mb-4">
                        Terima kasih telah menyelesaikan ujian dengan baik. Jawaban Anda telah tersimpan secara otomatis.
                    </p>
                    @if(session('hasil_ujian'))
                    <div class="alert alert-info mt-4">
                        <h5>Hasil Ujian:</h5>
                        <p><strong>Jumlah Benar:</strong> {{ session('hasil_ujian.jumlah_benar') }} dari {{ session('hasil_ujian.total_soal') }} soal</p>
                        <p><strong>Skor:</strong> {{ session('hasil_ujian.score') }}</p>
                    </div>
                    @endif

                    <div class="d-grid gap-2 col-md-6 mx-auto mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Keluar dari Sistem
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <small class="text-muted">
                        Sistem Ujian Online &copy; {{ date('Y') }} - {{ config('app.name') }}
                    </small>
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
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        border-radius: 0 !important;
    }
</style>
@endpush