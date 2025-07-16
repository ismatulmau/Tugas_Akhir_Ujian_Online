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
                <th>Kelas</th>
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
                <td>
                  @forelse($mapel->kelas as $kls)
                  <span>{{ $kls->nama_kelas }}</span><br>
                  @empty
                  <span class="text-muted">Belum ada</span>
                  @endforelse
                </td>
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
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select class="form-select" onchange="filterKelasByJurusanEdit(this.value, '{{ $mapel->kode_mapel }}')" id="selectJurusanEdit{{ $mapel->kode_mapel }}">
                              <option value="">Pilih Jurusan</option>
                              @foreach($jurusanList as $jur)
                              <option value="{{ $jur }}" {{ $mapel->kelas->first()?->jurusan == $jur ? 'selected' : '' }}>{{ $jur }}</option>
                              @endforeach
                            </select>

                          </div>

                          <div class="col-md-12">
                            <label class="form-label d-block">Pilih Kelas</label>
                            <div class="row" id="checkbox-kelas-edit-{{ $mapel->kode_mapel }}">
                              @foreach($kelas as $kls)
                              @php
                              $jurusanMapel = $mapel->kelas->first()?->jurusan;
                              $tampil = $jurusanMapel == $kls->jurusan;
                              @endphp
                              <div class="col-md-3 kelas-checkbox-edit"
                                data-jurusan="{{ $kls->jurusan }}"
                                style="{{ $tampil ? '' : 'display: none;' }}">
                                <div class="form-check">
                                  <input class="form-check-input"
                                    type="checkbox"
                                    name="kelas[]"
                                    value="{{ $kls->kode_kelas }}"
                                    id="kelasEdit{{ $mapel->kode_mapel }}{{ $loop->index }}"
                                    {{ $mapel->kelas->contains('kode_kelas', $kls->kode_kelas) ? 'checked' : '' }}>
                                  <label class="form-check-label" for="kelasEdit{{ $mapel->kode_mapel }}{{ $loop->index }}">
                                    {{ $kls->nama_kelas }}
                                  </label>
                                </div>
                              </div>
                              @endforeach

                            </div>
                          </div>
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
              <label for="jurusan" class="form-label">Jurusan</label>
              <select id="jurusan" class="form-select" onchange="filterKelasByJurusan(this.value)">
                <option value="">Pilih Jurusan</option>
                @foreach($jurusanList as $jur)
                <option value="{{ $jur }}">{{ $jur }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-12">
              <label class="form-label d-block">Pilih Kelas</label>
              <p id="kelas-placeholder" class="text-muted">Silakan pilih jurusan terlebih dahulu.</p>
              <div class="row" id="checkbox-kelas">
                @forelse($kelas as $kls)
                @if(is_object($kls) && isset($kls->jurusan))
                <div class="col-md-3 kelas-checkbox" data-jurusan="{{ $kls->jurusan }}" style="display: none;">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kelas[]" value="{{ $kls->kode_kelas }}" id="kelas{{ $loop->index }}">
                    <label class="form-check-label" for="kelas{{ $loop->index }}">{{ $kls->nama_kelas }}</label>
                  </div>
                </div>
                @endif
                @empty
                <p class="text-muted">Tidak ada data kelas.</p>
                @endforelse
              </div>
            </div>

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

<!-- filter kelas -->
<script>
  function filterKelasByJurusan(selectedJurusan) {
    const kelasCheckboxes = document.querySelectorAll('#checkbox-kelas .kelas-checkbox');
    document.getElementById('kelas-placeholder').style.display = selectedJurusan ? 'none' : 'block';

    kelasCheckboxes.forEach(item => {
      const jurusan = item.getAttribute('data-jurusan');
      if (!selectedJurusan || jurusan === selectedJurusan) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
        const checkbox = item.querySelector('input[type="checkbox"]');
        checkbox.checked = false;
      }
    });
  }

  function filterKelasByJurusanEdit(selectedJurusan, mapelKode) {
    const kelasCheckboxes = document.querySelectorAll(`#checkbox-kelas-edit-${mapelKode} .kelas-checkbox-edit`);
    kelasCheckboxes.forEach(item => {
      const jurusan = item.getAttribute('data-jurusan');
      if (!selectedJurusan || jurusan === selectedJurusan) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
        const checkbox = item.querySelector('input[type="checkbox"]');
        checkbox.checked = false;
      }
    });
  }
</script>





@endsection