@extends('layouts.app')

@section('content')

{{-- Mengubah warna fokus input menjadi kuning --}}
<style>
    .form-control:focus {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.4) !important;
    }

    /* Warna brand navbar */
    nav .navbar-brand {
        font-weight: bold;
        font-size: 20px;
        color: #ffc107 !important;
    }
</style>

{{-- Ganti tulisan Laravel menjadi SIM-PKL --}}
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
                <div class="card-header bg-warning text-dark">
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
                                   required autofocus>
                            @error('nama_prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea id="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" rows="4">{{ old('deskripsi', $prodi->deskripsi) }}</textarea>
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
                                    <label class="form-label">Foto Saat Ini:</label><br>
                                    <img src="{{ asset('storage/' . $prodi->photo) }}" alt="Foto {{ $prodi->nama_prodi }}" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prodi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
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
