<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    // Tambahkan ini di dalam class LoginController
public function username()
{
    return 'nim';
}
    public function loginMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string'
        ]);

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        if (!$mahasiswa) {
            // NIM tidak ditemukan, kembali ke login dengan error
            return back()->with('error', 'NIM tidak ditemukan')->withInput();
        }

        // Coba login menggunakan guard mahasiswa
        if (Auth::guard('mahasiswa')->attempt(['nim' => $request->nim, 'password' => $request->password])) {
            // Redirect ke dashboard
            return redirect()->route('dashboardmhs');
        }

        return back()->with('error', 'Password salah')->withInput();
    }

    public function loginKaprodi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Cari user dengan role kaprodi berdasarkan email
        $user = User::where('email', $request->email)->where('role', 'kaprodi')->first();

        if (!$user) {
            // Email tidak ditemukan atau bukan kaprodi
            return back()->with('error', 'Email tidak ditemukan atau bukan Kaprodi')->withInput();
        }

        // Coba login menggunakan guard default (users table)
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirect ke dashboard kaprodi
            return redirect()->route('dashboard.kaprodi');
        }

        return back()->with('error', 'Password salah')->withInput();
    }
    

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showRegisterMahasiswaForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi dasar
        $validated = $request->validate([
            'role' => 'required|in:mahasiswa,dosen,admin,kaprodi,perusahaan',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role tidak valid',
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor HP wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Validasi berdasarkan role
        $role = $validated['role'];
        if ($role === 'mahasiswa') {
            $request->validate([
                'nim' => 'required|string|max:20|unique:mahasiswas,nim|unique:users,nim',
                'program_studi' => 'required|string|max:255',
            ], [
                'nim.required' => 'NIM wajib diisi',
                'nim.unique' => 'NIM sudah terdaftar',
                'program_studi.required' => 'Program studi wajib diisi',
            ]);
        } elseif ($role === 'dosen') {
            $request->validate([
                'nip' => 'required|string|max:20|unique:dosen,nip',
                'alamat' => 'required|string|max:255',
            ], [
                'nip.required' => 'NIP wajib diisi',
                'nip.unique' => 'NIP sudah terdaftar',
                'alamat.required' => 'Alamat wajib diisi',
            ]);
        } elseif ($role === 'perusahaan') {
            $request->validate([
                'jurusan' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
            ], [
                'jurusan.required' => 'Jurusan wajib diisi',
                'alamat.required' => 'Alamat wajib diisi',
            ]);
        }

        try {
            // Buat user baru
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'role' => $role,
            ];

            // Tambahkan field khusus berdasarkan role
            if ($role === 'mahasiswa') {
                $userData['nim'] = $request->nim;
                $userData['program_studi'] = $request->program_studi;
            } elseif ($role === 'dosen') {
                $userData['nip'] = $request->nip;
            } elseif ($role === 'perusahaan') {
                $userData['jurusan'] = $request->jurusan;
            }

            $user = User::create($userData);

            // Buat record sesuai role
            if ($role === 'mahasiswa') {
                Mahasiswa::create([
                    'nama_mahasiswa' => $validated['name'],
                    'nim' => $request->nim,
                    'email' => $validated['email'],
                    'telepon' => $validated['phone'],
                    'password' => Hash::make($validated['password']),
                    'program_studi' => $request->program_studi,
                ]);
            } elseif ($role === 'dosen') {
                \App\Models\Dosen::create([
                    'nama_dosen' => $validated['name'],
                    'nip' => $request->nip,
                    'email' => $validated['email'],
                    'telepon' => $validated['phone'],
                    'alamat' => $request->alamat,
                ]);
            } elseif ($role === 'perusahaan') {
                \App\Models\Perusahaan::create([
                    'nama_perusahaan' => $validated['name'],
                    'email' => $validated['email'],
                    'telepon' => $validated['phone'],
                    'alamat' => $request->alamat,
                    'jurusan' => $request->jurusan,
                ]);
            }

            // Redirect ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan email Anda.');

        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage())->withInput();
        }
    }

    // Google Login Methods
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists with this email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // Random password since Google login
                    'role' => 'mahasiswa', // Default role, or redirect to role selection
                ]);

                // Optionally create Mahasiswa record if needed
                // For now, assume Google login for existing users or new users
            }

            // Log the user in
            Auth::login($user);

            // Redirect based on role or to dashboard
            return redirect()->route('dashmhs'); // Adjust as needed

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login dengan Google gagal.');
        }
    }
}

