@extends('layouts.app')

@section('page-header')
<div class="page-header">
  <h4 class="page-title">Daftar Kelas</h4>
  <ul class="breadcrumbs">
    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
    <li class="separator"><i class="icon-arrow-right"></i></li>
    <li class="nav-item"><a href="{{ route('kelas.index') }}">Daftar Kelas</a></li>
  </ul>
</div>
@endsection

@section('content')

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

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Kelas</h4>
        <div class="d-flex gap-2">
          <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportKelas">
            <i class="fas fa-file-import"></i> Import Excel
          </button>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
            <i class="fa fa-plus"></i> Tambah Kelas
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Kelas</th>
                <th>Level</th>
                <th>Jurusan</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($kelas as $index => $kls)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kls->kode_kelas }}</td>
                <td>{{ $kls->level }}</td>
                <td>{{ $kls->jurusan ?? '-' }}</td>
                <td>{{ $kls->nama_kelas }}</td>
                <td style="vertical-align: middle;">
                  <div class="d-flex gap-2 align-items-center" style="height: 100%;">
                    <button class="btn btn-sm btn-warning p-2" data-bs-toggle="modal" data-bs-target="#modalEditKelas{{ $kls->kode_kelas }}" title="Edit" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                      <i class="fa fa-edit"></i>
                    </button>
                    <form action="{{ route('kelas.destroy', $kls->kode_kelas) }}" method="POST" style="display: inline-flex; margin: 0; padding: 0; align-items: center;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger p-2" title="Hapus" onclick="return confirm('Yakin hapus kelas ini?')" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              <!-- Modal Edit Kelas (pindahkan ke sini) -->
              <div class="modal fade" id="modalEditKelas{{ $kls->kode_kelas }}" tabindex="-1" aria-labelledby="modalEditKelasLabel{{ $kls->kode_kelas }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <form action="{{ route('kelas.update', $kls->kode_kelas) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKelasLabel{{ $kls->kode_kelas }}">Edit Kelas - {{ $kls->nama_kelas }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label for="kode_kelas" class="form-label">Kode Kelas</label>
                            <input type="text" class="form-control" name="kode_kelas" value="{{ $kls->kode_kelas }}" required>
                          </div>
                          <div class="col-md-6">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-select" name="level" required>
                              <option value="">-- Pilih --</option>
                              <option value="X" {{ $kls->level == 'X' ? 'selected' : '' }}>X</option>
                              <option value="XI" {{ $kls->level == 'XI' ? 'selected' : '' }}>XI</option>
                              <option value="XII" {{ $kls->level == 'XII' ? 'selected' : '' }}>XII</option>
                            </select>
                          </div>
                          <div class="col-md-6">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input type="text" class="form-control" name="jurusan" value="{{ $kls->jurusan }}" required maxlength="8">
                          </div>
                          <div class="col-md-6">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama_kelas" value="{{ $kls->nama_kelas }}" required>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Tambah Kelas -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('kelas.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahKelasLabel">Tambah Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="kode_kelas" class="form-label">Kode Kelas</label>
              <input type="text" class="form-control" name="kode_kelas" required>
            </div>
            <div class="col-md-6">
              <label for="level" class="form-label">Level</label>
              <select class="form-select" name="level" required>
                <option value="">-- Pilih --</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="jurusan" class="form-label">Jurusan</label>
              <input type="text" class="form-control" name="jurusan" required maxlength="8">
            </div>
            <div class="col-md-6">
              <label for="nama_kelas" class="form-label">Nama Kelas</label>
              <input type="text" class="form-control" name="nama_kelas" required>
            </div>
            <!-- Tambahkan field lain sesuai kebutuhan -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImportKelas" tabindex="-1" aria-labelledby="modalImportKelasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('kelas.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalImportKelasLabel">Import Data Kelas</h5>
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
              <li>Download template <a href="{{ asset('templates/template_import_kelas.xlsx') }}">disini</a></li>
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
@endsection