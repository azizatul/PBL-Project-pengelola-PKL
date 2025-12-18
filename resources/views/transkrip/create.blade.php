@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                <div class="card-header">Upload Transkrip Nilai</div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="/templates/template_transkrip.pdf" class="btn btn-info" download>Download Template Transkrip PDF</a>
                        <small class="form-text text-muted">Download template untuk format transkrip yang benar.</small>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('transkrip.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(auth()->check() && auth()->user()->role === 'mahasiswa')
                            @php
                                $mahasiswa = \App\Models\Mahasiswa::where('user_id', auth()->id())->first();
                            @endphp
                            <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id }}">
                        @else
                            <div class="form-group">
                                <label for="mahasiswa_id">Mahasiswa</label>
                                <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach($mahasiswas as $mahasiswa)
                                        <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->nama_mahasiswa }} - {{ $mahasiswa->nim }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="file">File Transkrip (PDF)</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
                            <small class="form-text text-muted">Maksimal 10MB</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <a href="{{ route('transkrip.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
