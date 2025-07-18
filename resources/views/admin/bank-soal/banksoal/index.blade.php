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
                  {{ $banksoal->level ?? '-' }} -
                  {{ $banksoal->kode_kelas == 'ALL' ? 'ALL' : ($banksoal->kelas->nama_kelas ?? '-') }}<br>
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
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select name="jurusan" id="jurusan-{{ $banksoal->id_bank_soal }}" class="form-select jurusan-edit" data-id="{{ $banksoal->id_bank_soal }}">
                              <option value="">-- Pilih Jurusan --</option>
                              @foreach($jurusan as $jrs)
                              <option value="{{ $jrs->jurusan }}" {{ $banksoal->jurusan == $jrs->jurusan ? 'selected' : '' }}>
                                {{ $jrs->jurusan }}
                              </option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label for="level" class="form-label">Level Kelas</label>
                            <select class="form-select level-edit" name="level" id="level-{{ $banksoal->id_bank_soal }}" data-id="{{ $banksoal->id_bank_soal }}">
                              <option value="">-- Pilih Level --</option>
                              @foreach(['X', 'XI', 'XII'] as $level)
                              <option value="{{ $level }}" {{ $banksoal->level == $level ? 'selected' : '' }}>
                                {{ $level }}
                              </option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label for="level">Kelas</label>
                            <select
                              name="kode_kelas"
                              id="kode_kelas-{{ $banksoal->id_bank_soal }}"
                              class="form-select"
                              data-id="{{ $banksoal->id_bank_soal }}"
                              data-selected="{{ $banksoal->kode_kelas }}"
                              required>
                              <option value="">-- Pilih Kelas --</option>
                              <option value="ALL" {{ $banksoal->kode_kelas == 'ALL' ? 'selected' : '' }}>Semua Kelas</option>
                              @foreach($kelas as $kls)
                              <option
                                value="{{ $kls->kode_kelas }}"
                                data-jurusan="{{ $kls->jurusan }}"
                                data-level="{{ $kls->level }}"
                                {{ $banksoal->kode_kelas == $kls->kode_kelas ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                              </option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label for="kode_mapel" class="form-label">Mata Pelajaran</label>
                            <select class="form-select mapel-edit" name="kode_mapel" id="kode_mapel-{{ $banksoal->id_bank_soal }}" required>
                              @foreach($mapels as $mapel)
                              <option value="{{ $mapel->kode_mapel }}" {{ $banksoal->kode_mapel == $mapel->kode_mapel ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
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
              <li>Tidak diperbolehkan mengaktifkan lebih dari satu bank soal untuk <strong>level</strong>, <strong>kelas</strong> dan <strong>jurusan</strong> yang sama secara bersamaan.</li>
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
              <label for="jurusan" class="form-label">Jurusan</label>
              <select name="jurusan" id="jurusan_tambah" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach($jurusan as $item)
                <option value="{{ $item->jurusan }}">{{ $item->jurusan }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label for="level" class="form-label">Level Kelas</label>
              <select class="form-select" name="level" id="level_tambah" required>
                <option value="">-- Pilih Level --</option>
                @foreach(['X', 'XI', 'XII'] as $level)
                <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>
                  {{ $level }}
                </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label for="level">Kelas</label>
              <select name="kode_kelas" id="kode_kelas_tambah" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="ALL">Semua Kelas</option>
                @foreach($kelas as $kls)
                <option
                  value="{{ $kls->kode_kelas }}"
                  data-jurusan="{{ $kls->jurusan }}"
                  data-level="{{ $kls->level }}">
                  {{ $kls->nama_kelas }}
                </option>
                @endforeach
              </select>

            </div>

            <div class="col-md-6">
              <label for="kode_mapel" class="form-label">Mata Pelajaran</label>
              <select class="form-select" name="kode_mapel" id="kode_mapel_tambah" required>
                <option value="">-- Pilih Mapel --</option>
                @foreach($mapels as $mapel)
                @foreach($mapel->kelas as $kelas)
                <option
                  value="{{ $mapel->kode_mapel }}"
                  data-kelas="{{ $kelas->kode_kelas }}"
                  data-jurusan="{{ $kelas->jurusan }}">
                  {{ $mapel->kode_mapel }}
                </option>
                @endforeach
                @endforeach

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

<!-- filter mapel -->
<script>
  const allMapels = @json($mapels);
</script>
<!-- Filter mapel -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const jurusanSelect = document.getElementById('jurusan_tambah');
    const levelSelect = document.getElementById('level_tambah');
    const kelasSelect = document.getElementById('kode_kelas_tambah');
    const mapelSelect = document.getElementById('kode_mapel_tambah');

    function filterMapel() {
      const selectedJurusan = jurusanSelect.value;
      const selectedLevel = levelSelect.value;
      const selectedKelas = kelasSelect.value;

      // Reset mapel
      mapelSelect.innerHTML = '<option value="">-- Pilih Mapel --</option>';

      if (!selectedJurusan || !selectedLevel) return;

      const filteredMapels = [];

      allMapels.forEach(mapel => {
        mapel.kelas.forEach(kelas => {
          if (
            kelas.jurusan === selectedJurusan &&
            kelas.level === selectedLevel &&
            (selectedKelas === 'ALL' || kelas.kode_kelas === selectedKelas)
          ) {
            if (!filteredMapels.find(m => m.kode_mapel === mapel.kode_mapel)) {
              filteredMapels.push(mapel);
            }
          }
        });
      });

      filteredMapels.forEach(mapel => {
        const option = document.createElement('option');
        option.value = mapel.kode_mapel;
        option.textContent = mapel.kode_mapel;
        mapelSelect.appendChild(option);
      });
    }

    jurusanSelect.addEventListener('change', filterMapel);
    levelSelect.addEventListener('change', filterMapel);
    kelasSelect.addEventListener('change', filterMapel);
  });
</script>

<!-- filter kelas modal tambah -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const jurusanSelect = document.getElementById('jurusan_tambah');
    const levelSelect = document.getElementById('level_tambah');
    const kelasSelect = document.getElementById('kode_kelas_tambah');
    const allOptions = Array.from(kelasSelect.options);

    function filterKelas() {
      const selectedJurusan = jurusanSelect.value;
      const selectedLevel = levelSelect.value;

      kelasSelect.innerHTML = `
        <option value="">-- Pilih Kelas --</option>
        <option value="ALL">Semua Kelas</option>
      `;

      allOptions.forEach(option => {
        const jurusan = option.dataset.jurusan;
        const level = option.dataset.level;

        if (jurusan === selectedJurusan && level === selectedLevel) {
          kelasSelect.appendChild(option);
        }
      });
    }

    jurusanSelect.addEventListener('change', filterKelas);
    levelSelect.addEventListener('change', filterKelas);
  });
</script>

<!-- filter kelas modal edit-->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Untuk setiap modal edit
    document.querySelectorAll('.jurusan-edit').forEach((jurusanSelect) => {
      const id = jurusanSelect.dataset.id;
      const levelSelect = document.getElementById('level-' + id);
      const kelasSelect = document.getElementById('kode_kelas-' + id);

      // Simpan semua opsi awal sebagai referensi
      const allOptions = Array.from(kelasSelect.options).map(opt => opt.cloneNode(true));

      function filterKelasEdit() {
        const selectedJurusan = jurusanSelect.value;
        const selectedLevel = levelSelect.value;

        kelasSelect.innerHTML = `
          <option value="">-- Pilih Kelas --</option>
          <option value="ALL">Semua Kelas</option>
        `;

        allOptions.forEach(option => {
          const jurusan = option.dataset.jurusan;
          const level = option.dataset.level;

          if (jurusan === selectedJurusan && level === selectedLevel) {
            kelasSelect.appendChild(option);
          }
        });

        // Pilih ulang kelas sebelumnya jika masih sesuai
        const selected = kelasSelect.getAttribute('data-selected');
        if (selected) {
          kelasSelect.value = selected;
        }
      }

      jurusanSelect.addEventListener('change', filterKelasEdit);
      levelSelect.addEventListener('change', filterKelasEdit);

      // Trigger filter saat halaman dimuat (agar tampil defaultnya)
      filterKelasEdit();
    });
  });
