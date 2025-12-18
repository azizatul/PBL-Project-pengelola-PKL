<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Transkrip</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Transkrip Nilai</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('transkrip.update', $transkrip->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if(auth()->check() && auth()->user()->role === 'mahasiswa')
                        <input type="hidden" name="mahasiswa_id" value="{{ $transkrip->mahasiswa_id }}">
                    @else
                        <div class="mb-3">
                            <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                                <option value="">Pilih Mahasiswa</option>
                                @foreach($mahasiswas as $mahasiswa)
                                    <option value="{{ $mahasiswa->id }}" {{ $mahasiswa->id == $transkrip->mahasiswa_id ? 'selected' : '' }}>
                                        {{ $mahasiswa->nim }} - {{ $mahasiswa->nama_mahasiswa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="file" class="form-label">File PDF Transkrip (Opsional)</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".pdf">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah file. File saat ini: {{ $transkrip->original_filename }}</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('transkrip.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
