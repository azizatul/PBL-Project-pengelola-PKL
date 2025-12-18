<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Program Studi - Politala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Mengatur agar footer selalu di bawah */
        .content-wrapper {
            flex: 1;
        }

        /* Styling khusus untuk Footer agar mirip gambar */
        footer {
            background-color: #1f2937; /* Warna biru gelap sesuai gambar */
            color: #e5e7eb;
            font-size: 0.9rem;
        }

        footer h5 {
            font-weight: bold;
            color: white;
            margin-bottom: 1rem;
        }

        .footer-bottom {
            background-color: #111827; /* Warna sedikit lebih gelap untuk copyright */
            font-size: 0.8rem;
            color: #9ca3af;
        }

        /* Styling Tabel */
        .table img {
            max-width: 60px;
            height: auto;
            border-radius: 4px;
        }

        /* Tombol Aksi */
        .btn-aksi {
            font-size: 0.8rem;
            padding: 5px 10px;
            margin-right: 2px;
            color: white;
        }
        
        .btn-lihat { background-color: #0dcaf0; border: none; } /* Cyan */
        .btn-edit { background-color: #ffc107; border: none; color: black; } /* Kuning */
        .btn-hapus { background-color: #dc3545; border: none; } /* Merah */

        /* Agar card ada jarak dari atas */
        .main-card {
            margin-top: 30px;
            margin-bottom: 50px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
        }
        
        .card-header {
            background-color: white;
            font-weight: bold;
            font-size: 1.25rem;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>

    <div class="container content-wrapper">
        <div class="card main-card">
            <div class="card-header">
                Daftar Program Studi
            </div>
            <div class="card-body p-4">
                <a href="{{ route('prodi.create') }}" class="btn btn-primary mb-4">Tambah Program Studi</a>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 15%;">Foto</th>
                                <th scope="col" style="width: 25%;">Nama Program Studi</th>
                                <th scope="col" style="width: 35%;">Deskripsi</th>
                                <th scope="col" style="width: 25%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prodis as $prodi)
                            <tr>
                                <td>
                                    @if($prodi->photo)
                                        <img src="{{ asset('storage/' . $prodi->photo) }}" alt="Foto {{ $prodi->nama_prodi }}">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td>{{ $prodi->nama_prodi }}</td>
                                <td>{{ $prodi->deskripsi ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('prodi.show', $prodi) }}" class="btn btn-aksi btn-lihat">Lihat</a>
                                    <a href="{{ route('prodi.edit', $prodi) }}" class="btn btn-aksi btn-edit">Edit</a>
                                    <form action="{{ route('prodi.destroy', $prodi) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-aksi btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data program studi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>