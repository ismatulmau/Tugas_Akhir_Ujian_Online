@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Dashboard</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Dashboard</a></li>
    </ul>
</div>
@endsection

@section('content')

@php
    date_default_timezone_set('Asia/Jakarta');
    $jam = date('H');
    $sapaan = match(true) {
        $jam >= 5 && $jam < 12 => 'Selamat Pagi',
        $jam >= 12 && $jam < 15 => 'Selamat Siang',
        $jam >= 15 && $jam < 18 => 'Selamat Sore',
        default => 'Selamat Malam',
    };
@endphp

<!-- Salam & Logo Sekolah -->
<div class="row mb-0">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-semibold">{{ $sapaan }}, Admin</h4>
                    <p class="text-muted mb-0">Selamat datang di Panel Admin Sistem Ujian Online</p>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Informasi Sekolah - Versi Horizontal Modern -->
<div class="card shadow-sm mb-4">
    <div class="card-body py-4">
        <div class="row text-center align-items-center">
            <div class="col-6 col-md-3 border-end">
                <div class="mb-2">
                    <i class="fas fa-school fa-2x text-primary"></i>
                </div>
                <div class="text-muted small">Nama Sekolah</div>
                <div class="fw-bold fs-5">{{ $dataSekolah->nama_sekolah ?? '-' }}</div>
            </div>
            <div class="col-6 col-md-3 border-end">
                <div class="mb-2">
                    <i class="fas fa-map-marker-alt fa-2x text-success"></i>
                </div>
                <div class="text-muted small">Alamat</div>
                <div class="fw-bold fs-5">{{ $dataSekolah->alamat ?? '-' }}</div>
            </div>
            <div class="col-6 col-md-3 border-end mt-4 mt-md-0">
                <div class="mb-2">
                    <i class="fas fa-user-tie fa-2x text-warning"></i>
                </div>
                <div class="text-muted small">Kepala Sekolah</div>
                <div class="fw-bold fs-5">{{ $dataSekolah->nama_kepala_sekolah ?? '-' }}</div>
            </div>
            <div class="col-6 col-md-3 mt-4 mt-md-0">
                <div class="mb-2">
                    <i class="fas fa-calendar-alt fa-2x text-info"></i>
                </div>
                <div class="text-muted small">Tahun Ajaran</div>
                <div class="fw-bold fs-5">{{ $dataSekolah->tahun_pelajaran ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>


<!-- Statistik Sistem -->
<div class="row g-3 mb-4">
    @php
        $cards = [
            [
                'title' => 'Master Data',
                'value' => "$jumlahKelas Kelas • $jumlahMapel Mapel • $jumlahSiswa Siswa",
                'icon' => 'fas fa-layer-group',
                'color' => 'primary',
            ],
            [
                'title' => 'Bank Soal',
                'value' => "$jumlahBankSoal Bank Soal",
                'icon' => 'fas fa-th-list',
                'color' => 'success',
            ],
            [
                'title' => 'Jadwal Ujian',
                'value' => "$jumlahUjian Jadwal Ujian",
                'icon' => 'fas fa-calendar-check',
                'color' => 'warning',
            ],
            [
                'title' => 'Rekap Nilai',
                'value' => "$jumlahRekapNilai Rekap",
                'icon' => 'fas fa-chart-bar',
                'color' => 'info',
            ],
        ];
    @endphp

    @foreach ($cards as $card)
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm rounded-lg border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-{{ $card['color'] }} text-white rounded me-3">
                        <i class="{{ $card['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="text-muted small">{{ $card['title'] }}</div>
                        <div class="fw-bold fs-5 text-dark">{{ $card['value'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


<!-- Tambahan CSS -->
<style>
    .icon-box {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    border-radius: 0.5rem;
}

    .card-statistic:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-icon-container {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hover-shadow-lg:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .transition-all {
        transition: all 0.3s ease;
    }
</style>

@endsection