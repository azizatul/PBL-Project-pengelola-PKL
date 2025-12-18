
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Perusahaan PKL - Politeknik Negeri Tanah Laut</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variabel CSS */
        :root {
            --primary-blue: #0d6efd;
            --dark-blue: #0b5ed7;
            --light-blue: #e3f2fd;
            --dark-text: #333;
            --light-bg: #f8f9fa;
            --white-bg: #fff;
            --border-color: #e0e0e0;
            --grey-text: #6c757d;
        }

        /* Reset & Base */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-blue);
            color: var(--dark-text);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header (Navigasi Atas) */
        header {
            background-color: var(--white-bg);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-section img {
            height: 40px;
            width: auto;
        }

        .logo-section span {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-blue);
            white-space: nowrap;
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 25px;
        }

        header nav ul li a {
            text-decoration: none;
            color: var(--dark-text);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        header nav ul li a:hover,
        header nav ul li a.active {
            color: var(--primary-blue);
        }

        header nav ul li .login-btn {
            background-color: var(--primary-blue);
            color: var(--white-bg);
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        header nav ul li .login-btn:hover {
            background-color: var(--dark-blue);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: var(--white-bg);
            text-align: center;
            padding: 60px 20px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            transform: rotate(-30deg);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .hero-content p {
            font-size: 1.1rem;
            line-height: 1.5;
            opacity: 0.9;
        }

        /* Filter Section */
        .filter-section {
            background-color: var(--white-bg);
            padding: 30px 0;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .filter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .filter-container label {
            font-weight: 600;
            color: var(--dark-text);
            font-size: 1rem;
        }

        .filter-container select {
            padding: 10px 15px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--white-bg);
            transition: border-color 0.3s ease;
        }

        .filter-container select:focus {
            outline: none;
            border-color: var(--primary-blue);
        }

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .search-container input {
            padding: 10px 15px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--white-bg);
            transition: border-color 0.3s ease;
            min-width: 300px;
        }

        .search-container input:focus {
            outline: none;
            border-color: var(--primary-blue);
        }

        /* Perusahaan Grid */
        .perusahaan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        .perusahaan-card {
            background-color: var(--white-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .perusahaan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .perusahaan-logo {
            width: 100%;
            height: 180px;
            object-fit: contain;
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--primary-blue) 100%);
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .no-logo {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--primary-blue) 100%);
            color: var(--primary-blue);
            font-style: italic;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
        }

        .perusahaan-content {
            padding: 20px;
            flex-grow: 1;
        }

        .perusahaan-content h3 {
            font-size: 1.3rem;
            margin-top: 0;
            margin-bottom: 10px;
            color: var(--dark-text);
            font-weight: 600;
        }

        .perusahaan-content p {
            font-size: 0.9rem;
            color: var(--grey-text);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .perusahaan-content p strong {
            color: var(--primary-blue);
            font-weight: 600;
        }

        .perusahaan-stats {
            background-color: var(--light-blue);
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
            border: 1px solid rgba(13, 110, 253, 0.2);
        }

        .perusahaan-stats p {
            margin: 0;
            font-weight: 600;
            color: var(--primary-blue);
        }

        /* Footer */
        footer {
            background-color: #0d47A1;
            color: var(--white-bg);
            padding: 40px 0 20px 0;
            margin-top: 40px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        footer h4 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: var(--white-bg);
        }

        footer p {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-content h1 { font-size: 2.2rem; }
            .hero-content p { font-size: 1rem; }
        }

        @media (max-width: 768px) {
            .navbar { flex-direction: column; align-items: flex-start; gap: 15px; }
            header nav ul { flex-wrap: wrap; justify-content: center; gap: 10px 15px; width: 100%; }
            header nav ul li .login-btn { width: 100%; text-align: center; }
            .hero-section { padding: 50px 20px; }
            .hero-content h1 { font-size: 2rem; }
            .filter-container { flex-direction: column; gap: 15px; }
            .perusahaan-grid { grid-template-columns: 1fr; }
            .footer-content { grid-template-columns: 1fr; text-align: center; }
        }

        @media (max-width: 480px) {
            .logo-section span { font-size: 1rem; }
            .hero-content h1 { font-size: 1.8rem; }
            .hero-content p { font-size: 0.9rem; }
        }

        /* Hide cards based on filter */
        .perusahaan-card.hidden {
            display: none;
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <div class="navbar">
                <div class="logo-section">
                    <img src="{{ asset('logo.png') }}" alt="Logo Politala">
                    <span>SIM-PKL</span>
                </div>
                <nav>
                    <ul>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('perusahaan.index') }}" class="active">Perusahaan</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1>Daftar Perusahaan Mitra PKL</h1>
                <p>Jelajahi perusahaan-perusahaan yang bekerja sama dengan Politeknik Negeri Tanah Laut untuk program Praktik Kerja Lapangan</p>
            </div>
        </section>

        <section class="filter-section">
            <div class="container">
                <div class="search-container">
                    <label for="search-perusahaan">Cari Perusahaan:</label>
                    <input type="text" id="search-perusahaan" placeholder="Ketik nama perusahaan...">
                </div>
            </div>
        </section>

        <section class="perusahaan-section">
            <div class="container">
                <div class="perusahaan-grid" id="perusahaan-grid">
                    @foreach ($mitras as $mitra)
                    <div class="perusahaan-card" data-jurusan="{{ $mitra->jurusan ?? 'all' }}">
                        @if ($mitra->logo)
                            <img src="{{ asset('storage/logos/' . $mitra->logo) }}" alt="Logo {{ $mitra->nama_perusahaan }}" class="perusahaan-logo" />
                        @else
                            <div class="no-logo">
                                <div style="font-size: 3rem; opacity: 0.7;">🏢</div>
                                <div style="margin-top: 10px;">{{ $mitra->nama_perusahaan }}</div>
                            </div>
                        @endif
                        <div class="perusahaan-content">
                            <h3>{{ $mitra->nama_perusahaan }}</h3>
                            <p><strong>📍 Alamat:</strong> {{ $mitra->alamat }}{{$mitra->provinsi ? ', ' . $mitra->provinsi : ''}}</p>
                            <p><strong>📞 Telepon:</strong> {{ $mitra->telepon }}</p>
                            <p><strong>📧 Email:</strong> {{ $mitra->email }}</p>
                            @if($mitra->jurusan)
                                <p><strong>🎓 Jurusan:</strong> {{ $mitra->jurusan }}</p>
                            @endif
                            <div class="perusahaan-stats">
                                <p><strong>👥 Mahasiswa Diterima:</strong> {{ $mitra->mahasiswas->where('status_pkl', 'Diterima')->count() }} mahasiswa</p>
                                <p><strong>👥 Mahasiswa Lulus:</strong> {{ $mitra->mahasiswas->where('status_pkl', 'Lulus')->count() }} mahasiswa</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Static Company Cards -->
                    <div class="perusahaan-card" data-jurusan="tm">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">🏭</div>
                            <div style="margin-top: 10px;">PT. Arutmin Indonesia</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>PT. Arutmin Indonesia</h3>
                            <p><strong>🏢 Sektor:</strong> Pertambangan Batubara</p>
                            <p><strong>📍 Alamat:</strong> Kintap & Asam-asam, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Teknik Mesin, Teknik Mesin Alat Berat</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★★★</p>
                            </div>
                        </div>
                    </div>

                    <div class="perusahaan-card" data-jurusan="tm ag">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">🌾</div>
                            <div style="margin-top: 10px;">PT. Kintap Jaya Watindo</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>PT. Kintap Jaya Watindo</h3>
                            <p><strong>🏢 Sektor:</strong> Perkebunan & Industri</p>
                            <p><strong>📍 Alamat:</strong> Kintap, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Teknik Mesin, Agribisnis</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★★☆</p>
                            </div>
                        </div>
                    </div>

                    <div class="perusahaan-card" data-jurusan="tm">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">⛏️</div>
                            <div style="margin-top: 10px;">PT. Jorong Barutama Greston (JBG)</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>PT. Jorong Barutama Greston (JBG)</h3>
                            <p><strong>🏢 Sektor:</strong> Pertambangan</p>
                            <p><strong>📍 Alamat:</strong> Jorong, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Teknik Mesin Alat Berat</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★★★</p>
                            </div>
                        </div>
                    </div>

                    <div class="perusahaan-card" data-jurusan="ag tm">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">🌾</div>
                            <div style="margin-top: 10px;">PT. CJ Cheiljedang Feed Kalimantan</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>PT. CJ Cheiljedang Feed Kalimantan</h3>
                            <p><strong>🏢 Sektor:</strong> Pakan Ternak</p>
                            <p><strong>📍 Alamat:</strong> Kurau, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Agribisnis, Teknik Mesin</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★★☆</p>
                            </div>
                        </div>
                    </div>

                    <div class="perusahaan-card" data-jurusan="ti">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">💻</div>
                            <div style="margin-top: 10px;">Dinas Komunikasi dan Informatika</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>Dinas Komunikasi dan Informatika</h3>
                            <p><strong>🏢 Sektor:</strong> Pemerintahan</p>
                            <p><strong>📍 Alamat:</strong> Pelaihari, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Teknik Informatika</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★☆☆</p>
                            </div>
                        </div>
                    </div>

                    <div class="perusahaan-card" data-jurusan="ak">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">🏛️</div>
                            <div style="margin-top: 10px;">BPKAD Kab. Tanah Laut</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>BPKAD Kab. Tanah Laut</h3>
                            <p><strong>🏢 Sektor:</strong> Pemerintahan</p>
                            <p><strong>📍 Alamat:</strong> Pelaihari, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Akuntansi</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★★☆</p>
                            </div>
                        </div>
                    </div>

                    <div class="perusahaan-card" data-jurusan="tm ak">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">🏭</div>
                            <div style="margin-top: 10px;">PT. Sinar Nusantara Industries</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>PT. Sinar Nusantara Industries</h3>
                            <p><strong>🏢 Sektor:</strong> Manufaktur</p>
                            <p><strong>📍 Alamat:</strong> Pelaihari, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Teknik Mesin, Akuntansi</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★☆☆</p>
                            </div>
                        </div>
                    </div>

                    <div class="perusahaan-card" data-jurusan="ag">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">🌱</div>
                            <div style="margin-top: 10px;">Dinas Tanaman Pangan dan Hortikultura</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>Dinas Tanaman Pangan dan Hortikultura</h3>
                            <p><strong>🏢 Sektor:</strong> Pemerintahan</p>
                            <p><strong>📍 Alamat:</strong> Pelaihari, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Agribisnis</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★★☆</p>
                            </div>
                        </div>
                    </div>

                    <div class="perusahaan-card" data-jurusan="ak ad">
                        <div class="no-logo">
                            <div style="font-size: 3rem; opacity: 0.7;">🏦</div>
                            <div style="margin-top: 10px;">Bank Pembangunan Daerah (BPD) Kalsel</div>
                        </div>
                        <div class="perusahaan-content">
                            <h3>Bank Pembangunan Daerah (BPD) Kalsel</h3>
                            <p><strong>🏢 Sektor:</strong> Perbankan</p>
                            <p><strong>📍 Alamat:</strong> Pelaihari, Kalimantan Selatan</p>
                            <p><strong>🎓 Jurusan yang Sesuai:</strong> Akuntansi, Administrasi Bisnis</p>
                            <div class="perusahaan-stats">
                                <p><strong>⭐ Rating:</strong> ★★★★☆</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($mitras->isEmpty())
                <div style="text-align: center; padding: 50px; background-color: var(--white-bg); border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <div style="font-size: 4rem; opacity: 0.5; margin-bottom: 20px;">🏢</div>
                    <h3 style="color: var(--grey-text); margin-bottom: 10px;">Belum ada perusahaan mitra</h3>
                    <p style="color: var(--grey-text);">Perusahaan mitra akan segera ditambahkan.</p>
                </div>
                @endif
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div>
                    <h4>POLITALA</h4>
                    <p>Politeknik Negeri Tanah Laut berkomitmen untuk menyediakan pendidikan tinggi berkualitas yang relevan dengan kebutuhan industri dan masyarakat.</p>
                </div>
                <div>
                    <h4>Alamat</h4>
                    <p>Jl. Ahmad Yani No.Km.06, Pemuda, Pelaihari, Kabupaten Tanah Laut, Kalimantan Selatan</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Politeknik Negeri Tanah Laut. Semua Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('search-perusahaan').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.perusahaan-card');

            cards.forEach(card => {
                const companyName = card.querySelector('h3').textContent.toLowerCase();
                if (companyName.includes(searchTerm)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    </script>

</body>
</html>
