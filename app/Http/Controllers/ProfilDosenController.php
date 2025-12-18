<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilDosenController extends Controller
{
    /**
     * Display the profile page for dosen.
     */
    public function index()
    {
        $dosens = Dosen::all();

        return view('profildosen', compact('dosens'));
    }

    /**
     * Show the form for creating a new profile.
     */
    public function create()
    {
        $user = Auth::user();

        if (!$user || !$user->email) {
            return redirect()->route('profildosen')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if profile already exists
        $existingDosen = Dosen::where('email', $user->email)->first();
        if ($existingDosen) {
            return redirect()->route('profildosen')->with('error', 'Profil dosen sudah ada.');
        }

        return view('profildosen.create');
    }

    /**
     * Store a newly created profile.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->email) {
            return redirect()->route('profildosen')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if profile already exists
        $existingDosen = Dosen::where('email', $user->email)->first();
        if ($existingDosen) {
            return redirect()->route('profildosen')->with('error', 'Profil dosen sudah ada.');
        }

        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:dosens',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_dosen', 'nip', 'alamat', 'telepon']);
        $data['email'] = $user->email;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Dosen::create($data);

        return redirect()->route('profildosen.index')->with('success', 'Profil dosen berhasil dibuat.');
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();

        if (!$user || !$user->email) {
            return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $dosen = Dosen::where('email', $user->email)->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        return view('profildosen.edit', compact('dosen'));
    }

    /**
     * Update the profile in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->email) {
            return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $dosen = Dosen::where('email', $user->email)->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:dosens,nip,' . $dosen->id,
            'email' => 'required|email|unique:dosens,email,' . $dosen->id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_dosen', 'nip', 'email', 'alamat', 'telepon']);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($dosen->photo && Storage::disk('public')->exists('photos/' . $dosen->photo)) {
                Storage::disk('public')->delete('photos/' . $dosen->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $dosen->update($data);

        return redirect()->route('profildosen')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Remove the specified profile from storage.
     */
    public function destroy()
    {
        $user = Auth::user();

        if (!$user || !$user->email) {
            return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $dosen = Dosen::where('email', $user->email)->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        // Delete photo if exists
        if ($dosen->photo && Storage::disk('public')->exists('photos/' . $dosen->photo)) {
            Storage::disk('public')->delete('photos/' . $dosen->photo);
        }

        $dosen->delete();

        return redirect()->route('profildosen.index')->with('success', 'Profil dosen berhasil dihapus.');
    }
}
