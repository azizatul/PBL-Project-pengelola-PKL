@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Mahasiswa</h1>
    <form action="{{ route('mahasiswa.update', $mahasiswa) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="{{ $mahasiswa->nim }}" required>
        </div>
        <div class="form-group">
            <label for="nama_mahasiswa">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ $mahasiswa->nama_mahasiswa }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $mahasiswa->email }}" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat">{{ $mahasiswa->alamat }}</textarea>
        </div>
        <div class="form-group">
            <label for="telepon">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $mahasiswa->telepon }}">
        </div>
        <div class="form-group">
            <label for="angkatan">Angkatan</label>
            <input type="text" class="form-control" id="angkatan" name="angkatan" value="{{ $mahasiswa->angkatan }}" required>
        </div>
        <div class="form-group">
            <label for="prodi_id">Prodi</label>
            <select class="form-control" id="prodi_id" name="prodi_id" required>
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ $mahasiswa->prodi_id == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            @if($mahasiswa->photo)
                <img src="{{ asset('storage/' . $mahasiswa->photo) }}" alt="Current Photo" width="100">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
