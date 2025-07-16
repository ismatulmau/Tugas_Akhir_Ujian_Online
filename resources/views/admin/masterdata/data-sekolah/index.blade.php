@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Data Sekolah</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('data-sekolah.index') }}">Data Sekolah</a></li>
    </ul>
</div>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('data-sekolah.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Kolom Logo -->
            <div class="col-md-4 text-center mb-3">
                <label class="fw-bold mb-2 d-block">Logo Sekolah</label>
                @if(!empty($data->logo))
                    <img src="{{ asset('storage/'.$data->logo) }}" alt="Logo Sekolah" class="img-thumbnail mb-3" style="max-width: 150px;">
                @else
                    <div class="bg-light border d-flex justify-content-center align-items-center" style="width: 150px; height: 150px;">
                        <span class="text-muted">Belum ada logo</span>
                    </div>
                @endif
                <input type="file" name="logo" class="form-control mt-2">
            </div>

            <!-- Kolom Form -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah', $data->nama_sekolah ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Nama Kepala Sekolah</label>
                        <input type="text" name="nama_kepala_sekolah" class="form-control" value="{{ old('nama_kepala_sekolah', $data->nama_kepala_sekolah ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="fw-semibold">Alamat Sekolah</label>
                        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $data->alamat ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepala_sekolah" class="form-control" value="{{ old('nip_kepala_sekolah', $data->nip_kepala_sekolah ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Tahun Pelajaran</label>
                        <input type="text" name="tahun_pelajaran" class="form-control" value="{{ old('tahun_pelajaran', $data->tahun_pelajaran ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Semester</label>
                        <input type="text" name="semester" class="form-control" value="{{ old('semester', $data->semester ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Jenis Tes</label>
                        <select name="jenis_tes" class="form-select">
                            <option value="">-- Pilih Jenis Tes --</option>
                            <option value="UTS" {{ old('jenis_tes', $data->jenis_tes ?? '') == 'UTS' ? 'selected' : '' }}>UTS</option>
                            <option value="UAS" {{ old('jenis_tes', $data->jenis_tes ?? '') == 'UAS' ? 'selected' : '' }}>UAS</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </form>
</div>

</div>
@endsection