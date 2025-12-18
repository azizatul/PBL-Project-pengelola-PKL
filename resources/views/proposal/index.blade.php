@extends('layouts.app')

@section('title', 'Kelola Proposal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kelola Proposal Mahasiswa</h3>
                    <div class="card-tools">
                        <a href="{{ route('proposal.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Proposal
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fas fa-check"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fas fa-ban"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Proposal</th>
                                    <th>Mahasiswa</th>
                                    <th>Status</th>
                                    <th>Komentar</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proposals as $index => $proposal)
                                    <tr>
                                        <td>{{ $proposals->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $proposal->judul }}</strong>
                                        </td>
                                        <td>
                                            @if($proposal->mahasiswa)
                                                {{ $proposal->mahasiswa->nama_mahasiswa }}<br>
                                                <small class="text-muted">{{ $proposal->mahasiswa->nim }}</small>
                                            @else
                                                <span class="text-muted">Tidak ada data mahasiswa</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($proposal->status == 'pending')
                                                <span class="badge badge-lg" style="background-color: #000000; color: #ffffff;">Menunggu</span>
                                            @elseif($proposal->status == 'approved')
                                                <span class="badge badge-lg" style="background-color: #000000; color: #ffffff;">Disetujui</span>
                                            @else
                                                <span class="badge badge-lg" style="background-color: #000000; color: #ffffff;">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($proposal->komentar)
                                                <small>{{ Str::limit($proposal->komentar, 50) }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($proposal->deskripsi)
                                                <small>{{ Str::limit($proposal->deskripsi, 50) }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $proposal->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('proposal.show', $proposal->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @auth
                                                    @if(!in_array(auth()->user()->role, ['dosen', 'kaprodi', 'perusahaan']))
                                                        <!-- Mahasiswa can only view -->
                                                    @else
                                                        <a href="{{ route('proposal.edit', $proposal->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('proposal.destroy', $proposal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proposal ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                                <a href="{{ route('proposal.download', $proposal->id) }}" class="btn btn-sm btn-secondary" title="Download File" target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Belum ada proposal yang diupload</p>
                                                <a href="{{ route('proposal.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Upload Proposal Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($proposals->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $proposals->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
