@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Bank Soal</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('bank-soal.index') }}">Daftar Bank Soal</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('soal.index', ['id_bank_soal' => $banksoal->id_bank_soal]) }}">Daftar Soal</a></li>
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
                <h5 class="card-title mb-0">Daftar Soal - {{ $banksoal->nama_bank_soal }}</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalUploadGambarSoal">
                        <i class="fas fa-camera"></i> Upload Gambar Soal
                    </button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSoal">
                        <i class="fas fa-plus"></i> Tambah Soal
                    </button>
                    <form action="{{ route('soal.kosongkan', $banksoal->id_bank_soal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua soal dalam bank soal ini?')" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fas fa-trash-alt"></i> Kosongkan Soal
    </button>
</form>
                    <a href="{{ route('bank-soal.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                @if($soals->isEmpty())
                <div class="alert alert-warning">Belum ada soal pada bank soal ini.</div>
                @else
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Pertanyaan</th>
                                <th>Gambar</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                @if(Str::contains($banksoal->opsi_jawaban, 'E'))
                                <th>E</th>
                                @endif
                                <th>Kunci Jawaban</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soals as $i => $soal)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{!! $soal->pertanyaan !!}</td>
                                <td>
                                    @if($soal->gambar_soal)
                                    <img src="{{ asset('storage/' . $soal->gambar_soal) }}"
                                        alt="Gambar Soal"
                                        class="img-thumbnail"
                                        style="max-width: 60px; height: auto;">
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ $soal->opsi_a }}</td>
                                <td>{{ $soal->opsi_b }}</td>
                                <td>{{ $soal->opsi_c }}</td>
                                <td>{{ $soal->opsi_d }}</td>
                                @if(Str::contains($banksoal->opsi_jawaban, 'E'))
                                <td>{{ $soal->opsi_e ?? '-' }}</td>
                                @endif
                                <td><strong>{{ $soal->jawaban_benar }}</strong></td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditSoal{{ $soal->id_soal }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('soal.destroy', $soal->id_soal) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Soal -->
                            <div class="modal fade" id="modalEditSoal{{ $soal->id_soal }}" tabindex="-1" aria-labelledby="editSoalLabel{{ $soal->id_soal }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('soal.update', $soal->id_soal) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id_bank_soal" value="{{ $banksoal->id_bank_soal }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Soal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Pertanyaan</label>
                                                    <textarea name="pertanyaan" class="form-control" rows="4" required>{{ $soal->pertanyaan }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gambar Soal (kosongkan jika tidak diubah)</label>
                                                    <input type="file" name="gambar_soal" class="form-control">
                                                    @if($soal->gambar_soal)
                                                    <img src="{{ asset('storage/' . $soal->gambar_soal) }}" alt="Gambar Soal"
                                                        class="img-thumbnail"
                                                        style="max-width: 60px; height: auto;">
                                                    @endif
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Opsi A</label>
                                                        <input type="text" name="opsi_a" class="form-control" value="{{ $soal->opsi_a }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Opsi B</label>
                                                        <input type="text" name="opsi_b" class="form-control" value="{{ $soal->opsi_b }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Opsi C</label>
                                                        <input type="text" name="opsi_c" class="form-control" value="{{ $soal->opsi_c }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Opsi D</label>
                                                        <input type="text" name="opsi_d" class="form-control" value="{{ $soal->opsi_d }}" required>
                                                    </div>
                                                    @if(Str::contains($banksoal->opsi_jawaban, 'E'))
                                                    <div class="col-md-6 mb-3">
                                                        <label>Opsi E</label>
                                                        <input type="text" name="opsi_e" class="form-control" value="{{ $soal->opsi_e }}">
                                                    </div>
                                                    @endif
                                                    <div class="col-md-6 mb-3">
                                                        <label for="jawaban_benar" class="form-label">Jawaban Benar</label>
                                                        <select name="jawaban_benar" id="jawaban_benar" class="form-select" required>
                                                            @foreach(['A','B','C','D','E'] as $opsi)
                                                            @if(Str::contains($banksoal->opsi_jawaban, $opsi))
                                                            <option value="{{ $opsi }}" {{ $soal->jawaban_benar == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
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

                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Soal -->
<div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-labelledby="modalTambahSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('soal.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <input type="hidden" name="id_bank_soal" value="{{ $banksoal->id_bank_soal }}">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahSoalLabel">Tambah Soal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="pertanyaan" class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar_soal" class="form-label">Gambar Soal (opsional)</label>
                    <input type="file" name="gambar_soal" id="gambar_soal" class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="opsi_a" class="form-label">Opsi A</label>
                        <input type="text" name="opsi_a" id="opsi_a" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="opsi_b" class="form-label">Opsi B</label>
                        <input type="text" name="opsi_b" id="opsi_b" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="opsi_c" class="form-label">Opsi C</label>
                        <input type="text" name="opsi_c" id="opsi_c" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="opsi_d" class="form-label">Opsi D</label>
                        <input type="text" name="opsi_d" id="opsi_d" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="opsi_e" class="form-label">Opsi E (opsional)</label>
                        <input type="text" name="opsi_e" id="opsi_e" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jawaban_benar" class="form-label">Jawaban Benar</label>
                        <select name="jawaban_benar" id="jawaban_benar" class="form-select" required>
                            <option value="">-- Pilih Jawaban Benar --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Upload Gambar Soal -->
<div class="modal fade" id="modalUploadGambarSoal" tabindex="-1" aria-labelledby="modalUploadGambarSoalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('soal.uploadGambarSoal') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalUploadGambarSoalLabel">Upload Gambar Soal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="gambar_soal" class="form-label">Pilih Beberapa Gambar</label>
                    <input type="file" class="form-control" name="gambar_soal[]" id="gambar_soal" accept="image/*" multiple required>
                    <small class="form-text text-muted">Nama file harus sesuai dengan kolom <strong>gambar_soal</strong> pada import data soal (misal: soal1.jpg)</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Upload Semua</button>
            </div>
        </form>
    </div>
</div>
@endsection