<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Detail Transkrip Nilai</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Detail Transkrip Nilai</h1>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>NIM:</h5>
                        <p>{{ $transkrip->mahasiswa->nim }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Nama Mahasiswa:</h5>
                        <p>{{ $transkrip->mahasiswa->nama_mahasiswa }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5>File:</h5>
                        <p>{{ $transkrip->original_filename }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Status:</h5>
                        <span class="badge bg-{{ $transkrip->status === 'approved' ? 'success' : ($transkrip->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($transkrip->status) }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5>Terpilih:</h5>
                        <span class="badge bg-{{ $transkrip->is_selected ? 'success' : 'secondary' }}">
                            {{ $transkrip->is_selected ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('transkrip.download', $transkrip->id) }}" class="btn btn-success">Download</a>
                    <a href="{{ route('transkrip.print', $transkrip->id) }}" class="btn btn-warning" target="_blank">Cetak</a>
                    <a href="{{ route('transkrip.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
