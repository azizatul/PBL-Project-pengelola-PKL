<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Data Mahasiswa</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Data Mahasiswa</h1>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Prodi</th>
                    <th>Angkatan</th>
                    <th>Photo</th>
                    <th>Aksi</th> </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswas as $item)
                <tr>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->nama_mahasiswa }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->telepon }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->prodi ? $item->prodi->nama_prodi : 'N/A' }}</td>
                    <td>{{ $item->angkatan }}</td>
                    <td>{{ $item->status_validasi }}</td>
                    <td>{{ $item->bimbingan_count }}</td>
                    <td>{{ $item->seminar_progress }}</td>
                    <td>{{ $item->attendance_percentage }}</td>
                    <td>{{ $item->photo ? 'Ada' : 'Tidak Ada' }}</td>
                    <td>
                        <a href="{{ route('mahasiswa.show', $item->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('mahasiswa.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('mahasiswa.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>