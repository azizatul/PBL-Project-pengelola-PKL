<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class DashAdminController extends Controller
{
    public function index()
    {
        // Fetch mahasiswas with prodi relationship
        $mahasiswas = Mahasiswa::with('prodi')->get();

        return view('dashadmin', compact('mahasiswas'));
    }
}
