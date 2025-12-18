<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    // MENAMPILKAN DATA UTAMA
    public function index()
    {
        $nilais = Nilai::with('mahasiswa')->latest()->get();
        return view('nilai.index', compact('nilais'));
    }

    // HALAMAN FORM TAMBAH (CREATE)
    public function create()
    {
        $mahasiswas = Mahasiswa::all(); // Mengambil data mahasiswa untuk dropdown
        return view('nilai.create', compact('mahasiswas'));
    }

    // PROSES SIMPAN DATA BARU (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required',
            'nilai'        => 'required|numeric',
            'semester'     => 'required|numeric',
            'tahun_ajaran' => 'required',
            'kategori'     => 'required',
            'dosen_id'     => 'required',
        ]);

        Nilai::create($request->only([
            'mahasiswa_id',
            'dosen_id',
            'perusahaan_id',
            'nilai',
            'semester',
            'tahun_ajaran',
            'kategori',
            'sks',
        ]));

        return redirect()->route('nilai.index')
                         ->with('success', 'Data Nilai berhasil ditambahkan.');
    }

    // HALAMAN FORM EDIT
    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $mahasiswas = Mahasiswa::all();
        $dosens = \App\Models\Dosen::all();
        return view('nilai.edit', compact('nilai', 'mahasiswas', 'dosens'));
    }

    // PROSES UPDATE DATA (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_id' => 'required',
            'nilai'        => 'required|numeric',
            'semester'     => 'required|numeric',
            'tahun_ajaran' => 'required',
            'kategori'     => 'required',
            'dosen_id'     => 'required',
        ]);

        $nilai = Nilai::findOrFail($id);
        $nilai->update($request->only([
            'mahasiswa_id',
            'dosen_id',
            'perusahaan_id',
            'nilai',
            'semester',
            'tahun_ajaran',
            'kategori',
            'sks',
        ]));

        return redirect()->route('nilai.index')
                         ->with('success', 'Data Nilai berhasil diperbarui.');
    }

    // PROSES HAPUS DATA (DESTROY)
    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilai.index')
                         ->with('success', 'Data Nilai berhasil dihapus.');
    }
    
    // HALAMAN DETAIL (SHOW) - Opsional
    public function show($id)
    {
        $nilai = Nilai::with('mahasiswa')->findOrFail($id);
        return view('nilai.show', compact('nilai'));
    }
}