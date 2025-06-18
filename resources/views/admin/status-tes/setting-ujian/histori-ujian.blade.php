@extends('layouts.app')

@section('title', 'Histori Ujian')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>Ujian Telah Berlangsung</h4>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Bank Soal</th>
          <th>Mata Pelajaran</th>
          <th>Level</th>
          <th>Waktu Mulai</th>
          <th>Waktu Selesai</th>
          <th>Durasi</th>
          <th>Sesi</th>
          <th>Token</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($jadwals as $i => $jadwal)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $jadwal->bankSoal->nama_bank_soal ?? '-' }}</td>
          <td>{{ $jadwal->bankSoal->mapel->nama_mapel ?? '-' }}</td>
          <td>{{ $jadwal->bankSoal->level ?? '-' }} <br>
            <small class="text-muted">{{ $jadwal->banksoal->jurusan ?? '' }}</small>
          </td>
          <td>{{ $jadwal->waktu_mulai }}</td>
          <td>{{ $jadwal->waktu_selesai }}</td>
          <td>{{ $jadwal->durasi }} menit</td>
          <td>{{ $jadwal->sesi }}</td>
          <td>{{ $jadwal->token }}</td>
          <td><span class="badge bg-secondary">Nonaktif</span></td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center">Tidak ada histori ujian</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection