@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Proposal</h3>
                    <div class="card-tools">
                        <a href="{{ route('proposal.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('proposal.edit', $proposal->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('proposal.download', $proposal->id) }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-download"></i> Download File
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Judul Proposal</th>
                                    <td>: {{ $proposal->judul }}</td>
                                </tr>
                                <tr>
                                    <th>Mahasiswa</th>
                                    <td>: {{ $proposal->mahasiswa ? $proposal->mahasiswa->nama_mahasiswa . ' (' . $proposal->mahasiswa->nim . ')' : 'Tidak ada data' }}</td>
                                </tr>
                                <tr>
                                    <th>Dosen Pembimbing</th>
                                    <td>: {{ $proposal->dosen ? $proposal->dosen->nama_dosen : 'Tidak ada data' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>:
                                        @if($proposal->status == 'pending')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($proposal->status == 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Upload</th>
                                    <td>: {{ $proposal->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diubah</th>
                                    <td>: {{ $proposal->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Nama File</th>
                                    <td>: {{ $proposal->file_name }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe File</th>
                                    <td>: {{ strtoupper($proposal->file_type) }}</td>
                                </tr>
                            </table>

                            @if($proposal->deskripsi)
                                <div class="mt-4">
                                    <h5>Deskripsi Proposal</h5>
                                    <div class="border p-3 bg-light rounded">
                                        {{ $proposal->deskripsi }}
                                    </div>
                                </div>
                            @endif

                            @if($proposal->komentar)
                                <div class="mt-4">
                                    <h5>Komentar Dosen</h5>
                                    <div class="border p-3 bg-warning rounded">
                                        {{ $proposal->komentar }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-file-alt"></i> File Proposal
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    @if($proposal->file_type == 'pdf')
                                        <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                    @elseif(in_array($proposal->file_type, ['doc', 'docx']))
                                        <i class="fas fa-file-word fa-4x text-primary mb-3"></i>
                                    @else
                                        <i class="fas fa-file fa-4x text-secondary mb-3"></i>
                                    @endif

                                    <h6>{{ $proposal->file_name }}</h6>
                                    <p class="text-muted small mb-3">
                                        Tipe: {{ strtoupper($proposal->file_type) }}<br>
                                        Upload: {{ $proposal->created_at->format('d/m/Y') }}
                                    </p>

                                    <a href="{{ route('proposal.download', $proposal->id) }}" class="btn btn-primary btn-block" target="_blank">
                                        <i class="fas fa-download"></i> Download File
                                    </a>
                                </div>
                            </div>

                            @if($proposal->status == 'pending')
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-clock"></i>
                                    <strong>Status:</strong> Proposal sedang dalam proses review.
                                </div>
                            @elseif($proposal->status == 'approved')
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle"></i>
                                    <strong>Status:</strong> Proposal telah disetujui.
                                </div>
                            @else
                                <div class="alert alert-danger mt-3">
                                    <i class="fas fa-times-circle"></i>
                                    <strong>Status:</strong> Proposal ditolak.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
