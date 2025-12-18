<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Informasi PKL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url(Gedung.jpg); /* Pastikan file gambar ada */
      background-size: cover;
      background-position: center;
      display: flex; justify-content: center; align-items: center;
      min-height: 100vh; padding: 20px;
      font-weight: bold;
    }
    .login-container {
      width: 100%; max-width: 450px;
      background: #fff; border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.1);
      overflow: hidden; margin-bottom: 60px;
    }
    .login-header {
      background: #1a73e8; color: white;
      padding: 25px; text-align: center;
    }
    .login-header img {
      width: 80px; height: auto; display: block; margin: 0 auto 10px;
    }
    .login-header h1 { font-size: 24px; margin: 0; }
    .login-header p { font-size: 14px; margin-top: 5px; }

    .form-content { padding: 30px; }
    .form-section { display: none; }
    .form-section.active { display: block; animation: fadeIn 0.5s ease; }
    @keyframes fadeIn { from {opacity:0;transform:translateY(10px);} to {opacity:1;transform:translateY(0);} }

    .input-group { margin-bottom: 20px; position: relative; }
    .input-group label { display: block; font-size: 14px; margin-bottom: 8px; }
    .input-group input {
      width: 100%; padding: 12px 15px 12px 40px;
      border: 1px solid #ddd; border-radius: 8px;
      font-size: 15px; transition: border-color 0.3s;
    }
    .input-group input:focus { border-color:#1a73e8; box-shadow:0 0 0 2px rgba(26,115,232,0.2); outline:none; }
    .input-icon { position:absolute; left:15px; top:42px; color:#888; }

    .btn {
      display:block; width:100%;
      background:#1a73e8; color:white; border:none;
      padding:14px; border-radius:8px; font-size:16px;
      cursor:pointer; text-align:center; text-decoration:none;
    }
    .btn:hover { background:#155ab6; }

    .extra-links { text-align:center; margin-top:20px; font-size:14px; }
    .extra-links a { color:#1a73e8; text-decoration:none; }
    .extra-links a:hover { text-decoration:underline; }

    footer {
      position:absolute; bottom:0; left:0; right:0;
      padding:20px; text-align:center;
      color:rgba(255,255,255,0.85); font-size:14px;
    }

    /* Dropdown styling */
    .select-role {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 15px;
      font-family: 'Poppins', sans-serif;
    }

    /* Social login button styles */
    .social-login {
      text-align: center;
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid #eee; /* Garis pemisah tipis */
    }
    .social-login a.btn-google {
      background: #fff;
      color: #3c4043;
      padding: 12px 24px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 500;
      display: flex; /* Menggunakan Flexbox agar ikon dan teks rata tengah */
      align-items: center;
      justify-content: center;
      border: 1px solid #dadce0;
      font-size: 14px;
      transition: background-color 0.2s, box-shadow 0.2s;
      width: 100%; /* Agar tombol selebar form */
    }
    .social-login a.btn-google:hover {
      background: #f8f9fa;
      box-shadow: 0 1px 3px rgba(60,64,67,.30), 0 4px 8px 3px rgba(60,64,67,.15);
    }
    .social-login a.btn-google svg {
      margin-right: 10px;
      width: 18px;
      height: 18px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
      <h1>Sistem Informasi PKL</h1>
      <p>Politeknik Negeri Tanah Laut</p>
    </div>

    <div class="form-content">
      @if(session('success'))
        <div style="padding: 12px; background: #d1e7dd; color: #0f5132; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #198754;">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div style="padding: 12px; background: #f8d7da; color: #842029; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
          <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
      @endif

      <select class="select-role" onchange="showForm(this.value)">
        <option value="mahasiswa">Mahasiswa</option>
        <option value="kaprodi">Kaprodi</option>
        <option value="dosen">Dosen</option>
        <option value="admin">Admin</option>
        <option value="perusahaan">Perusahaan</option>
      </select>

      <div id="mahasiswa-form" class="form-section active">
        <form action="{{ route('login.mahasiswa') }}" method="POST">
          @csrf
          <div class="input-group">
            <label for="nim">NIM</label>
            <i class="fas fa-user input-icon"></i>
            <input type="text" name="nim" id="nim" value="{{ old('nim') }}" placeholder="Masukkan NIM Anda" required>
          </div>
          <div class="input-group">
            <label for="password">Password</label>
            <i class="fas fa-lock input-icon"></i>
            <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
          </div>
          <button type="submit" class="btn">Login Mahasiswa</button>
        </form>
      </div>

      <div id="dosen-form" class="form-section">
        <form onsubmit="event.preventDefault(); window.location.href='dashdosen';">
          <div class="input-group">
            <label for="nip">NIP / Email</label>
            <i class="fas fa-user-tie input-icon"></i>
            <input type="text" id="nip" placeholder="Masukkan NIP atau Email" required>
          </div>
          <div class="input-group">
            <label for="password-dosen">Password</label>
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password-dosen" placeholder="Masukkan Password" required>
          </div>
          <button type="submit" class="btn">Login Dosen</button>
        </form>
      </div>
      
      <div id="kaprodi-form" class="form-section">
        <form onsubmit="event.preventDefault(); window.location.href='dashkaprodi';">
          <div class="input-group">
            <label for="email-kaprodi">Email Kaprodi</label>
            <i class="fas fa-chalkboard-teacher input-icon"></i>
            <input type="email" id="email-kaprodi" placeholder="Masukkan Email Kaprodi" required>
          </div>
          <div class="input-group">
            <label for="password-kaprodi">Password</label>
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password-kaprodi" placeholder="Masukkan Password" required>
          </div>
          <button type="submit" class="btn">Login Kaprodi</button>
        </form>
      </div>

      <div id="admin-form" class="form-section">
        <form onsubmit="event.preventDefault(); window.location.href='dashadmin';">
          <div class="input-group">
            <label for="username">Username</label>
            <i class="fas fa-user-shield input-icon"></i>
            <input type="text" id="username" placeholder="Masukkan Username Admin" required>
          </div>
          <div class="input-group">
            <label for="password-admin">Password</label>
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password-admin" placeholder="Masukkan Password" required>
          </div>
          <button type="submit" class="btn">Login Admin</button>
        </form>
      </div>

      <div id="perusahaan-form" class="form-section">
        <form onsubmit="event.preventDefault(); window.location.href='mitra';">
          <div class="input-group">
            <label for="email-perusahaan">Email Perusahaan</label>
            <i class="fas fa-building input-icon"></i>
            <input type="email" id="email-perusahaan" placeholder="Masukkan Email Perusahaan" required>
          </div>
          <div class="input-group">
            <label for="password-perusahaan">Password</label>
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password-perusahaan" placeholder="Masukkan Password" required>
          </div>
          <button type="submit" class="btn">Login Perusahaan</button>
        </form>
      </div>

      <div class="social-login">
        <a href="{{ route('google.login') }}" class="btn-google">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
          </svg>
          Masuk dengan Google
        </a>
      </div>
      <div class="extra-links">
        <a href="#">Lupa Password?</a>
        <span style="margin: 0 10px; color: #ddd;">|</span>
        <a href="{{ route('register') }}">Register</a>
      </div>

    </div>
  </div>

  <footer>
    <p>&copy; 2025 Politeknik Negeri Tanah Laut</p>
  </footer>

  <script>
    function showForm(formId) {
      const sections = document.querySelectorAll('.form-section');
      sections.forEach(s => s.classList.remove('active'));
      
      // Mengambil elemen form berdasarkan ID yang dipilih
      const selectedForm = document.getElementById(formId + '-form');
      if (selectedForm) {
        selectedForm.classList.add('active');
      }
    }
  </script>
</body>
</html>