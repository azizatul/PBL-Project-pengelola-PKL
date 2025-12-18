@extends('layouts.app')

@section('title', 'Upload Proposal Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Upload Proposal Baru</h3>
                    <div class="card-tools">
                        <a href="{{ route('proposal.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="judul">Judul Proposal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                   id="judul" name="judul" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Proposal</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mahasiswa_id">Mahasiswa <span class="text-danger">*</span></label>
                            <select class="form-control @error('mahasiswa_id') is-invalid @enderror"
                                    id="mahasiswa_id" name="mahasiswa_id" required>
                                <option value="">Pilih Mahasiswa</option>
                                @foreach($mahasiswas as $mahasiswa)
                                    <option value="{{ $mahasiswa->id }}" {{ old('mahasiswa_id') == $mahasiswa->id ? 'selected' : '' }}>
                                        {{ $mahasiswa->nama_mahasiswa }} ({{ $mahasiswa->nim }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mahasiswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file">File Proposal <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                       id="file" name="file" accept=".pdf,.doc,.docx" required>
                                <label class="custom-file-label" for="file">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">
                                Format yang didukung: PDF, DOC, DOCX. Maksimal ukuran file: 10MB
                            </small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload Proposal
                            </button>
                            <a href="{{ route('proposal.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Update file input label when file is selected
$('#file').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').html(fileName || 'Pilih file...');
});
</script>
@endsection
