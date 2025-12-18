@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- 1. BAGIAN HEADER (BIRU) --}}
    <div class="bg-primary text-white rounded-4 p-5 text-center mb-4 shadow-sm">
        <div class="mb-3">
            {{-- Icon User Besar --}}
            <i class="fas fa-user-circle fa-6x"></i>
        </div>
        <h2 class="fw-bold">Dr. Ahmad</h2>
        <p class="fs-5 mb-0">Dosen Pembimbing PKL</p>
    </div>

    {{-- 2. BAGIAN KONTEN UTAMA (3 KOLOM) --}}
    <div class="row">

        {{-- KOLOM KIRI: Form Informasi Pribadi --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4 text-primary">
                        <i class="fas fa-user-circle me-2"></i>Informasi Pribadi
                    </h5>

                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label text-muted small">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Dr. Ahmad" name="nama">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Email</label>
                            <input type="email" class="form-control" value="ahmad@example.com" name="email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">No. Telepon</label>
                            <input type="text" class="form-control" placeholder="Masukkan No Telp" name="telepon">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Foto Profil</label>
                            <input type="file" class="form-control" name="photo">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">NIP</label>
                            <input type="text" class="form-control" value="1234567890" name="nip" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small">Program Studi</label>
                            <input type="text" class="form-control" value="Teknik Akuntansi" name="prodi">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM TENGAH: Statistik Aktivitas --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4 text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Aktivitas
                    </h5>

                    {{-- Card Biru 1 --}}
                    <div class="card bg-primary text-white text-center mb-3 border-0 py-3">
                        <h2 class="fw-bold mb-0">1</h2>
                        <small>Bimbingan</small>
                    </div>

                    {{-- Card Biru 2 --}}
                    <div class="card bg-primary text-white text-center mb-3 border-0 py-3">
                        <h2 class="fw-bold mb-0">1</h2>
                        <small>Seminar</small>
                    </div>

                    {{-- Card Biru 3 --}}
                    <div class="card bg-primary text-white text-center border-0 py-3">
                        <h2 class="fw-bold mb-0">0</h2>
                        <small>Penilaian</small>
                    </div>

                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Aktivitas Terbaru --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4 text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>Aktivitas Terbaru
                    </h5>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="text-muted">Bimbingan Terakhir</span>
                            <span class="fw-bold">2025-10-30</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="text-muted">Seminar Terakhir</span>
                            <span class="fw-bold">2025-10-28</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="text-muted">Penilaian Terakhir</span>
                            <span class="text-muted fst-italic">Belum ada</span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- 3. BAGIAN FOOTER --}}
{{-- Biasanya bagian ini diletakkan di layouts/app.blade.php, tapi ini kodenya agar sesuai gambar --}}
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
