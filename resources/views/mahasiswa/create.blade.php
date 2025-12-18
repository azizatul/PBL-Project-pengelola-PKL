@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Mahasiswa</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}" required>
        </div>
        <div class="form-group">
            <label for="nama_mahasiswa">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat') }}</textarea>
        </div>
        <div class="form-group">
            <label for="telepon">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon') }}">
        </div>
        <div class="form-group">
            <label for="angkatan">Angkatan</label>
            <input type="text" class="form-control" id="angkatan" name="angkatan" value="{{ old('angkatan') }}" required>
        </div>
        <div class="form-group">
            <label for="prodi_id">Prodi</label>
            <select class="form-control" id="prodi_id" name="prodi_id" required>
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
