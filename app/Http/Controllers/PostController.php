<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        // arahkan ke view form create post
        return view('create-post');
    }

    public function store(Request $request)
    {
        // contoh validasi sederhana
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // nanti bisa simpan ke database, sementara tampilkan hasilnya
        return back()->with('success', 'Post berhasil disimpan!');
         return redirect()->route('profil')->with('success', 'Post berhasil dibuat!');
    }
}
