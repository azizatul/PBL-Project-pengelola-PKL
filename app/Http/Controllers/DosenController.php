<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosens = Dosen::all();
        return view('dosen.index', compact('dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dosen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:dosens,nip',
            'email' => 'required|email|unique:dosens,email',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Dosen::create($data);

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        return view('dosen.show', compact('dosen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        return view('dosen.edit', compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:dosens,nip,' . $dosen->id,
            'email' => 'required|email|unique:dosens,email,' . $dosen->id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($dosen->photo && Storage::disk('public')->exists('photos/' . $dosen->photo)) {
                Storage::disk('public')->delete('photos/' . $dosen->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $dosen->update($data);

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        // Delete photo if exists
        if ($dosen->photo && Storage::disk('public')->exists('photos/' . $dosen->photo)) {
            Storage::disk('public')->delete('photos/' . $dosen->photo);
        }

        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }
}
