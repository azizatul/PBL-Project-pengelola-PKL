@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Mitra</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('mitra.update', $mitra) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_perusahaan">Nama Perusahaan</label>
                            <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan', $mitra->nama_perusahaan) }}" required>
                            @error('nama_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $mitra->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <input type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" value="{{ old('provinsi', $mitra->provinsi) }}">
                            @error('provinsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $mitra->telepon) }}" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $mitra->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <select class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan">
                                <option value="">Pilih Jurusan</option>
                                <option value="Teknik Informatika" {{ old('jurusan', $mitra->jurusan) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="Teknik Mesin" {{ old('jurusan', $mitra->jurusan) == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                <option value="Akuntansi" {{ old('jurusan', $mitra->jurusan) == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                                <option value="Agribisnis" {{ old('jurusan', $mitra->jurusan) == 'Agribisnis' ? 'selected' : '' }}>Agribisnis</option>
                                <option value="Teknologi Rekayasa Komputer Jaringan" {{ old('jurusan', $mitra->jurusan) == 'Teknologi Rekayasa Komputer Jaringan' ? 'selected' : '' }}>Teknologi Rekayasa Komputer Jaringan</option>
                                <option value="Rekayasa Pemeliharaan Alat Berat" {{ old('jurusan', $mitra->jurusan) == 'Rekayasa Pemeliharaan Alat Berat' ? 'selected' : '' }}>Rekayasa Pemeliharaan Alat Berat</option>
                                <option value="Teknologi Otomotif" {{ old('jurusan', $mitra->jurusan) == 'Teknologi Otomotif' ? 'selected' : '' }}>Teknologi Otomotif</option>
                                <option value="Teknologi Rekayasa Jalan Jembatan" {{ old('jurusan', $mitra->jurusan) == 'Teknologi Rekayasa Jalan Jembatan' ? 'selected' : '' }}>Teknologi Rekayasa Jalan Jembatan</option>
                                <option value="Teknologi Pakan Ternak" {{ old('jurusan', $mitra->jurusan) == 'Teknologi Pakan Ternak' ? 'selected' : '' }}>Teknologi Pakan Ternak</option>
                                <option value="Akuntansi Perpajakan" {{ old('jurusan', $mitra->jurusan) == 'Akuntansi Perpajakan' ? 'selected' : '' }}>Akuntansi Perpajakan</option>
                            </select>
                            @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            @if($mitra->logo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/logos/' . $mitra->logo) }}" alt="Logo" style="max-width: 100px; max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah logo.</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('mitra.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
