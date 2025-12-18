@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Display success or error messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 1. BAGIAN HEADER (BIRU) --}}
    <div class="bg-primary text-white rounded-4 p-5 text-center mb-4 shadow-sm">
        <div class="mb-3">
            {{-- Icon User Besar --}}
            <i class="fas fa-user-graduate fa-6x"></i>
        </div>
        {{-- Menggunakan variabel data mahasiswa atau placeholder --}}
        <h2 class="fw-bold">Nama Mahasiswa</h2>
        <p class="fs-5 mb-0">Mahasiswa Peserta PKL</p>
    </div>

    {{-- 2. BAGIAN KONTEN UTAMA (3 KOLOM) --}}
    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row">
            {{-- KOLOM KIRI: Form Informasi Pribadi --}}
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4 text-primary">
                            <i class="fas fa-id-card me-2"></i>Data Diri
                        </h5>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nama_mahasiswa ?? '' }}" name="nama_mahasiswa">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">NIM</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nim ?? '' }}" name="nim">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Program Studi</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->prodi->nama_prodi ?? '' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3">{{ $mahasiswa->alamat ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Angkatan</label>
                            <input type="number" class="form-control" value="{{ $mahasiswa->angkatan ?? '' }}" name="angkatan">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Email</label>
                            <input type="email" class="form-control" value="{{ $mahasiswa->email ?? '' }}" name="email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">No. Telepon / WA</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->telepon ?? '' }}" name="telepon">
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small">Foto Profil</label>
                            <input type="file" class="form-control" name="photo">
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM TENGAH: Statistik Mahasiswa --}}
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4 text-primary">
                            <i class="fas fa-chart-pie me-2"></i>Progres PKL
                        </h5>

                        {{-- Card Biru 1: Jumlah Bimbingan --}}
                        <div class="card bg-primary text-white text-center mb-3 border-0 py-3">
                            <div class="mb-2">
                                <input type="number" class="form-control form-control-sm text-center bg-white text-dark fw-bold"
                                       value="{{ $mahasiswa->bimbingan_count ?? 0 }}" name="bimbingan_count" min="0">
                            </div>
                            <small>Kali Bimbingan</small>
                        </div>

                        {{-- Card Biru 2: Progres Seminar --}}
                        <div class="card bg-primary text-white text-center mb-3 border-0 py-3">
                            <div class="mb-2">
                                <input type="number" class="form-control form-control-sm text-center bg-white text-dark fw-bold"
                                       value="{{ $mahasiswa->seminar_progress ?? 0 }}" name="seminar_progress" min="0" max="100">
                            </div>
                            <small>Progres Seminar (%)</small>
                        </div>

                        {{-- Card Biru 3: Kehadiran --}}
                        <div class="card bg-primary text-white text-center border-0 py-3">
                            <div class="mb-2">
                                <input type="number" class="form-control form-control-sm text-center bg-white text-dark fw-bold"
                                       value="{{ $mahasiswa->attendance_percentage ?? 0 }}" name="attendance_percentage" min="0" max="100">
                            </div>
                            <small>Persentase Kehadiran (%)</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="col-12 mb-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold px-5">
                        <i class="fas fa-save me-2"></i>Simpan Semua Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- KOLOM KANAN: Aktivitas Terbaru --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4 text-primary">
                        <i class="fas fa-history me-2"></i>Riwayat Aktivitas
                    </h5>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="text-muted">Bimbingan Terakhir</span>
                            <span class="fw-bold">2025-10-25</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="text-muted">Upload Laporan</span>
                            <span class="badge bg-warning text-dark">Draft</span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- 3. BAGIAN FOOTER --}}
<footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h5 class="fw-bold text-uppercase">Politala</h5>
                <p class="small text-white-50">
                    Politeknik Negeri Tanah Laut berkomitmen untuk menyediakan pendidikan tinggi berkualitas yang relevan dengan kebutuhan industri dan masyarakat.
                </p>
            </div>
            <div class="col-md-6 mb-4">
                <h5 class="fw-bold">Alamat</h5>
                <p class="small text-white-50">
                    Jl. Ahmad Yani No.Km.06, Pemuda, Pelaihari, Kabupaten Tanah Laut, Kalimantan Selatan
                </p>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center small text-white-50">
            &copy; 2025 Politeknik Negeri Tanah Laut. Semua Hak Cipta Dilindungi.
        </div>
    </div>
</footer>

@endsection
