@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Nilai PKL</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Mahasiswa</th>
                            <td>: {{ $nilai->mahasiswa->nama_mahasiswa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>NIM</th>
                            <td>: {{ $nilai->mahasiswa->nim ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Akhir</th>
                            <td class="fw-bold fs-5 text-primary">: {{ $nilai->nilai }}</td>
                        </tr>
                        <tr>
                            <th>Semester</th>
                            <td>: {{ $nilai->semester }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <td>: {{ $nilai->tahun_ajaran }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: {{ strtoupper($nilai->kategori) }}</td>
                        </tr>
                        <tr>
                            <th>Dosen Pembimbing</th>
                            <td>: {{ $nilai->dosen }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>: {{ $nilai->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('nilai.edit', $nilai->id) }}" class="btn btn-warning text-white">Edit Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection