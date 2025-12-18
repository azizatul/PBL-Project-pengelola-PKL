@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Buat Seminar Baru</h1>

    <div class="card">
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('seminar.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="waktu">Waktu</label>
                    <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu') }}" required>
                    @error('waktu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="topik">Topik</label>
                    <input type="text" class="form-control @error('topik') is-invalid @enderror" id="topik" name="topik" value="{{ old('topik') }}" required>
                    @error('topik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if(isset($mahasiswas) && $mahasiswas)
                    <div class="form-group">
                        <label for="mahasiswa_id">Mahasiswa</label>
                        <select name="mahasiswa_id" id="mahasiswa_id" class="form-control @error('mahasiswa_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach($mahasiswas as $m)
                                <option value="{{ $m->id }}" {{ old('mahasiswa_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mahasiswa }} ({{ $m->nim ?? '' }})</option>
                            @endforeach
                        </select>
                        @error('mahasiswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @elseif(Auth::check() && Auth::user()->role === 'mahasiswa' && Auth::user()->mahasiswa)
                    <input type="hidden" name="mahasiswa_id" value="{{ Auth::user()->mahasiswa->id }}">
                @endif

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('seminar.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
