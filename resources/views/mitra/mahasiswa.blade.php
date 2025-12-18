@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Mahasiswa PKL - {{ $mitra->nama_perusahaan }}</h1>

    @if(!empty($warning))
        <div class="alert alert-warning">{{ $warning }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('mitra.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($mahasiswas->isEmpty())
                <div class="alert alert-info">Belum ada mahasiswa PKL yang terdaftar untuk perusahaan ini.</div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Prodi</th>
                            <th>Angkatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswas as $m)
                            <tr>
                                <td>{{ $m->nim ?? '-' }}</td>
                                <td>{{ $m->nama_mahasiswa ?? '-' }}</td>
                                <td>{{ $m->email ?? '-' }}</td>
                                <td>{{ optional($m->prodi)->nama_prodi ?? '-' }}</td>
                                <td>{{ $m->angkatan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
