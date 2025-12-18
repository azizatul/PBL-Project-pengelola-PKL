@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Seminar</h2>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        @if(auth()->check() && auth()->user()->role !== 'dosen')
            <a href="{{ route('seminar.create') }}" class="btn btn-primary me-2">Tambah Seminar</a>
        @endif
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seminars as $seminar)
                <tr>
                    <td>{{ $seminar->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($seminar->date)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($seminar->time)->format('H:i') }}</td>
                    <td>{{ $seminar->location }}</td>
                    <td>
                        @php
                            $statusText = ucfirst($seminar->status);
                            $statusClass = 'text-secondary';
                            if ($seminar->status === 'pending') {
                                $statusClass = 'text-warning';
                                $statusText = 'Pending';
                            } elseif ($seminar->status === 'approved') {
                                $statusClass = 'text-success';
                                $statusText = 'Approved';
                            } elseif ($seminar->status === 'rejected') {
                                $statusClass = 'text-danger';
                                $statusText = 'Rejected';
                            }
                        @endphp
                        <span class="{{ $statusClass }}" aria-label="Status">{{ $statusText }}</span>
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="{{ route('seminar.show', $seminar) }}" class="btn btn-success btn-sm">View</a>
                            @if(auth()->check() && auth()->user()->role !== 'dosen')
                                <a href="{{ route('seminar.edit', $seminar) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('seminar.destroy', $seminar) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seminar ini?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endif
                            @if(auth()->check() && auth()->user()->role === 'dosen' && $seminar->status === 'pending')
                                <form action="{{ route('seminar.validate', $seminar) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('seminar.validate', $seminar) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No seminars found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

