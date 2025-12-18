@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Seminar</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('seminar.update', $seminar) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $seminar->tanggal) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="waktu">Waktu</label>
                    <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu', $seminar->waktu) }}" required>
                    @error('waktu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $seminar->lokasi) }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="topik">Topik</label>
                    <input type="text" class="form-control @error('topik') is-invalid @enderror" id="topik" name="topik" value="{{ old('topik', $seminar->topik) }}" required>
                    @error('topik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $seminar->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if(in_array(Auth::user()->role, ['kaprodi', 'dosen']))
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="pending" {{ old('status', $seminar->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $seminar->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $seminar->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('seminar.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
