<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class SeminarController extends Controller
{
    public function index()
    {
        // Public listing: show all seminars
        $seminars = Seminar::with(['mahasiswa', 'dosen'])->orderBy('created_at', 'desc')->get();

        return view('seminar.index', compact('seminars'));
    }

    public function create()
    {
        // No authentication required — always provide mahasiswa list so form can select
        $mahasiswas = Mahasiswa::orderBy('nama_mahasiswa')->get();

        return view('seminar.create', compact('mahasiswas'));
    }

    public function store(Request $request)
    {

        // Validate form input; require mahasiswa_id from form (no auth)
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'dosen_id' => 'nullable|exists:dosens,id',
        ]);

        $payload = [
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'lokasi' => $request->lokasi,
            'topik' => $request->topik,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
            'mahasiswa_id' => $request->mahasiswa_id,
            'dosen_id' => $request->dosen_id ?? null,
        ];

        // Ensure `dosen_id` is set — prefer provided value, then mahasiswa->dosen_id, then any existing dosen
        if (empty($payload['dosen_id'])) {
            $m = Mahasiswa::find($payload['mahasiswa_id']);
            if ($m && !empty($m->dosen_id)) {
                $payload['dosen_id'] = $m->dosen_id;
            } else {
                $firstDosen = Dosen::first();
                if ($firstDosen) {
                    $payload['dosen_id'] = $firstDosen->id;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Tidak ada dosen tersedia. Tambahkan dosen terlebih dahulu.');
                }
            }
        }

        Seminar::create($payload);

        return redirect()->route('seminar.index')->with('success', 'Seminar berhasil dibuat.');
    }

    public function show(Seminar $seminar)
    {
        return view('seminar.show', compact('seminar'));
    }

    public function edit(Seminar $seminar)
    {
        return view('seminar.edit', compact('seminar'));
    }

    public function update(Request $request, Seminar $seminar)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ]);

        $seminar->update($request->only(['tanggal', 'waktu', 'lokasi', 'topik', 'deskripsi', 'status']));

        return redirect()->route('seminar.index')->with('success', 'Seminar updated successfully.');
    }

    public function destroy(Seminar $seminar)
    {
        $seminar->delete();

        return redirect()->route('seminar.index')->with('success', 'Seminar deleted successfully.');
    }

    public function validateSeminar(Request $request, Seminar $seminar)
    {
        // Allow validation without login (public endpoint)
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $seminar->update(['status' => $request->status]);

        return redirect()->route('seminar.index')->with('success', 'Seminar validated successfully.');
    }
}
