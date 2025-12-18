@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Mitra</h3>
                    <a href="{{ route('mitra.index') }}" class="btn btn-secondary float-right">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($mitra->logo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/logos/' . $mitra->logo) }}" alt="Logo {{ $mitra->nama_perusahaan }}" style="max-width: 200px; max-height: 200px;">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Nama Perusahaan:</th>
                                    <td>{{ $mitra->nama_perusahaan }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat:</th>
                                    <td>{{ $mitra->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi:</th>
                                    <td>{{ $mitra->provinsi ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon:</th>
                                    <td>{{ $mitra->telepon }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $mitra->email }}</td>
                                </tr>
                                <tr>
                                    <th>Jurusan:</th>
                                    <td>{{ $mitra->jurusan ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('mitra.edit', $mitra) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('mitra.destroy', $mitra) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
