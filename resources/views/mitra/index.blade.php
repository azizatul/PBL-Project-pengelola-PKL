@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Mitra</h3>
                    <a href="{{ route('mitra.create') }}" class="btn btn-primary float-right">Tambah Mitra</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mitras as $mitra)
                                <tr>
                                    <td>{{ $mitra->nama_perusahaan }}</td>
                                    <td>{{ $mitra->alamat }}</td>
                                    <td>{{ $mitra->telepon }}</td>
                                    <td>{{ $mitra->email }}</td>
                                    <td>{{ $mitra->jurusan }}</td>
                                    <td>
                                        <a href="{{ route('mitra.show', $mitra) }}" class="btn btn-info btn-sm">Lihat</a>
                                        <a href="{{ route('mitra.edit', $mitra) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('mitra.destroy', $mitra) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data mitra.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
