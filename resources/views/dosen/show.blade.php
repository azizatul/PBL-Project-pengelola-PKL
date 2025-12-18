@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Detail Dosen Pembimbing</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($dosen->photo)
                                <img src="{{ asset('storage/' . $dosen->photo) }}" alt="Photo" class="img-fluid rounded-circle mb-3" style="max-width: 200px; max-height: 200px;">
                            @else
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 200px; height: 200px;">
                                    <i class="fas fa-user fa-4x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">ID</th>
                                    <td>: {{ $dosen->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Dosen</th>
                                    <td>: {{ $dosen->nama_dosen }}</td>
                                </tr>
                                <tr>
                                    <th>NIP</th>
                                    <td>: {{ $dosen->nip }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>: {{ $dosen->email }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: {{ $dosen->alamat ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>: {{ $dosen->telepon ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>: {{ $dosen->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diupdate</th>
                                    <td>: {{ $dosen->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('dosen.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('dosen.edit', $dosen) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('dosen.destroy', $dosen) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus dosen ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