</script>

<!-- filter mapel modal edit-->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const jurusanEdits = document.querySelectorAll('.jurusan-edit');
    const levelEdits = document.querySelectorAll('.level-edit');
    const kelasEdits = document.querySelectorAll('[id^="kode_kelas-"]');

    jurusanEdits.forEach(jurusanSelect => {
      const id = jurusanSelect.dataset.id;
      const levelSelect = document.getElementById(`level-${id}`);
      const kelasSelect = document.getElementById(`kode_kelas-${id}`);
      const mapelSelect = document.getElementById(`kode_mapel-${id}`);

      function filterMapelEdit() {
        const selectedJurusan = jurusanSelect.value;
        const selectedLevel = levelSelect.value;
        const selectedKelas = kelasSelect.value;
        const selectedValue = mapelSelect.value;

        mapelSelect.innerHTML = '<option value="">-- Pilih Mapel --</option>';

        if (!selectedJurusan || !selectedLevel) return;

        const filteredMapels = [];

        allMapels.forEach(mapel => {
          mapel.kelas.forEach(kelas => {
            if (
              kelas.jurusan === selectedJurusan &&
              kelas.level === selectedLevel &&
              (selectedKelas === 'ALL' || kelas.kode_kelas === selectedKelas)
            ) {
              if (!filteredMapels.find(m => m.kode_mapel === mapel.kode_mapel)) {
                filteredMapels.push(mapel);
              }
            }
          });
        });

        filteredMapels.forEach(mapel => {
          const option = document.createElement('option');
          option.value = mapel.kode_mapel;
          option.textContent = mapel.kode_mapel;

          if (option.value === selectedValue) {
            option.selected = true;
          }

          mapelSelect.appendChild(option);
        });
      }

      jurusanSelect.addEventListener('change', filterMapelEdit);
      levelSelect.addEventListener('change', filterMapelEdit);
      kelasSelect.addEventListener('change', filterMapelEdit);

      // Panggil saat modal terbuka
      filterMapelEdit();
    });
  });
</script>




@endsection