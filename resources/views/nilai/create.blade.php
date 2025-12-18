@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-primary text-white">
            Input Nilai PKL Baru
        </div>
        <div class="card-body">
            <form action="{{ route('nilai.store') }}" method="POST">
                @csrf
                
                {{-- Pilih Mahasiswa --}}
                <div class="mb-3">
                    <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-control select2" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswas as $mhs)
                            <option value="{{ $mhs->id }}">{{ $mhs->nim }} - {{ $mhs->nama_mahasiswa }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    {{-- Input Nilai --}}
                    <div class="col-md-6 mb-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <input type="number" step="0.01" name="nilai" class="form-control" placeholder="Contoh: 90.00" required>
                    </div>

                    {{-- Input Semester --}}
                    <div class="col-md-6 mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="number" name="semester" class="form-control" value="5" required>
                    </div>
                </div>

                <div class="row">
                    {{-- Input Tahun Ajaran --}}
                    <div class="col-md-6 mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" value="{{ date('Y') }}" required>
                    </div>

                    {{-- Input Kategori --}}
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="pkl">PKL</option>
                            <option value="magang">Magang</option>
                            <option value="proyek">Proyek</option>
                        </select>
                    </div>
                </div>

                {{-- Input Dosen --}}
                <div class="mb-3">
                    <label for="dosen_id" class="form-label">Dosen Pembimbing</label>
                    <select name="dosen_id" class="form-control select2" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach(\App\Models\Dosen::all() as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->nama_dosen }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection