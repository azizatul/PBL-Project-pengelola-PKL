@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header py-3 bg-white">
                    <h4 class="mb-0 text-dark">Edit Transkip Nilai</h4>
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

                    <form action="{{ route('transkip-nilai.update', $transkipNilai->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- NIM field only required for mahasiswa --}}
                        @if(auth()->check() && auth()->user()->role === 'mahasiswa')
                        <div class="mb-3">
                            <label for="nim" class="form-label fw-bold">NIM Mahasiswa</label>
                            <input type="text" name="nim" id="nim" class="form-control" value="{{ $transkipNilai->mahasiswa->nim ?? '' }}" required>
                            <div class="form-text">NIM diperlukan untuk verifikasi kepemilikan</div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">File Transkip Nilai (PDF)</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".pdf">
                            <div class="form-text">
                                Biarkan kosong jika tidak ingin mengubah file. Maksimal 10MB, format PDF
                            </div>
                            @if($transkipNilai->original_filename)
                                <div class="mt-2">
                                    <small class="text-muted">File saat ini: {{ $transkipNilai->original_filename }}</small>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
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
