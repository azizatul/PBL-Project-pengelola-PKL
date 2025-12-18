@extends('layouts.app')

@section('content')
{{-- CSS KHUSUS TAMPILAN MINIMALIS --}}
<style>
    /* Card & Layout */
    .card-minimal {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background-color: #fff;
    }
    .card-header-minimal {
        background-color: transparent;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem;
        font-weight: 700;
        color: #333;
    }

    /* Form Elements */
    .form-control-minimal {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
    }
    .form-control-minimal:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    /* Table Styling */
    .table-minimal th {
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        color: #8898aa;
        border-bottom: 2px solid #f0f0f0;
        padding: 1rem;
        font-weight: 600;
    }
    .table-minimal td {
        vertical-align: middle;
        padding: 1rem;
        border-bottom: 1px solid #f8f9fa;
        color: #525f7f;
    }
    .table-hover tbody tr:hover {
        background-color: #fcfcfc;
    }

    /* Action Buttons (Icon Only) */
    .btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        transition: all 0.2s ease;
        color: #adb5bd;
        margin: 0 2px;
        text-decoration: none; /* Hilangkan garis bawah link */
    }
    .btn-icon:hover {
        background-color: #f0f0f0;
        transform: translateY(-2px);
    }
    .btn-icon.view { color: #11cdef; background-color: rgba(17, 205, 239, 0.1); }
    .btn-icon.view:hover { background-color: #11cdef; color: white; }
    
    .btn-icon.edit { color: #fb6340; background-color: rgba(251, 99, 64, 0.1); }
    .btn-icon.edit:hover { background-color: #fb6340; color: white; }

    .btn-icon.delete { color: #f5365c; background-color: rgba(245, 54, 92, 0.1); }
    .btn-icon.delete:hover { background-color: #f5365c; color: white; }

    /* Badges */
    .badge-soft {
        padding: 0.5em 0.8em;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-soft-warning { background-color: #fff3cd; color: #856404; }
    .badge-soft-success { background-color: #d4edda; color: #155724; }
    .badge-soft-danger { background-color: #f8d7da; color: #721c24; }
</style>

<div class="container mt-5">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
    {{-- BAGIAN 1: FORM UPLOAD (Hanya untuk mahasiswa) --}}
    @if(Auth::check() && Auth::user()->role === 'mahasiswa')
    <div class="card card-minimal mb-5">
        <div class="card-header-minimal">
            <i class="fas fa-cloud-upload-alt me-2 text-primary"></i> Upload Transkrip Baru
        </div>
        <div class="card-body p-4">
            <form action="{{ route('transkip-nilai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4 align-items-end">
                    {{-- INPUT NIM --}}
                    <div class="col-md-5">
                        <label class="form-label text-muted small fw-bold mb-1">NIM MAHASISWA</label>
                        <input type="text" name="nim" class="form-control form-control-minimal" placeholder="Contoh: 2401301095" required>
                    </div>

                    {{-- INPUT NAMA DIHAPUS (Biar sistem otomatis cari sendiri) --}}

                    {{-- INPUT FILE --}}
                    <div class="col-md-5">
                        <label class="form-label text-muted small fw-bold mb-1">FILE TRANSKRIP (PDF)</label>
                        <input type="file" name="file" class="form-control form-control-minimal" accept="application/pdf" required>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px; padding: 0.6rem;">
                            Upload
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- BAGIAN 2: DAFTAR DATA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-dark fw-bold m-0">Daftar Transkrip</h4>
        <span class="text-muted small">Total Data: {{ $transkipNilais->count() }}</span>
    </div>

    <div class="card card-minimal">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-minimal mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Mahasiswa</th>
                            <th>File Upload</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                   <tbody>
    @forelse($transkipNilais as $data)
    <tr>
        {{-- Kolom Mahasiswa --}}
        <td class="ps-4">
            <div class="fw-bold text-dark">{{ $data->mahasiswa->nama_mahasiswa ?? '-' }}</div>
            <div class="small text-muted">{{ $data->mahasiswa->nim ?? '-' }}</div>
        </td>

        {{-- Kolom File --}}
        <td>
            <div class="d-flex align-items-center text-muted">
                <i class="far fa-file-pdf me-2 fs-5 text-danger"></i>
                <span class="text-truncate" style="max-width: 200px;">{{ $data->original_filename }}</span>
            </div>
        </td>

        {{-- Kolom Status --}}
        <td>
            @if($data->status == 'approved')
                <span class="badge badge-soft badge-soft-success">Disetujui</span>
            @elseif($data->status == 'rejected')
                <span class="badge badge-soft badge-soft-danger">Ditolak</span>
            @else
                <span class="badge badge-soft badge-soft-warning">Pending</span>
            @endif
        </td>

        {{-- Kolom Tanggal (OTOMATIS SESUAI WAKTU UPLOAD) --}}
        <td class="text-muted small">
            {{-- created_at adalah bawaan Laravel yang mencatat waktu upload otomatis --}}
            {{ $data->created_at->format('d M Y, H:i') }} WIB
        </td>

        {{-- KOLOM AKSI --}}
        <td class="text-end pe-4">
            <div class="d-flex justify-content-end gap-1">

                {{-- 1. Tombol LIHAT --}}
                <a href="{{ route('transkip-nilai.show', $data->id) }}" class="btn-icon view" title="Lihat Detail">
                    <i class="fas fa-eye"></i>
                </a>

                {{-- 2. Tombol EDIT dan HAPUS (Hanya untuk mahasiswa pemilik) --}}
                @if(Auth::check() && Auth::user()->role === 'mahasiswa' && $data->mahasiswa->user_id == Auth::user()->id)
                    {{-- Tombol EDIT --}}
                    <a href="{{ route('transkip-nilai.edit', $data->id) }}" class="btn-icon edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    {{-- Tombol HAPUS --}}
                    <form action="{{ route('transkip-nilai.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transkip nilai ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon delete" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                @endif

                {{-- 3. Tombol SETUJUI dan TOLAK (Hanya untuk kaprodi) --}}
                @if(Auth::check() && Auth::user()->role === 'kaprodi')
                    {{-- Tombol SETUJUI --}}
                    <form action="{{ route('transkip-nilai.update-status', $data->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn-icon text-success" title="Setujui">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    {{-- Tombol TOLAK --}}
                    <form action="{{ route('transkip-nilai.update-status', $data->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn-icon text-danger" title="Tolak">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                @endif

                {{-- 4. Tombol HAPUS (Hanya untuk admin) --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <form action="{{ route('transkip-nilai.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon delete" title="Hapus Data">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                @endif
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center py-5">
            <p class="text-muted mb-0">Belum ada data transkrip yang diupload.</p>
        </td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection