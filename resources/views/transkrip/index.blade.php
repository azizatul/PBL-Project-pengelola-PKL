@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-dark">Transkrip Nilai</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            @if(auth()->check() && (auth()->user()->role === 'mahasiswa' || auth()->user()->role === 'admin' || auth()->user()->role === 'kaprodi'))
                <a href="{{ route('transkrip.create') }}" class="btn btn-primary btn-sm">+ Upload File</a>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>File</th>
                            <th>Status</th>
                            <th>Terpilih</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transkrips as $transkrip)
                        <tr>
                            <td>{{ $transkrip->mahasiswa->nim ?? '-' }}</td>
                            <td>{{ $transkrip->mahasiswa->nama_mahasiswa ?? '-' }}</td>
                            <td>
                                @if($transkrip->file_path)
                                    <a href="{{ route('transkrip.download', $transkrip->id) }}" class="text-decoration-none" target="_blank">Lihat File</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($transkrip->status === 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($transkrip->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ $transkrip->is_selected ? 'Ya' : '-' }}</td>
                            <td>
                                <a href="{{ route('transkrip.show', $transkrip->id) }}" class="btn btn-sm btn-info text-white">Detail</a>

                                @if(auth()->check() && auth()->user()->role === 'mahasiswa')
                                    <a href="{{ route('transkrip.edit', $transkrip->id) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <form action="{{ route('transkrip.destroy', $transkrip->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @elseif(auth()->check() && (auth()->user()->role === 'kaprodi' || auth()->user()->role === 'admin'))
                                    <form action="{{ route('transkrip.approve', $transkrip->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                    </form>
                                    <form action="{{ route('transkrip.reject', $transkrip->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Tolak</button>
                                    </form>
                                    <form action="{{ route('transkrip.destroy', $transkrip->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
