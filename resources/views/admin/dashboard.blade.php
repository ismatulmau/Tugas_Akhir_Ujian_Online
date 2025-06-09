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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">Selamat Datang, Admin!</h3>
                <p>Selamat datang di panel admin! Gunakan panel ini untuk mengelola data dan informasi penting dengan mudah dan efisien.</p>
            </div>
        </div>
    </div>

    <!-- Deskripsi Menu -->
    <div class="col-md-12">
        <div class="row">

            <!-- Master Data -->
            <div class="col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center">
                                    <i class="fas fa-layer-group text-primary"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <h4 class="card-title">Master Data</h4>
                                    <p class="card-category">Kelola daftar kelas, mata pelajaran, dan siswa dengan mudah.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank Soal -->
            <div class="col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center">
                                    <i class="fas fa-th-list text-success"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <h4 class="card-title">Bank Soal</h4>
                                    <p class="card-category">Manajemen soal ujian dan file pendukung soal.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Ujian -->
            <div class="col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center">
                                    <i class="fas fa-pen-square text-warning"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <h4 class="card-title">Status Ujian</h4>
                                    <p class="card-category">Atur dan jadwalkan ujian yang akan dilaksanakan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekap Nilai -->
            <div class="col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center">
                                    <i class="fas fa-table text-danger"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <h4 class="card-title">Rekap Nilai</h4>
                                    <p class="card-category">Lihat dan rekap hasil nilai ujian siswa.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
