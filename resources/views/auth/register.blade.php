<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar - Sistem Informasi PKL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        

      font-family: 'Poppins', sans-serif;
      background-image: url(Gedung.jpg);
      background-size: cover;
      background-position: center;
      display: flex; justify-content: center; align-items: center;
      min-height: 100vh; padding: 20px;
      font-weight: bold;
    }
    .register-container {
      width: 100%; max-width: 500px;
      background: #fff; border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.1);
      overflow: hidden; margin-bottom: 60px;
    }
    .register-header {
      background: #1a73e8; color: white;
      padding: 25px; text-align: center;
    }
    .register-header img {
      width: 80px; height: auto; display: block; margin: 0 auto 10px;
    }
    .register-header h1 { font-size: 24px; margin: 0; }
    .register-header p { font-size: 14px; margin-top: 5px; }

    .form-content { padding: 30px; }

    .input-group { margin-bottom: 20px; position: relative; }
    .input-group label { display: block; font-size: 14px; margin-bottom: 8px; }
    .input-group input, .input-group select {
      width: 100%; padding: 12px 15px;
      border: 1px solid #ddd; border-radius: 8px;
      font-size: 15px; transition: border-color 0.3s;
      font-family: 'Poppins', sans-serif;
    }
    .input-group input:focus, .input-group select:focus {
      border-color:#1a73e8;
      box-shadow:0 0 0 2px rgba(26,115,232,0.2);
      outline:none;
    }

    .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
    }

    .btn {
      display:block; width:100%;
      background:#1a73e8; color:white; border:none;
      padding:14px; border-radius:8px; font-size:16px;
      cursor:pointer; text-align:center; text-decoration:none;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
    }
    .btn:hover { background:#155ab6; }

    .extra-links { text-align:center; margin-top:20px; font-size:14px; }
    .extra-links a { color:#1a73e8; text-decoration:none; }
    .extra-links a:hover { text-decoration:underline; }

    .text-danger {
      color: #dc3545;
      font-size: 12px;
      margin-top: 5px;
      display: block;
      font-weight: normal;
    }

    .alert {
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
    }
    .alert-success {
      background: #d1e7dd;
      color: #0f5132;
      border: 1px solid #badbcc;
    }
    .alert-danger {
      background: #f8d7da;
      color: #842029;
      border: 1px solid #f5c2c7;
    }

  </style>
</head>
<body>

  <div class="register-container">
    <div class="register-header">
      <img src="{{ asset('Logo.png') }}" alt="Logo">
      <h1>Register</h1>
      <p>Politeknik Negeri Tanah Laut</p>
    </div>

    <div class="form-content">
      @if(session('success'))
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="input-group">
          <label for="role">Role</label>
          <select name="role" id="role" required onchange="toggleFields()">
            <option value="">Pilih Role</option>
            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="kaprodi" {{ old('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
            <option value="perusahaan" {{ old('role') == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
          </select>
          @error('role')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="input-group">
          <label for="name">Nama Lengkap</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}"
                 placeholder="Masukkan nama lengkap" required>
          @error('name')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="input-group">
          <label for="nim">NIM</label>
          <input type="text" name="nim" id="nim" value="{{ old('nim') }}"
                 placeholder="Contoh: A11.2025.0001" required>
          @error('nim')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}"
                 placeholder="mahasiswa@politala.ac.id" required>
          @error('email')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="input-group">
          <label for="program_studi">Program Studi</label>
          <input type="text" name="program_studi" id="program_studi" value="{{ old('program_studi') }}"
                 placeholder="Contoh: Teknik Informatika" required>
          @error('program_studi')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="input-group">
          <label for="phone">Nomor HP</label>
          <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                 placeholder="08xxx" required>
          @error('phone')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <div style="position: relative;">
            <input type="password" name="password" id="password"
                   placeholder="Minimal 8 karakter" required
                   style="padding-right: 45px;">
            <i class="fas fa-eye password-toggle" onclick="togglePassword('password')"></i>
          </div>
          @error('password')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="input-group">
          <label for="password_confirmation">Konfirmasi Password</label>
          <div style="position: relative;">
            <input type="password" name="password_confirmation" id="password_confirmation"
                   placeholder="Ulangi password" required
                   style="padding-right: 45px;">
            <i class="fas fa-eye password-toggle" onclick="togglePassword('password_confirmation')"></i>
          </div>
        </div>

        <button type="submit" class="btn">
          Daftar Sekarang
        </button>
      </form>

      <div class="extra-links">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
      </div>
    </div>
  </div>

  <script>
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      const icon = field.parentElement.querySelector('.password-toggle');

      if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    function toggleFields() {
      const role = document.getElementById('role').value;

      // Hide all conditional fields first
      document.getElementById('nim-group').style.display = 'none';
      document.getElementById('nip-group').style.display = 'none';
      document.getElementById('program-studi-group').style.display = 'none';
      document.getElementById('jurusan-group').style.display = 'none';
      document.getElementById('alamat-group').style.display = 'none';

      // Remove required attribute from all conditional fields
      document.getElementById('nim').removeAttribute('required');
      document.getElementById('nip').removeAttribute('required');
      document.getElementById('program_studi').removeAttribute('required');
      document.getElementById('jurusan').removeAttribute('required');
      document.getElementById('alamat').removeAttribute('required');

      // Show fields based on role
      if (role === 'mahasiswa') {
        document.getElementById('nim-group').style.display = 'block';
        document.getElementById('program-studi-group').style.display = 'block';
        document.getElementById('nim').setAttribute('required', 'required');
        document.getElementById('program_studi').setAttribute('required', 'required');
      } else if (role === 'dosen') {
        document.getElementById('nip-group').style.display = 'block';
        document.getElementById('alamat-group').style.display = 'block';
        document.getElementById('nip').setAttribute('required', 'required');
        document.getElementById('alamat').setAttribute('required', 'required');
      } else if (role === 'perusahaan') {
        document.getElementById('jurusan-group').style.display = 'block';
        document.getElementById('alamat-group').style.display = 'block';
        document.getElementById('jurusan').setAttribute('required', 'required');
        document.getElementById('alamat').setAttribute('required', 'required');
      }
    }

    // Initialize fields on page load if role is already selected
    document.addEventListener('DOMContentLoaded', function() {
      toggleFields();
    });
  </script>
</body>
</html>
