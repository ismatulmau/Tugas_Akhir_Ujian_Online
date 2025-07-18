@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Daftar Siswa</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('siswa.index') }}">Daftar Siswa</a></li>
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
                <h4 class="card-title">Daftar Siswa</h4>
                <div class="d-flex gap-2">
                    <!-- Tombol Upload Foto -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalUploadMassal">
                        <i class="fas fa-camera"></i> Upload Foto
                    </button>

                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportSiswa">
                        <i class="fas fa-file-import"></i> Import Excel
                    </button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
                        <i class="fa fa-plus"></i> Tambah Siswa
                    </button>
                    <!-- Tombol Cetak Kartu Ujian -->
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalCetakKartu">
                        <i class="fas fa-id-card"></i> Cetak Kartu Ujian
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nomor Peserta</th>
                                <th>Nama Peserta</th>
                                <th>Kelas</th>
                                <th>Level</th>
                                <th>Jenis Kelamin</th>
                                <th>Ruang Ujian</th>
                                <th>Agama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $index => $siswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @php
                                    $fotoPath = public_path('storage/' . $siswa->gambar);
                                    @endphp

                                    @if($siswa->gambar && file_exists($fotoPath))
                                    <img src="{{ asset('storage/' . $siswa->gambar) }}" alt="Foto Siswa"
                                        width="40" height="40">
                                    @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <i class="fa fa-user text-white"></i>
                                    </div>
                                    @endif
                                </td>

                                <td>
                                    <div>{{ $siswa->nomor_ujian }}</div>
                                    <small class="text-muted">Sesi: {{ $siswa->sesi_ujian }}</small>
                                </td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>
                                    <div>{{ $siswa->kelas->nama_kelas ?? '-' }}</div>
                                    <small class="text-muted">Jurusan: {{ $siswa->jurusan }}</small>
                                </td>
                                <td>{{ $siswa->level }}</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>{{ $siswa->ruang_ujian }}</td>
                                <td>{{ $siswa->agama }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#modalEditSiswa{{ $siswa->id_siswa }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <form action="{{ route('siswa.destroy', $siswa->id_siswa) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus siswa ini?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit Siswa -->
                            <div class="modal fade" id="modalEditSiswa{{ $siswa->id_siswa }}" tabindex="-1"
                                aria-labelledby="modalEditSiswaLabel{{ $siswa->id_siswa }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('siswa.update', $siswa->id_siswa) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditSiswaLabel{{ $siswa->id_siswa }}">
                                                    Edit Data Siswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nama Siswa</label>
                                                        <input type="text" class="form-control" name="nama_siswa"
                                                            value="{{ $siswa->nama_siswa }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nomor Ujian</label>
                                                        <input type="text" class="form-control" name="nomor_ujian"
                                                            value="{{ $siswa->nomor_ujian }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nomor Induk</label>
                                                        <input type="text" class="form-control" name="nomor_induk"
                                                            value="{{ $siswa->nomor_induk }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Jurusan</label>
                                                        <select class="form-select" name="jurusan" id="edit-jurusan-{{ $siswa->id_siswa }}" required>
                                                            @foreach($jurusan as $jrs)
                                                            <option value="{{ $jrs->jurusan }}"
                                                                {{ $siswa->jurusan == $jrs->jurusan ? 'selected' : '' }}>
                                                                {{ $jrs->jurusan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Level</label>
                                                        <select class="form-select" name="level" id="edit-level-{{ $siswa->id_siswa }}" required>
                                                            <option value="X" {{ $siswa->level == 'X' ? 'selected' : '' }}>X</option>
                                                            <option value="XI" {{ $siswa->level == 'XI' ? 'selected' : '' }}>XI</option>
                                                            <option value="XII" {{ $siswa->level == 'XII' ? 'selected' : '' }}>XII</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Kelas</label>
                                                        <select class="form-select" name="kode_kelas" id="edit-kelas-{{ $siswa->id_siswa }}" required>
                                                            @foreach($kelas as $kls)
                                                            <option value="{{ $kls->kode_kelas }}"
                                                                data-jurusan="{{ $kls->jurusan }}"
                                                                data-level="{{ $kls->level }}"
                                                                {{ $kls->kode_kelas == $siswa->kode_kelas ? 'selected' : '' }}>
                                                                {{ $kls->nama_kelas }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <select class="form-select" name="jenis_kelamin" required>
                                                            <option value="L"
                                                                {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                Laki-laki</option>
                                                            <option value="P"
                                                                {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Password (kosongkan jika tidak ingin
                                                            mengubah)</label>
                                                        <input type="text" class="form-control" name="password"
                                                            maxlength="8">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Agama</label>
                                                        <input type="text" class="form-control" name="agama"
                                                            value="{{ $siswa->agama }}" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Sesi Ujian</label>
                                                        <input type="text" class="form-control" name="sesi_ujian"
                                                            value="{{ $siswa->sesi_ujian }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Ruang Ujian</label>
                                                        <input type="text" class="form-control" name="ruang_ujian"
                                                            value="{{ $siswa->ruang_ujian }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Foto Siswa (biarkan kosong jika tidak
                                                            diganti)</label>
                                                        <input type="file" class="form-control" name="gambar">
                                                        @if($siswa->gambar)
                                                        <img src="{{ asset('storage/' . $siswa->gambar) }}"
                                                            alt="Gambar siswa" class="img-thumbnail"
                                                            style="max-width: 60px; height: auto;">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning">Perbarui</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const modal = document.getElementById('modalEditSiswa{{ $siswa->id_siswa }}');

                                    modal.addEventListener('shown.bs.modal', function() {
                                        const jurusanEdit = document.getElementById('edit-jurusan-{{ $siswa->id_siswa }}');
                                        const levelEdit = document.getElementById('edit-level-{{ $siswa->id_siswa }}');
                                        const kelasEdit = document.getElementById('edit-kelas-{{ $siswa->id_siswa }}');

                                        if (jurusanEdit && levelEdit && kelasEdit) {
                                            const allEditOptions = Array.from(kelasEdit.querySelectorAll('option'));
                                            const selectedValue = kelasEdit.value;

                                            function filterEditKelas() {
                                                const selectedJurusan = jurusanEdit.value;
                                                const selectedLevel = levelEdit.value;

                                                kelasEdit.innerHTML = '';

                                                allEditOptions.forEach(option => {
                                                    const jurusan = option.dataset.jurusan;
                                                    const level = option.dataset.level;

                                                    if (jurusan === selectedJurusan && level === selectedLevel) {
                                                        kelasEdit.appendChild(option);
                                                    }
                                                });

                                                // Kembalikan nilai yang terpilih jika masih ada
                                                const stillExists = Array.from(kelasEdit.options).some(opt => opt.value === selectedValue);
                                                if (stillExists) {
                                                    kelasEdit.value = selectedValue;
                                                }
                                            }

                                            jurusanEdit.addEventListener('change', filterEditKelas);
                                            levelEdit.addEventListener('change', filterEditKelas);

                                            filterEditKelas(); // langsung jalankan saat modal dibuka
                                        }
                                    });
                                });
                            </script>


                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahSiswaLabel">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_siswa" class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" name="nama_siswa" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nomor_ujian" class="form-label">Nomor Ujian</label>
                            <input type="text" class="form-control" name="nomor_ujian" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nomor_induk" class="form-label">Nomor Induk</label>
                            <input type="text" class="form-control" name="nomor_induk" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select class="form-select" name="jurusan" id="filter-jurusan" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusan as $jrs)
                                <option value="{{ $jrs->jurusan }}">{{ $jrs->jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-select" name="level" id="filter-level" required>
                                <option value="">-- Pilih Level --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label for="kode_kelas" class="form-label">Kelas</label>
                            <select class="form-select" name="kode_kelas" id="kode_kelas" required>
                                <option value="">-- Pilih Kelas --</option>
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
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="jenis_kelamin" required>
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" required maxlength="8">
                        </div>
                        <div class="col-md-6">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" class="form-control" name="agama" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sesi_ujian" class="form-label">Sesi Ujian</label>
                            <input type="text" class="form-control" name="sesi_ujian" required>
                        </div>

                        <div class="col-md-6">
                            <label for="ruang_ujian" class="form-label">Ruang Ujian</label>
                            <input type="text" class="form-control" name="ruang_ujian" required>
                        </div>

                        <div class="col-md-6">
                            <label for="gambar" class="form-label">Foto Siswa</label>
                            <input type="file" class="form-control" name="gambar">
                        </div>
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

<!-- Modal Import Excel Siswa -->
<div class="modal fade" id="modalImportSiswa" tabindex="-1" aria-labelledby="modalImportSiswaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImportSiswaLabel">Import Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Excel</label>
                        <input type="file" class="form-control" name="file" id="file" required
                            accept=".xlsx, .xls, .csv">
                        <small class="text-muted">Format file harus Excel (.xlsx, .xls) atau CSV</small>
                    </div>
                    <div class="alert alert-info">
                        <strong>Petunjuk:</strong>
                        <ul class="mb-0">
                            <li>Download template <a href="{{ route('siswa.downloadTemplate') }}">disini</a></li>
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

<!-- Modal Cetak Kartu Ujian -->
<div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakKartuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('siswa.cetak-kartu') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCetakKartuLabel">Cetak Kartu Ujian</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="jurusan" id="jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach($jurusan as $jrs)
                                    <option value="{{ $jrs->jurusan }}">{{ $jrs->jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="nama_kelas" name="nama_kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $kls)
                                    <option value="{{ $kls->nama_kelas }}" data-jurusan="{{ $kls->jurusan }}">
                                        {{ $kls->nama_kelas }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nama_kepala" class="form-label">Nama Kepala Sekolah</label>
                                <input type="text" class="form-control form-control-sm" id="nama_kepala" name="nama_kepala"
                                    value="{{ $dataSekolah->nama_kepala_sekolah ?? '-' }}" readonly>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Ujian</label>
                                <input type="text" name="jenis_ujian" class="form-control form-control-sm" value="{{ $dataSekolah->jenis_tes ?? '-' }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <input type="text" name="tahun_pelajaran" class="form-control form-control-sm" value="{{ $dataSekolah->tahun_pelajaran ?? '-' }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="nip_kepala" class="form-label">NIP Kepala Sekolah</label>
                                <input type="text" class="form-control form-control-sm" id="nip_kepala" name="nip_kepala"
                                    value="{{ $dataSekolah->nip_kepala_sekolah ?? '-' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Ujian -->
                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">Jadwal Ujian</h6>

                        <!-- Impor Jadwal -->
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-2 fs-6">Impor dari Excel</h6>
                                <div class="mb-2">
                                    <input type="file" class="form-control form-control-sm" name="file_jadwal" id="file_jadwal" accept=".xlsx,.xls">
                                    <small class="text-muted">Impor jadwal dari file excel</small>
                                </div>
                                <a href="{{ route('jadwal.template') }}" class="btn btn-sm btn-outline-success mt-1">
                                    <i class="fas fa-download me-1"></i> Download Template
                                </a>
                            </div>
                        </div>

                        <!-- Input Manual -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-2 fs-6">Input Manual</h6>
                                <div id="jadwal-wrapper">
                                    <div class="row g-2 mb-2 align-items-center">
                                        <!-- Hari (2 kolom) -->
                                        <div class="col-md-2">
                                            <input type="text" name="jadwal[0][hari]" class="form-control form-control-sm hari" placeholder="Hari" readonly>
                                        </div>

                                        <!-- Tanggal (2 kolom) -->
                                        <div class="col-md-2">
                                            <input type="date" name="jadwal[0][tanggal]" class="form-control form-control-sm tanggal">
                                        </div>

                                        <!-- Jam Mulai (2 kolom) -->
                                        <div class="col-md-2">
                                            <input type="time" name="jadwal[0][jam_mulai]" class="form-control form-control-sm" placeholder="Mulai" required>
                                        </div>

                                        <!-- Jam Selesai (2 kolom) -->
                                        <div class="col-md-2">
                                            <input type="time" name="jadwal[0][jam_selesai]" class="form-control form-control-sm" placeholder="Selesai" required>
                                        </div>

                                        <!-- Mapel (4 kolom) -->
                                        <div class="col-md-4">
                                            <select name="jadwal[0][mapel]" class="form-select form-select-sm" required>
                                                <option value="">Pilih Mata Pelajaran</option>
                                                @foreach($mapel as $mp)
                                                <option value="{{ $mp->nama_mapel }}">{{ $mp->nama_mapel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahJadwal()">
                                    <i class="fas fa-plus me-1"></i> Tambah Jadwal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-print me-1"></i> Cetak Kartu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ajax -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- impor jadwal -->
<script>
    document.getElementById('file_jadwal').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {
                type: 'array'
            });

            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];
            const jsonData = XLSX.utils.sheet_to_json(sheet);

            const wrapper = document.getElementById('jadwal-wrapper');
            wrapper.innerHTML = ''; // Bersihkan data sebelumnya

            jsonData.forEach((item, index) => {
                const row = document.createElement('div');
                row.classList.add('row', 'g-2', 'mb-2', 'align-items-center');

                row.innerHTML = `
                <!-- Hari (2 kolom) -->
                <div class="col-md-2">
                    <input type="text" name="jadwal[${index}][hari]" class="form-control form-control-sm hari" value="${item.Hari || ''}" readonly>
                </div>

                <!-- Tanggal (2 kolom) -->
                <div class="col-md-2">
                    <input type="date" name="jadwal[${index}][tanggal]" class="form-control form-control-sm tanggal" value="${convertToDate(item.Tanggal)}">
                </div>

                <!-- Jam Mulai (2 kolom) -->
                <div class="col-md-2">
                    <input type="time" name="jadwal[${index}][jam_mulai]" class="form-control form-control-sm" value="${formatJam(item['Jam Mulai'])}" required>
                </div>

                <!-- Jam Selesai (2 kolom) -->
                <div class="col-md-2">
                    <input type="time" name="jadwal[${index}][jam_selesai]" class="form-control form-control-sm" value="${formatJam(item['Jam Selesai'])}" required>
                </div>

                <!-- Mapel (4 kolom) -->
                <div class="col-md-4">
                    <input type="text" name="jadwal[${index}][mapel]" class="form-control form-control-sm" value="${item.Mapel || ''}" required>
                </div>
            `;

                wrapper.appendChild(row);

                // Bind tanggal ke hari
                const inputTanggal = row.querySelector('.tanggal');
                const inputHari = row.querySelector('.hari');
                bindTanggalKeHari(inputTanggal, inputHari);
            });
        };
        reader.readAsArrayBuffer(file);
    });


    function formatJam(jam) {
        if (!jam) return '';
        if (typeof jam === 'number') {
            const totalMinutes = Math.round(jam * 24 * 60);
            const hours = String(Math.floor(totalMinutes / 60)).padStart(2, '0');
            const minutes = String(totalMinutes % 60).padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        // Jika dalam format string "07.00", ubah jadi "07:00"
        return jam.replace('.', ':');
    }


    function convertToDate(excelDate) {
        if (!excelDate) return '';
        const date = new Date((excelDate - 25569) * 86400 * 1000);
        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }
</script>

<!-- function tambah jadwal -->
<script>
    let jadwalIndex = 1;

    function getNamaHari(tanggalStr) {
        const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const tanggal = new Date(tanggalStr);
        return hari[tanggal.getDay()];
    }

    function getTanggalHariIni() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    function bindTanggalKeHari(inputTanggal, inputHari) {
        inputTanggal.addEventListener('change', function() {
            inputHari.value = this.value ? getNamaHari(this.value) : '';
        });
    }

    function tambahJadwal() {
        const wrapper = document.getElementById('jadwal-wrapper');
        const row = document.createElement('div');
        row.classList.add('row', 'g-2', 'mb-2', 'align-items-center');

        const minDate = getTanggalHariIni();

        const mapelOptions = `
        @foreach($mapel as $mp)
            <option value="{{ $mp->nama_mapel }}">{{ $mp->nama_mapel }}</option>
        @endforeach
    `;

        row.innerHTML = `
        <!-- Hari (2 kolom) -->
        <div class="col-md-2">
            <input type="text" name="jadwal[${jadwalIndex}][hari]" class="form-control form-control-sm hari" placeholder="Hari" readonly>
        </div>

        <!-- Tanggal (2 kolom) -->
        <div class="col-md-2">
            <input type="date" name="jadwal[${jadwalIndex}][tanggal]" class="form-control form-control-sm tanggal" min="${minDate}">
        </div>

        <!-- Jam Mulai (2 kolom) -->
        <div class="col-md-2">
            <input type="time" name="jadwal[${jadwalIndex}][jam_mulai]" class="form-control form-control-sm" required>
        </div>

        <!-- Jam Selesai (2 kolom) -->
        <div class="col-md-2">
            <input type="time" name="jadwal[${jadwalIndex}][jam_selesai]" class="form-control form-control-sm" required>
        </div>

        <!-- Mapel (4 kolom) -->
        <div class="col-md-4">
            <select name="jadwal[${jadwalIndex}][mapel]" class="form-select form-select-sm" required>
                <option value="">Pilih Mata Pelajaran</option>
                ${mapelOptions}
            </select>
        </div>
    `;

        wrapper.appendChild(row);

        // Bind hari otomatis dari tanggal
        const inputTanggal = row.querySelector('.tanggal');
        const inputHari = row.querySelector('.hari');
        bindTanggalKeHari(inputTanggal, inputHari);

        jadwalIndex++;
    }

    // Jalankan saat pertama kali halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const inputTanggalAwal = document.querySelector('.tanggal');
        const inputHariAwal = document.querySelector('.hari');

        if (inputTanggalAwal && inputHariAwal) {
            const minDate = getTanggalHariIni();
            inputTanggalAwal.setAttribute('min', minDate);
            bindTanggalKeHari(inputTanggalAwal, inputHariAwal);
        }
    });
</script>

<!-- Modal Upload Massal -->
<div class="modal fade" id="modalUploadMassal" tabindex="-1" aria-labelledby="modalUploadMassalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('siswa.uploadGambarMassal') }}" method="POST" enctype="multipart/form-data"
            class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalUploadMassalLabel">Upload Banyak Foto Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="gambar" class="form-label">Pilih Beberapa Gambar</label>
                    <input type="file" class="form-control" name="gambar[]" id="gambar_massal" accept="image/*" multiple
                        required>
                    <small class="form-text text-muted">Nama file harus sesuai dengan kolom <strong>gambar</strong> pada
                        data siswa (misal: 2203043.jpg)</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Upload Semua</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- filter kelas -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jurusanSelect = document.getElementById('jurusan');
        const kelasSelect = document.getElementById('nama_kelas');

        // Simpan semua opsi awal
        const allOptions = Array.from(kelasSelect.querySelectorAll('option'));

        jurusanSelect.addEventListener('change', function() {
            const selectedJurusan = jurusanSelect.value;

            // Bersihkan semua opsi kelas kecuali placeholder pertama
            kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';

            // Filter dan tambahkan opsi yang cocok
            allOptions.forEach(option => {
                if (option.value === "") return; // Skip placeholder

                if (option.dataset.jurusan === selectedJurusan) {
                    kelasSelect.appendChild(option);
                }
            });
        });
    });
</script>

<!-- filter kelas modal tambah siswa -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jurusanSelect = document.getElementById('filter-jurusan');
        const levelSelect = document.getElementById('filter-level');
        const kelasSelect = document.getElementById('kode_kelas');

        // Simpan semua opsi kelas
        const allOptions = Array.from(kelasSelect.querySelectorAll('option'));

        function filterKelasOptions() {
            const selectedJurusan = jurusanSelect.value;
            const selectedLevel = levelSelect.value;

            // Reset opsi kelas
            kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';

            allOptions.forEach(option => {
                if (option.value === "") return;

                const jurusan = option.getAttribute('data-jurusan');
                const level = option.getAttribute('data-level');

                if (jurusan === selectedJurusan && level === selectedLevel) {
                    kelasSelect.appendChild(option);
                }
            });
        }

        jurusanSelect.addEventListener('change', filterKelasOptions);
        levelSelect.addEventListener('change', filterKelasOptions);
    });
</script>

@endsection