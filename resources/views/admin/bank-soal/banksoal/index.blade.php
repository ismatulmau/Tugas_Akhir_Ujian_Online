@extends('layouts.app')

@section('page-header')
<div class="page-header">
  <h4 class="page-title">Bank Soal</h4>
  <ul class="breadcrumbs">
    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
    <li class="separator"><i class="icon-arrow-right"></i></li>
    <li class="nav-item"><a href="{{ route('bank-soal.index') }}">Daftar Bank Soal</a></li>
  </ul>
</div>
@endsection
@section('content')

@if(session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
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

@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Bank Soal</h4>
        <div class="d-flex gap-2">
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBankSoal">
            <i class="fa fa-plus"></i> Buat Bank Soal
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Bank Soal</th>
                <th>Mata Pelajaran</th>
                <th>Level</th>
                <th>Soal</th>
                <th>Upl Soal</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($banksoals as $index => $banksoal)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $banksoal->nama_bank_soal }}</td>
                <td>{{ $banksoal->mapel->nama_mapel ?? '-' }}</td>
                <td>
                  {{ $banksoal->level ?? '-' }}<br>
                  <small class="text-muted">{{ $banksoal->jurusan ?? '' }}</small>
                </td>
                <td>
                  <small>Opsi: {{ $banksoal->opsi_jawaban }}</small><br>
                  <small>Ditampilkan: {{ $banksoal->jml_soal }}</small><br>
                  <small>Diimpor: {{ $banksoal->soals->count() }}</small>
                </td>
                <td>
                  <button class="btn btn-sm btn-success d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalImportSoal{{ $banksoal->id_bank_soal }}">
                    <i class="fa fa-upload"></i> Import
                  </button>
                </td>

                <td>
                  <form action="{{ route('bank-soal.toggle-status', $banksoal->id_bank_soal) }}" method="POST" class="d-inline">
                    @csrf
                    @if($banksoal->status == 'aktif')
                    <button type="submit" class="btn btn-sm btn-outline-success w-100">
                      Aktif
                    </button>
                    @else
                    <button type="submit"
                      class="btn btn-sm w-100 {{ $banksoal->soals->count() == 0 ? 'btn-outline-secondary disabled' : 'btn-outline-dark' }}"
                      @if($banksoal->soals->count() == 0)
                      title="Bank soal harus memiliki minimal 1 soal untuk diaktifkan"
                      disabled
                      @endif>
                      Nonaktif
                    </button>
                    @endif
                  </form>
                </td>
                <td style="vertical-align: middle;">
                  <div class="d-flex gap-2 align-items-center" style="height: 100%;">
                    <a href="{{ route('soal.index', ['id_bank_soal' => $banksoal->id_bank_soal]) }}"
                      class="btn btn-sm btn-info p-2" title="Lihat Soal" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                      <i class="fa fa-eye fa-fw"></i>
                    </a>
                    <button class="btn btn-sm btn-warning p-2"
                      data-bs-toggle="modal"
                      data-bs-target="#modalEditBankSoal{{ $banksoal->id_bank_soal }}"
                      title="Edit"
                      style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                      <i class="fa fa-edit fa-fw"></i>
                    </button>
                    <form action="{{ route('bank-soal.destroy', $banksoal->id_bank_soal) }}"
                      method="POST"
                      style="display: inline-flex; margin: 0; padding: 0; align-items: center;">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="btn btn-sm btn-danger p-2"
                        title="Hapus"
                        onclick="return confirm('Yakin hapus bank soal ini?')"
                        style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-trash fa-fw"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              <!-- Modal Edit Bank Soal -->
              <div class="modal fade" id="modalEditBankSoal{{ $banksoal->id_bank_soal }}" tabindex="-1" aria-labelledby="modalEditBankSoalLabel{{ $banksoal->id_bank_soal }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <form action="{{ route('bank-soal.update', $banksoal->id_bank_soal) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalEditBankSoalLabel{{ $banksoal->id_bank_soal }}">Edit Bank Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-md-12">
                            <label for="nama_bank_soal" class="form-label">Nama Bank Soal</label>
                            <input type="text" class="form-control" name="nama_bank_soal" value="{{ $banksoal->nama_bank_soal }}" required>
                          </div>

                          <div class="col-md-6">
                            <label for="kode_mapel" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" name="kode_mapel" required>
                              @foreach($mapels as $mapel)
                              <option value="{{ $mapel->kode_mapel }}" {{ $banksoal->kode_mapel == $mapel->kode_mapel ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                              </option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select class="form-select" name="jurusan" required>
                              @foreach($jurusan as $jrs)
                              <option value="{{ $jrs->jurusan }}" {{ $banksoal->jurusan == $jrs->jurusan ? 'selected' : '' }}>
                                {{ $jrs->jurusan }}
                              </option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label for="level">Level Kelas</label>
                            <select class="form-control" name="level" id="level" required>
                              <option value="">-- Pilih Level --</option>
                              @foreach(['X', 'XI', 'XII'] as $level)
                              <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>
                                {{ $level }}
                              </option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label for="opsi_jawaban" class="form-label">Opsi Jawaban</label>
                            <select class="form-select" name="opsi_jawaban" required>
                              <option value="A-B-C-D" {{ $banksoal->opsi_jawaban == 'A-B-C-D' ? 'selected' : '' }}>A-B-C-D</option>
                              <option value="A-B-C-D-E" {{ $banksoal->opsi_jawaban == 'A-B-C-D-E' ? 'selected' : '' }}>A-B-C-D-E</option>
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label for="jml_soal" class="form-label">Jumlah Soal Ditampilkan</label>
                            <input type="number" class="form-control" name="jml_soal" value="{{ $banksoal->jml_soal }}" required min="1">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Modal Import Excel -->
              <div class="modal fade" id="modalImportSoal{{ $banksoal->id_bank_soal ?? '' }}" tabindex="-1" aria-labelledby="modalImportSoalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="{{ route('soal.import') }}" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="id_bank_soal" value="{{ $banksoal->id_bank_soal }}">
                      @csrf
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalImportSoalLabel">Import Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="file" class="form-label">Pilih File Excel</label>
                          <input type="file" class="form-control" name="file" id="file" required accept=".xlsx, .xls, .csv">
                          <small class="text-muted">Format file harus Excel (.xlsx, .xls) atau CSV</small>
                        </div>
                        <div class="alert alert-info">
                          <strong>Petunjuk:</strong>
                          <ul class="mb-0">
                            <li>Download template <a href="{{ route('soal.downloadTemplate') }}">disini</a></li>
                            <li>Isi data sesuai format</li>
                            <li>Format file excel TIDAK BOLEH dirubah</li>
                          </ul>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @endforeach
            </tbody>
          </table>
          <div class="mt-4 alert alert-warning" role="alert">
        <h6 class="fw-bold">Catatan Penting:</h6>
        <ul class="mb-0">
          <li>Tidak diperbolehkan mengaktifkan lebih dari satu bank soal untuk <strong>level</strong> dan <strong>jurusan</strong> yang sama secara bersamaan.</li>
          <li>Aktifkan Bank Soal ketika akan digunakan untuk ujian</li>
          <li>NonAktifkan Bank Soal ketika sudah selesai ujian</li>
        </ul>
      </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Bank Soal -->
<div class="modal fade" id="modalTambahBankSoal" tabindex="-1" aria-labelledby="modalTambahBankSoalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('bank-soal.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahBankSoalLabel">Buat Bank Soal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-12">
              <label for="nama_bank_soal" class="form-label">Nama Bank Soal</label>
              <input type="text" class="form-control" name="nama_bank_soal" required>
            </div>

            <div class="col-md-6">
              <label for="kode_mapel" class="form-label">Mata Pelajaran</label>
              <select class="form-select" name="kode_mapel" required>
                <option value="">-- Pilih Mapel --</option>
                @foreach($mapels as $mapel)
                <option value="{{ $mapel->kode_mapel }}">{{ $mapel->nama_mapel }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label for="jurusan" class="form-label">Jurusan</label>
              <select class="form-select" name="jurusan" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach($jurusan as $jrs)
                <option value="{{ $jrs->jurusan }}">{{ $jrs->jurusan }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label for="level" class="form-label">Level</label>
              <select class="form-select" name="level" required>
                <option value="">-- Pilih Level --</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="opsi_jawaban" class="form-label">Opsi Jawaban</label>
              <select class="form-select" name="opsi_jawaban" required>
                <option value="">-- Pilih Opsi Jawaban --</option>
                <option value="A-B-C-D">A-B-C-D</option>
                <option value="A-B-C-D-E">A-B-C-D-E</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="jml_soal" class="form-label">Jumlah Soal Ditampilkan</label>
              <input type="number" class="form-control" name="jml_soal" required min="1">
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

@endsection