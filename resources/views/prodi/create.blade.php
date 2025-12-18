@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Tambah Program Studi</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('prodi.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                            <input id="nama_prodi" type="text" class="form-control @error('nama_prodi') is-invalid @enderror" name="nama_prodi" value="{{ old('nama_prodi') }}" required autofocus placeholder="Masukkan nama program studi">

                            @error('nama_prodi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="4" placeholder="Masukkan deskripsi program studi">{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" accept="image/*">
                            <div class="form-text">Pilih file gambar (JPEG, PNG, JPG, GIF) maksimal 2MB.</div>

                            @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prodi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
