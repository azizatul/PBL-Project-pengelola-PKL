@extends('layouts.app')

@section('content')
<style>
    /* Styling Dasar Halaman */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        margin: 20px;
    }

    /* Judul Halaman */
    h2 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-weight: 600;
    }

    /* Tombol Tambah Bimbingan (Warna Biru Utama) */
    .btn-tambah {
        display: inline-block;
        background-color: #007bff; /* Biru Utama */
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-bottom: 20px;
        transition: background 0.3s;
    }

    .btn-tambah:hover {
        background-color: #0056b3; /* Biru lebih gelap saat hover */
    }

    /* Styling Tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* Efek bayangan */
        border-radius: 8px;
        overflow: hidden;
    }

    /* Header Tabel (Warna Biru) */
    th {
        background-color: #007bff; /* Header Biru */
        color: white;
        padding: 15px;
        text-align: left;
    }

    /* Isi Tabel */
    td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        color: #333;
    }

    /* Efek Zebra pada Baris (Ganjil/Genap) */
    tr:nth-child(even) {
        background-color: #f8fbff; /* Biru sangat muda */
    }

    tr:hover {
        background-color: #e2e6ea;
    }

    /* Kolom Aksi (Tombol Kecil) */
    .action-links a, .action-links button {
        margin-right: 5px;
        text-decoration: none;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    /* Tombol View & Edit (Biru Muda & Kuning/Hijau) */
    .btn-view {
        background-color: #17a2b8;
        color: white;
    }

    .btn-edit {
        background-color: #ffc107;
        color: black;
    }

    /* Tombol Hapus (Merah) - Agar kontras */
    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    /* Status Styles */
    .status {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status.pending {
        background-color: #ffc107;
        color: #212529;
    }

    .status.approved {
        background-color: #28a745;
        color: white;
    }

    .status.rejected {
        background-color: #dc3545;
        color: white;
    }

    /* Validation Buttons */
    .btn-approve, .btn-reject {
        margin-right: 5px;
        text-decoration: none;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    /* Container untuk menengahkan (Opsional) */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
    }
</style>

<div class="container">
    <h2>Daftar Jadwal Bimbingan</h2>
    <a href="{{ route('bimbingan.create') }}" class="btn-tambah">Tambah Bimbingan</a>

    @if($bimbingans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Mahasiswa</th>
                    <th>Dosen</th>
                    <th>Topik</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bimbingans as $bimbingan)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($bimbingan->tanggal)->format('d M Y') }}</td>
                        <td>{{ $bimbingan->waktu_mulai }}</td>
                        <td>{{ $bimbingan->waktu_selesai }}</td>
                        <td>{{ $bimbingan->mahasiswa->nama_mahasiswa }}</td>
                        <td>{{ $bimbingan->dosen->nama_dosen }}</td>
                        <td>{{ $bimbingan->topik ?: 'Tidak ada topik' }}</td>
                        <td>{{ $bimbingan->catatan ?: 'Tidak ada catatan' }}</td>
                        <td>
                            <span class="status {{ $bimbingan->status ?: 'pending' }}">
                                {{ $bimbingan->status ?: 'Pending' }}
                            </span>
                        </td>
                        <td class="action-links">
                            <a href="{{ route('bimbingan.show', $bimbingan) }}" class="btn-view">Lihat</a>
                            @if(Auth::check() && Auth::user()->role == 'dosen')
                                @if($bimbingan->status != 'approved' && $bimbingan->status != 'rejected')
                                    <form action="{{ route('bimbingan.validate', $bimbingan) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn-approve" style="background-color: #28a745; color: white;">Setujui</button>
                                    </form>
                                    <form action="{{ route('bimbingan.validate', $bimbingan) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn-reject" style="background-color: #dc3545; color: white;">Tolak</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('bimbingan.edit', $bimbingan) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('bimbingan.destroy', $bimbingan) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal bimbingan ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada jadwal bimbingan.</p>
    @endif
</div>
@endsection
