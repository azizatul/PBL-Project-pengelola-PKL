@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Nilai PKL</h2>
        <a href="{{ route('nilai.create') }}" class="btn btn-primary">+ Tambah Data Baru</a>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-blue">
                        <tr>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Nilai</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($nilais as $nilai)
                        <tr>
                            <td>{{ $nilai->mahasiswa->nim ?? '-' }}</td>
                            <td>{{ $nilai->mahasiswa->nama_mahasiswa ?? '-' }}</td>
                            <td>{{ $nilai->nilai }}</td>
                            <td>{{ $nilai->semester }}</td>
                            <td>{{ $nilai->tahun_ajaran }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ strtoupper($nilai->kategori) }}</span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('nilai.destroy', $nilai->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    {{-- Tombol Lihat --}}
                                    <a href="{{ route('nilai.show', $nilai->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('nilai.edit', $nilai->id) }}" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    @csrf
                                    @method('DELETE')
                                    
                                    {{-- Tombol Hapus --}}
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data nilai yang tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection