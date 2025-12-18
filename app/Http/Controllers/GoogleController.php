<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // 1. Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Handle Callback (Penting: Urutan Pengecekan)
    public function handleGoogleCallback()
    {
        try {
            // Gunakan stateless() untuk menghindari error session di localhost
            $googleUser = Socialite::driver('google')->stateless()->user();
            $email = $googleUser->getEmail();

            // -----------------------------------------------------------
            // PRIORITAS 1: CEK TABEL USERS (Admin, Dosen, Kaprodi)
            // -----------------------------------------------------------
            // Kita cek tabel 'users' DULUAN. Jika ketemu, langsung login & redirect.
            $user = User::where('email', $email)->first();

            if ($user) {
                // Login sebagai User (Admin/Dosen)
                Auth::guard('web')->login($user); // Guard default
                
                // Debugging: Pastikan role terbaca (Bisa dihapus nanti)
                // dd("Login User Berhasil. Role: " . $user->role); 

                return $this->redirectBasedOnRole($user->role);
            }

            // -----------------------------------------------------------
            // PRIORITAS 2: CEK TABEL MAHASISWA
            // -----------------------------------------------------------
            // Jika tidak ada di tabel users, baru kita cek tabel mahasiswa
            $mahasiswa = Mahasiswa::where('email', $email)->first();

            if ($mahasiswa) {
                Auth::guard('mahasiswa')->login($mahasiswa);
                return redirect()->route('dashmhs'); 
            }

            // -----------------------------------------------------------
            // PRIORITAS 3: BELUM TERDAFTAR (REGISTRASI)
            // -----------------------------------------------------------
            session(['googleUser' => $googleUser]);
            return redirect()->route('auth.google.role');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login: ' . $e->getMessage());
        }
    }

    // 3. Halaman Pilih Role
    public function showGoogleRoleSelection()
    {
        $googleUser = session('googleUser');
        if (!$googleUser) {
            return redirect()->route('login')->with('error', 'Sesi habis.');
        }
        return view('auth.google-role', compact('googleUser'));
    }

    // 4. Proses Registrasi
    public function completeGoogleRegistration(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,dosen,kaprodi,mahasiswa,perusahaan',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        try {
            $role = $request->role;
            $randomPass = Hash::make(Str::random(16)); 

            if ($role === 'mahasiswa') {
                // Register Mahasiswa
                $nimSementara = 'GGL_' . rand(1000, 9999) . time(); 
                $mhs = Mahasiswa::create([
                    'nama_mahasiswa' => $request->name,
                    'email' => $request->email,
                    'nim' => $request->input('nim', $nimSementara),
                    'password' => $randomPass,
                    'telepon' => $request->input('phone', '-'),
                ]);
                Auth::guard('mahasiswa')->login($mhs);
                return redirect()->route('dashmhs');

            } else {
                // Register User (Admin/Dosen)
                $usr = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $randomPass,
                    'role' => $role,
                ]);
                Auth::login($usr);
                return $this->redirectBasedOnRole($role);
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal registrasi: ' . $e->getMessage());
        }
    }

    // Helper Redirect
    private function redirectBasedOnRole($role) {
        if (!$role) return redirect()->route('home');

        switch ($role) {
            case 'admin':       return redirect()->route('dashadmin');
            case 'dosen':       return redirect()->route('dashdosen');
            case 'kaprodi':     return redirect()->route('dashkaprodi');
            case 'perusahaan':  return redirect()->route('dashperusahaan');
            case 'mahasiswa':   return redirect()->route('dashmhs');
            default:            return redirect()->route('home');
        }
    }
}