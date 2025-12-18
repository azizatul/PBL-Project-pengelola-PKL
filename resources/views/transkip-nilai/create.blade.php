@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header py-3 bg-white">
                    <h4 class="mb-0 text-dark">Upload Transkip Nilai</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('transkip-nilai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nim" class="form-label fw-bold">NIM Mahasiswa</label>
                            <input type="text" name="nim" id="nim" class="form-control" placeholder="Masukkan NIM" required>
                            <div class="form-text">NIM diperlukan untuk identifikasi mahasiswa</div>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">File Transkip Nilai (PDF)</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
                            <div class="form-text">Maksimal 10MB, format PDF</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                            <a href="{{ route('transkip-nilai.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
