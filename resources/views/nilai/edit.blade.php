@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-warning text-dark">
            Edit Nilai PKL
        </div>
        <div class="card-body">
            <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Edit Mahasiswa --}}
                <div class="mb-3">
                    <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-control" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswas as $mhs)
                            <option value="{{ $mhs->id }}" {{ $nilai->mahasiswa_id == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->nim }} - {{ $mhs->nama_mahasiswa }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    {{-- Edit Nilai --}}
                    <div class="col-md-6 mb-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <input type="number" step="0.01" name="nilai" value="{{ $nilai->nilai }}" class="form-control" required>
                    </div>

                    {{-- Edit Semester --}}
                    <div class="col-md-6 mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="number" name="semester" value="{{ $nilai->semester }}" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    {{-- Edit Tahun Ajaran --}}
                    <div class="col-md-6 mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" value="{{ $nilai->tahun_ajaran }}" class="form-control" required>
                    </div>

                    {{-- Edit Kategori --}}
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="pkl" {{ $nilai->kategori == 'pkl' ? 'selected' : '' }}>PKL</option>
                            <option value="magang" {{ $nilai->kategori == 'magang' ? 'selected' : '' }}>Magang</option>
                            <option value="proyek" {{ $nilai->kategori == 'proyek' ? 'selected' : '' }}>Proyek</option>
                        </select>
                    </div>
                </div>

                {{-- Edit Dosen --}}
                <div class="mb-3">
                    <label for="dosen_id" class="form-label">Dosen Pembimbing</label>
                    <select name="dosen_id" class="form-control" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ $nilai->dosen_id == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->nama_dosen }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection