@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Daftar Siswa</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('siswa.index') }}">Daftar Siswa</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a>Edit Siswa</a></li>
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


<div class="container">
    <h5>Edit Data Siswa</h5>
    <form action="{{ route('siswa.update', $siswa->id_siswa) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama Siswa</label>
                    <input type="text" name="nama_siswa" class="form-control" value="{{ $siswa->nama_siswa }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Induk</label>
                    <input type="text" name="nomor_induk" class="form-control" value="{{ $siswa->nomor_induk }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Ujian</label>
                    <input type="text" name="nomor_ujian" class="form-control" value="{{ $siswa->nomor_ujian }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kode_kelas" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->kode_kelas }}" {{ $siswa->kode_kelas == $k->kode_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Level</label>
                    <select name="level" class="form-select" required>
                        <option value="X" {{ $siswa->level == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ $siswa->level == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ $siswa->level == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jurusan</label>
                    <input type="text" name="jurusan" class="form-control" value="{{ $siswa->jurusan }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Siswa</label>
                    <input type="file" name="gambar" class="form-control">
                    @if($siswa->gambar)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $siswa->gambar) }}" alt="Foto Siswa" width="100">
                            <small class="text-muted d-block">Foto saat ini</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Ujian</label>
                    <select name="jenis_ujian" class="form-select" required>
                        <option value="UTS" {{ $siswa->jenis_ujian == 'UTS' ? 'selected' : '' }}>UTS</option>
                        <option value="UAS" {{ $siswa->jenis_ujian == 'UAS' ? 'selected' : '' }}>UAS</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sesi Ujian</label>
                    <input type="text" name="sesi_ujian" class="form-control" value="{{ $siswa->sesi_ujian }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ruang Ujian</label>
                    <input type="text" name="ruang_ujian" class="form-control" value="{{ $siswa->ruang_ujian }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Agama</label>
                    <input type="text" name="agama" class="form-control" value="{{ $siswa->agama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="text" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah" maxlength="8">
                </div>
            </div>
        </div>

        <div class="text-end"> <!-- atau "d-flex justify-content-end" -->
    <a href="{{ route('siswa.index') }}" class="btn btn-secondary me-2">Kembali</a>
    <button type="submit" class="btn btn-primary">Update Data</button>
</div>
    </form>
</div>
@endsection