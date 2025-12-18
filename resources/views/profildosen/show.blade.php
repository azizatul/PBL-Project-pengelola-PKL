@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Profil Dosen</h3>
                    <div class="card-tools">
                        <a href="{{ route('profildosen.edit', $dosen) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('profildosen.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($dosen->photo)
                                <img src="{{ asset('storage/' . $dosen->photo) }}" alt="Foto Dosen" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <i class="fas fa-user-circle fa-5x text-secondary mb-3"></i>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Nama Dosen:</th>
                                    <td>{{ $dosen->nama_dosen }}</td>
                                </tr>
                                <tr>
                                    <th>NIP:</th>
                                    <td>{{ $dosen->nip }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $dosen->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon:</th>
                                    <td>{{ $dosen->telepon ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat:</th>
                                    <td>{{ $dosen->alamat ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat:</th>
                                    <td>{{ $dosen->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diupdate:</th>
                                    <td>{{ $dosen->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
