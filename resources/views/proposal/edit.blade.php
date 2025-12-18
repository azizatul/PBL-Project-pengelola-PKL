@extends('layouts.app')

@section('title', 'Edit Proposal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Proposal</h3>
                    <div class="card-tools">
                        <a href="{{ route('proposal.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('proposal.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="judul">Judul Proposal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                   id="judul" name="judul" value="{{ old('judul', $proposal->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Proposal</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $proposal->deskripsi) }}</textarea>
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
                                    <option value="{{ $mahasiswa->id }}" {{ old('mahasiswa_id', $proposal->mahasiswa_id) == $mahasiswa->id ? 'selected' : '' }}>
                                        {{ $mahasiswa->nama_mahasiswa }} ({{ $mahasiswa->nim }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mahasiswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="pending" {{ old('status', $proposal->status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ old('status', $proposal->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ old('status', $proposal->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="komentar">Komentar</label>
                            <textarea class="form-control @error('komentar') is-invalid @enderror"
                                      id="komentar" name="komentar" rows="3" placeholder="Tambahkan komentar untuk mahasiswa...">{{ old('komentar', $proposal->komentar) }}</textarea>
                            @error('komentar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file">File Proposal Baru (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                       id="file" name="file" accept=".pdf,.doc,.docx">
                                <label class="custom-file-label" for="file">Pilih file baru...</label>
                            </div>
                            <small class="form-text text-muted">
                                File saat ini: <strong>{{ $proposal->file_name }}</strong><br>
                                Format yang didukung: PDF, DOC, DOCX. Maksimal ukuran file: 10MB<br>
                                Biarkan kosong jika tidak ingin mengubah file.
                            </small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
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
    $(this).next('.custom-file-label').html(fileName || 'Pilih file baru...');
});
</script>
@endsection
