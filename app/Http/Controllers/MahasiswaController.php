<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::with('prodi')->get();
        $user = auth()->user();
        return view('mahasiswa.index', compact('mahasiswas', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodis = Prodi::all();
        return view('mahasiswa.create', compact('prodis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:255|unique:mahasiswas,nim',
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'angkatan' => 'required|string|max:4',
            'prodi_id' => 'required|exists:prodis,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Mahasiswa::create($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $prodis = Prodi::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'prodis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim' => 'required|string|max:255|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email,' . $mahasiswa->id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'angkatan' => 'required|string|max:4',
            'prodi_id' => 'required|exists:prodis,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo if exists (stored path already includes the 'photos/' folder)
            if ($mahasiswa->photo && Storage::disk('public')->exists($mahasiswa->photo)) {
                Storage::disk('public')->delete($mahasiswa->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $user = auth()->user();
        if ($user && !in_array($user->role, ['admin', 'dosen', 'kaprodi'])) {
            abort(403, 'Unauthorized');
        }

        // Delete photo if exists (stored path already includes 'photos/')
        if ($mahasiswa->photo && Storage::disk('public')->exists($mahasiswa->photo)) {
            Storage::disk('public')->delete($mahasiswa->photo);
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }

    /**
     * Validate the specified resource.
     */
    public function validateMahasiswa(Mahasiswa $mahasiswa)
    {
        $mahasiswa->update(['status_validasi' => 'validated']);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil divalidasi.');
    }
}
