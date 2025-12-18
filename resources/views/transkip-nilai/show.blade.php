@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10"> {{-- Lebar card diperbesar agar PDF enak dilihat --}}
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-file-alt me-2"></i>Detail & Preview Transkrip
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Bagian Kiri: Detail Informasi --}}
                        <div class="col-md-4 border-end">
                            <h6 class="fw-bold text-muted mb-3">Informasi Mahasiswa</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted small">Nama Mahasiswa</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ $transkip->mahasiswa->nama_mahasiswa ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted small mt-2">NIM</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ $transkip->mahasiswa->nim ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted small mt-2">Status Validasi</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if($transkip->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($transkip->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <hr>
                            
                            {{-- Tombol Aksi --}}
                            <div class="d-grid gap-2">
                                <a href="{{ route('transkip-nilai.download', $transkip->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                                <a href="{{ route('transkip-nilai.index') }}" class="btn btn-secondary btn-sm">
                                    Kembali ke Daftar
                                </a>
                            </div>
                        </div>

                        {{-- Bagian Kanan: Preview PDF --}}
                        <div class="col-md-8">
                            <h6 class="fw-bold text-muted mb-3">Preview Dokumen: {{ $transkip->original_filename }}</h6>
                            
                            <div class="border rounded bg-light d-flex align-items-center justify-content-center" style="height: 600px; overflow: hidden;">
                                {{-- IFRAME UNTUK MENAMPILKAN PDF --}}
                                {{-- Pastikan 'file_path' sesuai dengan nama kolom di database Anda --}}
                                <iframe 
                                    src="{{ asset('storage/transkrips/' . $transkip->file_path) }}" 
                                    width="100%" 
                                    height="100%" 
                                    style="border: none;"
                                >
                                    <p class="text-center p-4">
                                        Browser Anda tidak mendukung preview PDF.<br>
                                        Silakan <a href="{{ route('transkip-nilai.download', $transkip->id) }}">Download File</a> untuk melihatnya.
                                    </p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection