@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Jadwal Bimbingan</h2>

    <form action="{{ route('bimbingan.update', $bimbingan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="mahasiswa_id">Mahasiswa</label>
            <select id="mahasiswa_id" name="mahasiswa_id" class="form-control" required>
                <option value="">Pilih Mahasiswa</option>
                @foreach($mahasiswas as $mahasiswa)
                    <option value="{{ $mahasiswa->id }}" {{ $bimbingan->mahasiswa_id == $mahasiswa->id ? 'selected' : '' }}>{{ $mahasiswa->nama_mahasiswa }} ({{ $mahasiswa->nim }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="dosen_id">Dosen</label>
            <select id="dosen_id" name="dosen_id" class="form-control" required>
                <option value="">Pilih Dosen</option>
                @foreach($dosens as $dosen)
                    <option value="{{ $dosen->id }}" {{ $bimbingan->dosen_id == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama_dosen }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ $bimbingan->tanggal }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="waktu_mulai">Waktu Mulai</label>
            <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ $bimbingan->waktu_mulai }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="waktu_selesai">Waktu Selesai</label>
            <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ $bimbingan->waktu_selesai }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="topik">Topik</label>
            <input type="text" id="topik" name="topik" value="{{ $bimbingan->topik }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea id="catatan" name="catatan" class="form-control">{{ $bimbingan->catatan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('bimbingan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
