@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Edit Kelas</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('kelas.index') }}">Daftar Kelas</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Edit Kelas</a></li>
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
    <h4>Edit Data Kelas</h4>
    <form action="{{ route('kelas.update', $kelas->kode_kelas) }}" method="POST">
    @csrf
    @method('PUT')

        <div class="mb-3">
            <label>Kode Kelas</label>
            <input type="text" name="kode_kelas" class="form-control" value="{{ $kelas->kode_kelas }}">
        </div>
        <div class="mb-3">
            <label>Level</label>
            <input type="text" name="level" class="form-control" value="{{ $kelas->level }}">
        </div>
        <div class="mb-3">
            <label>Jurusan</label>
            <input type="text" name="jurusan" class="form-control" value="{{ $kelas->jurusan }}">
        </div>
        <div class="mb-3">
            <label>Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
