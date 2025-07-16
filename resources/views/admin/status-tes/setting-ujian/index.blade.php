@extends('layouts.app')

@section('page-header')
<div class="page-header">
  <h4 class="page-title">Status Ujian</h4>
  <ul class="breadcrumbs">
    <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
    <li class="separator"><i class="icon-arrow-right"></i></li>
    <li class="nav-item"><a href="{{ route('setting-ujian.index') }}">Setting Ujian</a></li>
  </ul>
</div>
@endsection

@php use Illuminate\Support\Str; @endphp

@section('content')

@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning">
  {{ session('warning') }}
</div>
@endif

<div class="card mt-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-0">Setting Ujian</h4>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Bank Soal</th>
            <th>Mata Pelajaran</th>
            <th>Level</th>
            <th>Soal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Durasi</th>
            <th>Sesi</th>
            <th>Tes</th>
            <th>Token</th>
            <th>Status</th>
            <th>Jadwal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($banksoals as $index => $banksoal)
          @php $setting = $banksoal->settingUjian; @endphp
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $banksoal->nama_bank_soal }}</td>
            <td>{{ $banksoal->mapel->nama_mapel ?? '-' }}</td>
            <td>
              {{ $banksoal->level ?? '-' }} - {{ $banksoal->kode_kelas == 'ALL' ? 'ALL' : ($banksoal->kelas->kode_kelas ?? '-') }} <br>
              <small class="text-muted">{{ $banksoal->jurusan ?? '' }}</small>
            </td>
            <td>
              <small>{{ $banksoal->opsi_jawaban }}</small><br>
              <small>Soal: {{ $banksoal->soals->count() }}</small>
            </td>
            <td>{{ $setting?->waktu_mulai ?? '-' }}</td>
            <td>{{ $setting?->waktu_selesai ?? '-' }}</td>
            <td>{{ $setting?->durasi ? $setting->durasi . ' menit' : '-' }}</td>
            <td>{{ $setting?->sesi ?? '-' }}</td>
            <td>{{ $setting?->jenis_tes ?? '-' }}</td>
            <td><span class="badge bg-primary">{{ $setting?->token ?? '-' }}</span></td>

            {{-- Status --}}
            <td>
              @if($setting)
    @if($setting->status === 'aktif')
        <button type="button" class="btn btn-sm btn-outline-success w-100" disabled>
            Aktif
        </button>
    @else
        <button type="button" class="btn btn-sm btn-outline-secondary w-100" disabled>
            Nonaktif
        </button>
    @endif
@else
    <span class="badge bg-danger">Belum disetting</span>
@endif

            </td>
            {{-- Tombol Setting --}}
            <td>
              @if(!$setting)
              {{-- Tombol Tambah Setting Ujian --}}
              <button
                class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalSettingUjian{{ $banksoal->id_bank_soal }}"
                title="Pengaturan Ujian">
                <i class="fa fa-cog"></i>
              </button>
              @else
              {{-- Tombol Edit Setting Ujian --}}
              <button
                class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#modalEditSettingUjian{{ $banksoal->id_bank_soal }}"
                title="Edit Pengaturan Ujian">
                <i class="fa fa-edit"></i>
              </button>
              @endif
            </td>

          </tr>
          @if($setting)
          <!-- Modal Edit Setting Ujian -->
          <div class="modal fade" id="modalEditSettingUjian{{ $banksoal->id_bank_soal }}" tabindex="-1" aria-labelledby="modalEditSettingLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <form action="{{ route('setting-ujian.update', $setting->id_sett_ujian) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Setting Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Jenis Tes</label>
                        <select name="jenis_tes" class="form-select" required>
                          <option value="UTS" {{ $setting->jenis_tes == 'UTS' ? 'selected' : '' }}>UTS</option>
                          <option value="UAS" {{ $setting->jenis_tes == 'UAS' ? 'selected' : '' }}>UAS</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-select" required>
                          <option value="1" {{ $setting->semester == 1 ? 'selected' : '' }}>Semester 1</option>
                          <option value="2" {{ $setting->semester == 2 ? 'selected' : '' }}>Semester 2</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Sesi Ujian</label>
                        <input type="text" name="sesi" class="form-control" value="{{ $setting->sesi }}" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Token Ujian</label>
                        <input type="text" name="token" class="form-control" value="{{ $setting->token }}" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" name="waktu_mulai" class="form-control" value="{{ \Carbon\Carbon::parse($setting->waktu_mulai)->format('Y-m-d\TH:i') }}" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Waktu Selesai</label>
                        <input type="datetime-local" name="waktu_selesai" class="form-control" value="{{ \Carbon\Carbon::parse($setting->waktu_selesai)->format('Y-m-d\TH:i') }}" required>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          @endif
          @endforeach
        </tbody>

      </table>
      {{-- Catatan Penting --}}
      <div class="mt-4 alert alert-warning" role="alert">
        <h6 class="fw-bold">Catatan Penting:</h6>
        <ul class="mb-0">
          <li>Jika ingin berganti <strong>Sesi Ujian</strong>, silahkan <strong>nonAktifkan</strong> terlebih dahulu Bank Soal, kemudian <strong>Aktifkan</strong> kembali dan atur ulang jadwalnya.</li>
          <li>Beberapa ujian (untuk level dan jurusan berbeda) bisa diatur dalam waktu bersamaan.</li>
          <li>Apabila satu level memiliki beberapa ujian bersamaan (untuk level dan jurusan yang sama), maka peserta <strong>tidak dapat mengikuti ujian</strong> (*terlambat mengikuti ujian).</li>
          <li>Daftar di atas merupakan paket ujian yang telah <strong>diaktifkan oleh admin</strong>. Silakan melakukan pengaturan daftar ujian dengan mengklik tombol <strong>‘Pengaturan Ujian’</strong> pada kolom jadwal.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

{{-- Modal Ditaruh Di Luar Tabel --}}
@forelse($banksoals as $index => $banksoal)
<!-- Modal Setting Ujian -->
<div class="modal fade" id="modalSettingUjian{{ $banksoal->id_bank_soal }}" tabindex="-1" aria-labelledby="modalSettingLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('setting-ujian.store') }}" method="POST">
      @csrf
      <input type="hidden" name="id_bank_soal" value="{{ $banksoal->id_bank_soal }}">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Setting Ujian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Jenis Tes</label>
              <select name="jenis_tes" class="form-select" required>
                <option value="UTS">UTS</option>
                <option value="UAS">UAS</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Semester</label>
              <select name="semester" class="form-select" required>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Sesi Ujian</label>
              <input type="text" name="sesi" class="form-control" required placeholder="Contoh: Sesi 1">
            </div>
            <div class="col-md-6">
              <label class="form-label">Token Ujian</label>
              <input type="text" name="token" class="form-control" value="{{ strtoupper(Str::random(6)) }}" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Waktu Mulai</label>
              <input type="datetime-local" name="waktu_mulai" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Waktu Selesai</label>
              <input type="datetime-local" name="waktu_selesai" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer mt-3">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>



@endforeach

@endsection