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
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                @php
                date_default_timezone_set('Asia/Jakarta');
                $jam = date('H');
                if ($jam >= 5 && $jam < 12) {
                    $sapaan='Selamat Pagi' ;
                    } elseif ($jam>= 12 && $jam < 15) {
                        $sapaan='Selamat Siang' ;
                        } elseif ($jam>= 15 && $jam < 18) {
                            $sapaan='Selamat Sore' ;
                            } else {
                            $sapaan='Selamat Malam' ;
                            }
                            @endphp

                            <h3 class="mb-2 fw-bold">{{ $sapaan }}, Admin!</h3>
                            <p class="text-muted">Gunakan panel ini untuk mengelola data dan informasi penting dengan mudah dan efisien.</p>
            </div>
        </div>
    </div>

    <!-- Kartu Ringkasan -->
    @php
    $cards = [
    [
    'title' => 'Master Data',
    'desc' => 'Kelola daftar kelas, mata pelajaran, dan siswa.',
    'icon' => 'fas fa-layer-group text-primary',
    'value' => "$jumlahKelas Kelas • $jumlahMapel Mapel • $jumlahSiswa Siswa"
    ],
    [
    'title' => 'Bank Soal',
    'desc' => 'Manajemen bank soal dan soal ujian.',
    'icon' => 'fas fa-th-list text-success',
    'value' => "$jumlahBankSoal Bank Soal"
    ],
    [
    'title' => 'Status Ujian',
    'desc' => 'Atur dan jadwalkan ujian yang akan dilaksanakan.',
    'icon' => 'fas fa-pen-square text-warning',
    'value' => "$jumlahUjian Jadwal Ujian"
    ],
    [
    'title' => 'Rekap Nilai',
    'desc' => 'Lihat dan rekap hasil nilai ujian siswa.',
    'icon' => 'fas fa-table text-danger',
    'value' => "$jumlahRekapNilai Rekap Nilai"
    ],
    ];
    @endphp

    @foreach ($cards as $card)
    <div class="col-md-6 mb-4">
        <div class="card card-stats card-round shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center">
                            <i class="{{ $card['icon'] }}"></i>
                        </div>
                    </div>
                    <div class="col ps-3">
                        <div class="numbers">
                            <h4 class="card-title fw-semibold">{{ $card['title'] }}</h4>
                            <p class="text-muted mb-1">{{ $card['desc'] }}</p>
                            <h5 class="fw-bold text-dark mb-0">{{ $card['value'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection