@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama kamu --}}

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        {{-- Header Card --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-people-fill me-2"></i>Daftar Dosen Pembimbing
            </h5>
            <a href="{{ route('dosen.create') }}" class="btn btn-light btn-sm fw-bold">
                + Tambah Dosen
            </a>
        </div>

        {{-- Body Card --}}
        <div class="card-body">
            
            {{-- Pesan Sukses (Opsional) --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 5%;">No</th> <th>Nama Dosen</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th style="width: 10%;">Photo</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dosens as $dosen)
                        <tr>
                            {{-- 1. Nomor Urut --}}
                            <td class="text-center">{{ $loop->iteration }}</td>

                            {{-- 2. Nama Dosen (PASTIKAN nama kolom di database benar, misal: 'nama', 'nama_dosen', atau 'name') --}}
                            <td class="fw-bold">{{ $dosen->nama_dosen ?? $dosen->nama ?? 'Nama Tidak Ada' }}</td>

                            {{-- 3. NIP --}}
                            <td>{{ $dosen->nip }}</td>

                            {{-- 4. Email --}}
                            <td>{{ $dosen->email }}</td>

                            {{-- 5. Telepon --}}
                            <td>{{ $dosen->telepon }}</td>

                            {{-- 6. Photo dengan Perbaikan CSS --}}
                            <td class="text-center">
                                @if($dosen->photo)
                                    {{-- Menggunakan object-fit agar foto tidak gepeng --}}
                                    <img src="{{ asset('storage/' . $dosen->photo) }}" 
                                         alt="Foto {{ $dosen->nama_dosen }}" 
                                         class="rounded" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="badge bg-secondary">No Photo</span>
                                @endif
                            </td>

                            {{-- 7. Tombol Aksi yang Sejajar --}}
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- Tombol Lihat --}}
                                    <a href="{{ route('dosen.show', $dosen->id) }}" class="btn btn-info btn-sm text-white" title="Lihat">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    {{-- Tombol Hapus (Wajib pakai Form untuk keamanan) --}}
                                    <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Data dosen belum tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination (Jika pakai paginate di controller) --}}
            <div class="mt-3">
                {{-- {{ $dosens->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection