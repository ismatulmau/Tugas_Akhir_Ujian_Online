@extends('layouts.app')

@section('page-header')
<div class="page-header">
  <h4 class="page-title">Daftar Mata Pelajaran</h4>
  <ul class="breadcrumbs">
    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
    <li class="separator"><i class="icon-arrow-right"></i></li>
    <li class="nav-item"><a href="{{ route('mapel.index') }}">Daftar Mata Pelajaran</a></li>
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

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Daftar Mata Pelajaran</h4>
        <div class="d-flex gap-2">
          <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportMapel">
            <i class="fas fa-file-import"></i> Import Excel
          </button>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMapel">
            <i class="fa fa-plus"></i> Tambah Mapel
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th>% UTS</th>
                <th>% UAS</th>
                <th>KKM</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($mapels as $index => $mapel)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mapel->kode_mapel }}</td>
                <td>{{ $mapel->nama_mapel }}</td>
                <td>{{ $mapel->persen_uts}}</td>
                <td>{{ $mapel->persen_uas}}</td>
                <td>{{ $mapel->kkm }}</td>
                <td style="vertical-align: middle;">
                  <div class="d-flex gap-2 align-items-center" style="height: 100%;">
                    <button class="btn btn-sm btn-warning p-2" data-bs-toggle="modal" data-bs-target="#modalEditMapel{{ $mapel->kode_mapel }}" title="Edit" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                      <i class="fa fa-edit"></i>
                    </button>
                    <form action="{{ route('mapel.destroy', $mapel->kode_mapel) }}" method="POST" style="display: inline-flex; margin: 0; padding: 0; align-items: center;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger p-2" title="Hapus" onclick="return confirm('Yakin hapus mata pelajaran ini?')" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              <!-- Modal Edit Mata Pelajaran -->
              <div class="modal fade" id="modalEditMapel{{ $mapel->kode_mapel }}" tabindex="-1" aria-labelledby="modalEditMapelLabel{{ $mapel->kode_mapel }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <form action="{{ route('mapel.update', $mapel->kode_mapel) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalEditMapelLabel{{ $mapel->kode_mapel}}">Edit Mapel - {{ $mapel->nama_mapel }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label for="kode_mapel" class="form-label">Kode Mapel</label>
                            <input type="text" class="form-control" name="kode_mapel" value="{{ $mapel->kode_mapel }}" required>
                          </div>
                          <div class="col-md-6">
                            <label for="nama_mapel" class="form-label">Nama Mapel</label>
                            <input type="text" class="form-control" name="nama_mapel" value="{{ $mapel->nama_mapel }}" required>
                          </div>
                          <div class="col-md-6">
                            <label for="persen_uts" class="form-label">% UTS</label>
                            <input type="text" class="form-control" name="persen_uts" value="{{ $mapel->persen_uts }}" required maxlength="8">
                          </div>
                          <div class="col-md-6">
                            <label for="persen_uas" class="form-label">% UAS</label>
                            <input type="text" class="form-control" name="persen_uas" value="{{ $mapel->persen_uas }}" required maxlength="8">
                          </div>
                          <div class="col-md-6">
                            <label for="kkm" class="form-label">KKM</label>
                            <input type="text" class="form-control" name="kkm" value="{{ $mapel->kkm }}" required>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
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

<!-- Modal Tambah Mapel -->
<div class="modal fade" id="modalTambahMapel" tabindex="-1" aria-labelledby="modalTambahMapelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('mapel.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahMapelLabel">Tambah Mapel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="kode_mapel" class="form-label">Kode Mapel</label>
              <input type="text" class="form-control" name="kode_mapel" required>
            </div>
            <div class="col-md-6">
              <label for="nama_mapel" class="form-label">Nama Mapel</label>
              <input type="text" class="form-control" name="nama_mapel" required>
            </div>
            <div class="col-md-6">
              <label for="persen_uts" class="form-label">% UTS</label>
              <input type="text" class="form-control" name="persen_uts" required maxlength="8">
            </div>
            <div class="col-md-6">
              <label for="persen_uas" class="form-label">% UAS</label>
              <input type="text" class="form-control" name="persen_uas" required maxlength="8">
            </div>
            <div class="col-md-6">
              <label for="kkm" class="form-label">KKM</label>
              <input type="text" class="form-control" name="kkm" required>
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
<div class="modal fade" id="modalImportMapel" tabindex="-1" aria-labelledby="modalImportMapelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('mapel.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalImportMapelLabel">Import Data Mapel</h5>
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
              <li>Download template <a href="{{ route('mapel.downloadTemplate') }}">disini</a></li>
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