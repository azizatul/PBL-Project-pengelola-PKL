@extends('layouts.app')

@section('content')

{{-- Mengubah warna fokus input menjadi biru --}}
<style>
    .form-control:focus {
        border-color: #007bff !important; 
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.4) !important;
    }
</style>

{{-- Mengubah tulisan SIM-PKL pada navbar menjadi biru --}}
<style>
    nav .navbar-brand {
        font-weight: bold;
        font-size: 20px;
        color: #007bff !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let brand = document.querySelector("nav .navbar-brand");
        if (brand) {
            brand.textContent = "SIM-PKL";
        }
    });
</script>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                {{-- Header sudah biru --}}
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Program Studi</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('prodi.update', $prodi) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                            <input id="nama_prodi" type="text" 
                                   class="form-control @error('nama_prodi') is-invalid @enderror" 
                                   name="nama_prodi" 
                                   value="{{ old('nama_prodi', $prodi->nama_prodi) }}" 
                                   required autofocus
                                   placeholder="Masukkan nama program studi">
                            @error('nama_prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea id="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" rows="4"
                                      placeholder="Masukkan deskripsi program studi">{{ old('deskripsi', $prodi->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input id="photo" type="file" 
                                   class="form-control @error('photo') is-invalid @enderror" 
                                   name="photo" accept="image/*">
                            <div class="form-text">Pilih file baru jika ingin mengubah (maksimal 2MB).</div>

                            @if($prodi->photo)
                                <div class="mt-2">
                                    <label class="form-label">Photo Saat Ini:</label><br>
                                    <img src="{{ asset('storage/' . $prodi->photo) }}" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif

                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prodi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>

                            {{-- Tombol update warna biru --}}
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
