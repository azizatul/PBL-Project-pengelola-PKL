@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Jadwal Bimbingan</h2>

    <form action="{{ route('bimbingan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="mahasiswa_id">Mahasiswa</label>
            <select id="mahasiswa_id" name="mahasiswa_id" class="form-control" required>
                <option value="">Pilih Mahasiswa</option>
                @foreach($mahasiswas as $mahasiswa)
                    <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->nama_mahasiswa }} ({{ $mahasiswa->nim }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="dosen_id">Dosen</label>
            <select id="dosen_id" name="dosen_id" class="form-control" required>
                <option value="">Pilih Dosen</option>
                @foreach($dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->nama_dosen }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="waktu_mulai">Waktu Mulai</label>
            <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="waktu_selesai">Waktu Selesai</label>
            <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan title bimbingan">
        </div>
        <div class="form-group">
            <label for="topik">Topik</label>
            <input type="text" id="topik" name="topik" class="form-control">
        </div>
        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea id="catatan" name="catatan" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Masukkan lokasi bimbingan">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('bimbingan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
