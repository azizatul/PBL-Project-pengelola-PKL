<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POLITEKNIK NEGERI TANAH LAUT - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variabel CSS */
        :root {
            --primary-blue: #0d6efd;
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
            background-color: var(--light-bg);
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
            height: 40px; /* Ukuran logo */
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
            background-color: #0b5ed7;
        }

        /* Hero Section */
        .hero-section {
            background-color: var(--primary-blue);
            color: var(--white-bg);
            text-align: center;
            padding: 80px 20px;
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
            font-size: 2.8rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .hero-content p {
            font-size: 1.15rem;
            line-height: 1.5;
            opacity: 0.9;
        }

        /* Section Title & Description */
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-header h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .section-header p {
            font-size: 1rem;
            color: var(--grey-text);
        }

        /* Program Studi Section */
        .program-studi-section {
            background-color: var(--white-bg);
            padding: 60px 0;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .program-card {
            background-color: var(--white-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .program-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid var(--border-color);
        }

        .program-card-content {
            padding: 20px;
            flex-grow: 1;
        }

        .program-card-content h3 {
            font-size: 1.25rem;
            margin-top: 0;
            margin-bottom: 10px;
            color: var(--dark-text);
        }

        .program-card-content p {
            font-size: 0.9rem;
            color: var(--grey-text);
            margin-bottom: 0;
        }

        /* Section Postingan */
        .posts-section {
            padding: 60px 0;
        }

        .post-form, .post-list {
            background-color: var(--white-bg);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .post-form h2, .post-list h2 {
            margin-top: 0;
        }

        .post-form input,
        .post-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        .post-form button {
            background-color: var(--primary-blue);
            color: var(--white-bg);
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .post-form button:hover {
            background-color: #0b5ed7;
        }

        .post-item {
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .post-item:last-child {
            border-bottom: none;
        }

        .post-item h3 { margin-top: 0; }
        .post-item a, .post-item button { text-decoration: none; font-weight: 500; }
        .post-item a { color: var(--primary-blue); margin-right: 15px; }
        .post-item form { display: inline; }
        .post-item button {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            font-size: 1em;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
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
            .hero-section { padding: 60px 20px; }
            .hero-content h1 { font-size: 2rem; }
            .section-header h2 { font-size: 1.8rem; }
            .program-grid { grid-template-columns: 1fr; }
            .footer-content { grid-template-columns: 1fr; text-align: center; }
        }

        @media (max-width: 480px) {
            .logo-section span { font-size: 1rem; }
            .hero-content h1 { font-size: 1.8rem; }
            .hero-content p { font-size: 0.9rem; }
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
                        <li><a href="{{route('home')}}" class="active">Beranda</a></li>
                        <li><a href="{{route('perusahaan.index')}}">Perusahaan</a></li>
                        <li><a href="{{route('login')}}">Login</a></li>
                        <li><a href="{{route('register')}}"">Register</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1>Membentuk Masa Depan Melalui Inovasi Pendidikan</h1>
                <p>Bergabunglah dengan Politeknik Negeri Tanah Laut dan jadilah pemimpin masa depan di era teknologi digital</p>
            </div>
        </section>

        <section class="program-studi-section">
            <div class="container">
                <div class="section-header">
                    <h2>Program Studi Unggulan</h2>
                    <p>Jelajahi berbagai program studi yang kami tawarkan.</p>
                </div>

                @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                    {{ session('success') }}
                </div>
                @endif

                @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="post-form" style="margin-bottom: 30px;">
                    <h3>Tambah Program Studi Baru</h3>
                    <form action="{{ route('home.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="nama_prodi" placeholder="Nama Program Studi" required>
                        <textarea name="deskripsi" placeholder="Deskripsi Program Studi"></textarea>
                        <input type="file" name="photo" accept="image/*" required>
                        <button type="submit">Tambah Prodi</button>
                    </form>
                </div>
                @endif

                <div class="program-grid">
                    @forelse($prodis as $prodi)
                    <div class="program-card">
                        <img src="{{ $prodi->photo ? asset('storage/' . $prodi->photo) : asset('logo.png') }}" alt="{{ $prodi->nama_prodi }}">
                        <div class="program-card-content">
                            <h3>{{ $prodi->nama_prodi }}</h3>
                            <p>{{ $prodi->deskripsi ?? 'Deskripsi program studi belum tersedia.' }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-center">Tidak ada data program studi</p>
                    </div>
                    @endforelse
                </div>
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

</body>
</html>
