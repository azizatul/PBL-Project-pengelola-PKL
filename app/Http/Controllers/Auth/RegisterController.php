<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Mahasiswa; // Pastikan Model ini sudah extends Authenticatable
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     */
    protected $redirectTo = '/transkip-nilai'; // Saran: Arahkan ke halaman dashboard/transkrip

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
        // Tambahkan middleware guest spesifik untuk guard mahasiswa jika perlu
        $this->middleware('guest:mahasiswa');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            
            // PERBAIKAN 1: Syntax unique yang benar (tabel,kolom)
            'nim' => ['required', 'string', 'max:20', 'unique:mahasiswas,nim'], 
            
            // PERBAIKAN 2: Cek unique ke tabel 'mahasiswas', BUKAN 'users'
            'email' => ['required', 'string', 'email', 'max:255', 'unique:mahasiswas,email'],
            
            'program_studi' => ['required'], // Sesuaikan validasi prodi
            'phone' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
   protected function create(array $data)
{
    return Mahasiswa::create([
        // Kiri: Nama Kolom Database | Kanan: Nama Input Form
        'nama_mahasiswa' => $data['name'], 
        'nim'            => $data['nim'],
        'email'          => $data['email'],
        'telepon'        => $data['phone'], 
        'password'       => Hash::make($data['password']),
    ]);
}
}