@extends('layouts.app')

@section('page-header')
<div class="page-header">
    <h4 class="page-title">Edit Mapel</h4>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('mapel.index') }}">Daftar Mapel</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Edit Mapel</a></li>
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
    <h4>Edit Data Mapel</h4>
    <form action="{{ route('mapel.update', $mapels->kode_mapel) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Kode Mapel</label>
            <input type="text" name="kode_mapel" class="form-control" value="{{ $mapels->kode_mapel }}">
        </div>
        <div class="mb-3">
            <label>Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control" value="{{ $mapels->nama_mapel }}">
        </div>
        <div class="mb-3">
            <label>% UTS</label>
            <input type="text" name="persen_uts" class="form-control" value="{{ $mapels->persen_uts }}">
        </div>
        <div class="mb-3">
            <label>% UAS</label>
            <input type="text" name="persen_uas" class="form-control" value="{{ $mapels->persen_uas }}">
        </div>
        <div class="mb-3">
            <label>KKM</label>
            <input type="text" name="kkm" class="form-control" value="{{ $mapels->kkm }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('mapel.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
