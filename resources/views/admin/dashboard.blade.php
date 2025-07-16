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
$jam >= 5 && $jam < 12=> 'Selamat Pagi',
    $jam >= 12 && $jam < 15=> 'Selamat Siang',
        $jam >= 15 && $jam < 18=> 'Selamat Sore',
            default => 'Selamat Malam',
            };
            @endphp

            <!-- Header Dashboard -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card card-profile shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="fw-bold mb-1">{{ $sapaan }}, Admin</span>!</h2>
                                    <p class="text-muted mb-0">Selamat datang di Sistem Administrasi Sekolah</p>
                                </div>
                                <div class="avatar avatar-xl">
                                    <a href="#" class="logo">
                                        @if(!empty($dataSekolah->logo) && file_exists(public_path('storage/' . $dataSekolah->logo)))
                                        <img src="{{ asset('storage/' . $dataSekolah->logo) }}" alt="Logo Sekolah" class="navbar-brand" height="60">
                                        @else
                                        <img src="{{ asset('assets/img/default-logo.png') }}" alt="Default Logo" class="navbar-brand" height="60">
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Sekolah -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body py-3">
                            <div class="row g-4">
                                @php
                                $infoSekolah = [
                                [
                                'icon' => 'fas fa-school',
                                'color' => 'primary',
                                'label' => 'Nama Sekolah',
                                'value' => $dataSekolah->nama_sekolah ?? '-',
                                ],
                                [
                                'icon' => 'fas fa-map-marker-alt',
                                'color' => 'success',
                                'label' => 'Alamat',
                                'value' => $dataSekolah->alamat ?? '-',
                                ],
                                [
                                'icon' => 'fas fa-user-tie',
                                'color' => 'warning',
                                'label' => 'Kepala Sekolah',
                                'value' => $dataSekolah->nama_kepala_sekolah ?? '-',
                                ],
                                [
                                'icon' => 'fas fa-calendar-alt',
                                'color' => 'info',
                                'label' => 'Tahun Ajaran',
                                'value' => $dataSekolah->tahun_pelajaran ?? '-',
                                ],
                                ];
                                @endphp

                                @foreach ($infoSekolah as $info)
                                <div class="col-md-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 bg-light rounded border-start border-4 border-{{ $info['color'] }}">
                                        <div class="me-3">
                                            <i class="{{ $info['icon'] }} fa-lg text-{{ $info['color'] }}"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">{{ $info['label'] }}</div>
                                            <div class="fw-bold">{{ $info['value'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Statistik Utama -->
            <!-- Statistik Utama -->
            <div class="row mb-4">
                @php
                $cards = [
                [
                'title' => 'Master Data',
                'desc' => 'Kelola data kelas, mata pelajaran, dan siswa',
                'icon' => 'fas fa-layer-group',
                'value' => "$jumlahKelas Kelas • $jumlahMapel Mapel • $jumlahSiswa Siswa",
                'color' => 'primary',
                ],
                [
                'title' => 'Bank Soal',
                'desc' => 'Manajemen bank soal dan soal ujian',
                'icon' => 'fas fa-th-list',
                'value' => "$jumlahBankSoal Bank Soal",
                'color' => 'success',
                ],
                [
                'title' => 'Jadwal Ujian',
                'desc' => 'Atur jadwal ujian yang akan dilaksanakan',
                'icon' => 'fas fa-calendar-check',
                'value' => "$jumlahUjian Jadwal",
                'color' => 'warning',
                ],
                [
                'title' => 'Rekap Nilai',
                'desc' => 'Lihat hasil nilai ujian siswa',
                'icon' => 'fas fa-chart-bar',
                'value' => "$jumlahRekapNilai Rekap",
                'color' => 'info',
                ],
                ];
                @endphp

                @foreach ($cards as $card)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card card-statistic h-100 border-0 shadow-sm hover-shadow-lg transition-all">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon-container bg-soft-{{ $card['color'] }} me-3">
                                    <i class="{{ $card['icon'] }} text-{{ $card['color'] }}"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-dark mb-1">{{ $card['title'] }}</h6>
                                    <p class="text-muted small mb-2">{{ $card['desc'] }}</p>
                                    <h5 class="fw-bold text-{{ $card['color'] }} mb-0">{{ $card['value'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>




            <!-- Tambahkan CSS Kustom -->
            <style>
                .card-profile {
                    background: linear-gradient(135deg, #6777ef 0%, #80D0C7 100%);
                    color: white;
                    border-radius: 12px;
                }

                .card-statistic {
                    border-radius: 10px;
                    transition: all 0.3s ease;
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

                .avatar-img {
                    object-fit: cover;
                }

                .chart-container {
                    position: relative;
                    height: 250px;
                }

                .hover-shadow-lg:hover {
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                }

                .transition-all {
                    transition: all 0.3s ease;
                }
            </style>

            <!-- Tambahkan JavaScript untuk Chart -->
            @section('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Grafik Statistik Ujian
                    const ctx = document.getElementById('ujianChart').getContext('2d');
                    const ujianChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                            datasets: [{
                                label: 'Jumlah Ujian',
                                data: [12, 19, 3, 5, 2, 3],
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                });
            </script>
            @endsection
            @endsection