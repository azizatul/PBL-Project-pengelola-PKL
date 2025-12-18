@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Mahasiswa</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $mahasiswa->nama_mahasiswa }}</h5>
            <p class="card-text"><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $mahasiswa->email }}</p>
            <p class="card-text"><strong>Alamat:</strong> {{ $mahasiswa->alamat ?: 'Tidak ada' }}</p>
            <p class="card-text"><strong>Telepon:</strong> {{ $mahasiswa->telepon ?: 'Tidak ada' }}</p>
            <p class="card-text"><strong>Angkatan:</strong> {{ $mahasiswa->angkatan }}</p>
            <p class="card-text"><strong>Prodi:</strong> {{ $mahasiswa->prodi->nama_prodi }}</p>
            @if($mahasiswa->photo)
                <p class="card-text"><strong>Photo:</strong></p>
                <img src="{{ asset('storage/' . $mahasiswa->photo) }}" alt="Photo" width="200">
            @else
                <p class="card-text"><strong>Photo:</strong> Tidak ada</p>
            @endif
        </div>
    </div>
    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
