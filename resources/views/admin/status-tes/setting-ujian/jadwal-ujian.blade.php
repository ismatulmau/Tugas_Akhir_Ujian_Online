@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Status Ujian</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('jadwal.ujian') }}">Jadwal Ujian</a></li>
    </ul>
</div>
@endsection

@section('content')

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">Ujian Berlangsung</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bank Soal</th>
                        <th>Mata Pelajaran</th>
                        <th>Jenis Tes</th>
                        <th>Level</th>
                        <th>Semester</th>
                        <th>Sesi</th>
                        <th>Pengawas</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Durasi</th>
                        <th>Token</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwals as $index => $jadwal)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jadwal->bankSoal->nama_bank_soal ?? '-' }}</td>
                        <td>{{ $jadwal->bankSoal->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ ucfirst($jadwal->jenis_tes) }}</td>
                        <td>{{ $jadwal->bankSoal->level }} <br>
                            <small class="text-muted">{{ $jadwal->bankSoal->jurusan ?? '' }}</small>
                        </td>
                        <td>{{ $jadwal->semester }}</td>
                        <td>{{ $jadwal->sesi }}</td>
                        <td>{{ $jadwal->nama_pengawas }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('d M Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('d M Y H:i') }}</td>
                        <td>{{ $jadwal->durasi }} menit</td>
                        <td><span class="badge bg-primary">{{ $jadwal->token }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">Belum ada jadwal ujian yang disetting.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection