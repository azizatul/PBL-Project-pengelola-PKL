<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mitras = Mitra::all();
        return view('mitra.index', compact('mitras'));
    }

    /**
     * Show list of mahasiswa (interns) for a given mitra.
     */
    public function mahasiswa($id)
    {
        $mitra = Mitra::findOrFail($id);

        // If users table has mitra_id column, map users -> mahasiswas by email.
        $mahasiswas = collect();
        $warning = null;

        if (Schema::hasColumn('users', 'mitra_id')) {
            $users = User::where('mitra_id', $mitra->id)->where('role', 'mahasiswa')->get();
            $emails = $users->pluck('email')->filter();
            if ($emails->isNotEmpty()) {
                $mahasiswas = Mahasiswa::whereIn('email', $emails)->get();
            }
        } else {
            // Migration not applied or column missing
            $warning = 'Kolom users.mitra_id tidak ditemukan. Jalankan migration untuk mengaitkan user dengan mitra, atau gunakan email mapping.';
        }

        return view('mitra.mahasiswa', compact('mitra', 'mahasiswas', 'warning'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mitra.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'provinsi' => 'nullable|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:mitras,email',
            'jurusan' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = basename($logoPath);
        }

        Mitra::create($data);

        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('mitra.show', compact('mitra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('mitra.edit', compact('mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mitra = Mitra::findOrFail($id);

        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'provinsi' => 'nullable|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:mitras,email,' . $mitra->id,
            'jurusan' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($mitra->logo && Storage::disk('public')->exists('logos/' . $mitra->logo)) {
                Storage::disk('public')->delete('logos/' . $mitra->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = basename($logoPath);
        }

        $mitra->update($data);

        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mitra = Mitra::findOrFail($id);

        // Delete logo if exists
        if ($mitra->logo && Storage::disk('public')->exists('logos/' . $mitra->logo)) {
            Storage::disk('public')->delete('logos/' . $mitra->logo);
        }

        $mitra->delete();

        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil dihapus.');
    }
}
