@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Jadwal Bimbingan</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $bimbingan->topik ?? 'Bimbingan Akademik' }}</h5>
            <p class="card-text">
                <strong>Mahasiswa:</strong> {{ $bimbingan->mahasiswa->nama }}<br>
                <strong>Dosen:</strong> {{ $bimbingan->dosen->nama }}<br>
                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($bimbingan->tanggal)->format('d M Y') }}<br>
                <strong>Waktu:</strong> {{ $bimbingan->waktu_mulai }} - {{ $bimbingan->waktu_selesai }}<br>
                @if($bimbingan->catatan)
                    <strong>Catatan:</strong> {{ $bimbingan->catatan }}<br>
                @endif
            </p>
            <a href="{{ route('bimbingan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
