@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Seminar</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('seminar.create') }}" class="btn btn-primary mb-3">Buat Seminar Baru</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Topik</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seminars as $seminar)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($seminar->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $seminar->waktu }}</td>
                            <td>{{ $seminar->lokasi }}</td>
                            <td>{{ $seminar->topik }}</td>
                            <td>
                                @if($seminar->status === 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($seminar->status === 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('seminar.show', $seminar) }}" class="btn btn-sm btn-info">Lihat</a>
                                <a href="{{ route('seminar.edit', $seminar) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('seminar.destroy', $seminar) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus seminar ini?')">Hapus</button>
                                </form>
                                @if($seminar->status === 'pending')
                                    <form action="{{ route('seminar.validate', $seminar) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                    </form>
                                    <form action="{{ route('seminar.validate', $seminar) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada seminar ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
