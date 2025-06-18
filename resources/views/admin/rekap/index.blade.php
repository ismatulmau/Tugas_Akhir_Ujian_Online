@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Rekap Nilai</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Rekap Nilai</a></li>
    </ul>
</div>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Rekap Nilai</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bank Soal</th>
                        <th>Mata Pelajaran</th>
                        <th>Level</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Durasi (menit)</th>
                        <th>Sesi</th>
                        <th>Tes</th>
                        <th>Token</th>
                        <th>Rekap</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($settings as $i => $setting)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $setting->bankSoal->nama_bank_soal ?? '-' }}</td>
                        <td>{{ $setting->bankSoal->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $setting->bankSoal->level ?? '-' }}<br><small class="text-muted">{{ $setting->bankSoal->jurusan ?? '-' }}</small></td>
                        <td>{{ $setting->waktu_mulai }}</td>
                        <td>{{ $setting->waktu_selesai }}</td>
                        <td>{{ $setting->durasi }}</td>
                        <td>{{ $setting->sesi }}</td>
                        <td>{{ $setting->jenis_tes }}</td>
                        <td>{{ $setting->token }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <!-- Tombol Export -->
                                <a href="{{ route('rekap.nilai.export', $setting->id_sett_ujian) }}" class="btn btn-success btn-sm" title="Export Excel">
                                    <i class="fa fa-file-excel"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('rekap.nilai.hapus', $setting->id_sett_ujian) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Rekap" onclick="return confirm('Yakin ingin menghapus semua rekap nilai untuk ujian ini?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection