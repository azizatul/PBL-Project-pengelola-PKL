<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = Prodi::all();
        return view('prodi.index', compact('prodis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prodi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_prodi', 'deskripsi']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Prodi::create($data);

        return redirect()->route('prodi.index')->with('success', 'Prodi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prodi $prodi)
    {
        return view('prodi.show', compact('prodi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        return view('prodi.edit', compact('prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_prodi', 'deskripsi']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $prodi->update($data);

        return redirect()->route('prodi.index')->with('success', 'Prodi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        $user = auth()->user();
        if ($user && !in_array($user->role, ['admin', 'dosen', 'kaprodi'])) {
            abort(403, 'Unauthorized');
        }

        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Prodi deleted successfully.');
    }
}
