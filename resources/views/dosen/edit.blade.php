@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                {{-- PERUBAHAN DI SINI: bg-warning diganti menjadi bg-primary (Biru) --}}
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Dosen Pembimbing</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('dosen.update', $dosen) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_dosen" class="form-label">Nama Dosen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" name="nama_dosen" value="{{ old('nama_dosen', $dosen->nama_dosen) }}" required>
                            @error('nama_dosen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $dosen->nip) }}" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $dosen->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $dosen->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $dosen->telepon) }}">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload foto dosen baru jika ingin mengganti (maksimal 2MB, format: JPEG, PNG, JPG, GIF)</div>
                            
                            @if($dosen->photo)
                                <div class="mt-3 p-2 border rounded bg-light d-inline-block">
                                    <p class="mb-1 text-muted small">Foto saat ini:</p>
                                    {{-- Saya tambahkan object-fit cover agar tampilan preview juga rapi --}}
                                    <img src="{{ asset('storage/' . $dosen->photo) }}" alt="Current Photo" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            @endif
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dosen.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection