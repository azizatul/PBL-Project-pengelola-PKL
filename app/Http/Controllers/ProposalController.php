<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role === 'mahasiswa') {
            // Mahasiswa can only see their own proposals
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            if ($mahasiswa) {
                $proposals = Proposal::where('mahasiswa_id', $mahasiswa->id)
                    ->with(['mahasiswa', 'dosen'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            } else {
                $proposals = collect();
            }
        } elseif ($user && in_array($user->role, ['dosen', 'kaprodi', 'perusahaan'])) {
            // Dosen, kaprodi, perusahaan can see all proposals
            $proposals = Proposal::with(['mahasiswa', 'dosen'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Default: show all proposals
            $proposals = Proposal::with(['mahasiswa', 'dosen'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('proposal.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user && $user->role !== 'mahasiswa') {
            abort(403, 'Unauthorized');
        }

        // For now, show all mahasiswas since authentication is disabled
        $mahasiswas = Mahasiswa::all();

        return view('proposal.create', compact('mahasiswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->role !== 'mahasiswa') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('proposals', $fileName, 'public');

            Proposal::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientOriginalExtension(),
                'dosen_id' => 1, // Default dosen ID since authentication is disabled
                'mahasiswa_id' => $request->mahasiswa_id,
            ]);

            return redirect()->route('proposal.index')->with('success', 'Proposal berhasil diupload.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload file.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proposal = Proposal::with(['mahasiswa', 'dosen'])->findOrFail($id);

        return view('proposal.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if ($user && !in_array($user->role, ['dosen', 'kaprodi', 'perusahaan'])) {
            abort(403, 'Unauthorized');
        }

        $proposal = Proposal::findOrFail($id);
        $mahasiswas = Mahasiswa::all();

        return view('proposal.edit', compact('proposal', 'mahasiswas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if ($user && !in_array($user->role, ['dosen', 'kaprodi', 'perusahaan'])) {
            abort(403, 'Unauthorized');
        }

        $proposal = Proposal::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'status' => 'required|in:pending,approved,rejected',
            'komentar' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'mahasiswa_id' => $request->mahasiswa_id,
            'status' => $request->status,
            'komentar' => $request->komentar,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($proposal->file_path && Storage::disk('public')->exists($proposal->file_path)) {
                Storage::disk('public')->delete($proposal->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('proposals', $fileName, 'public');

            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        $proposal->update($data);

        return redirect()->route('proposal.index')->with('success', 'Proposal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if ($user && !in_array($user->role, ['dosen', 'kaprodi', 'perusahaan'])) {
            abort(403, 'Unauthorized');
        }

        $proposal = Proposal::findOrFail($id);

        // Delete file
        if ($proposal->file_path && Storage::disk('public')->exists($proposal->file_path)) {
            Storage::disk('public')->delete($proposal->file_path);
        }

        $proposal->delete();

        return redirect()->route('proposal.index')->with('success', 'Proposal berhasil dihapus.');
    }

    /**
     * Download the proposal file.
     */
    public function download(string $id)
    {
        $proposal = Proposal::findOrFail($id);

        if (!$proposal->file_path || !Storage::disk('public')->exists($proposal->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($proposal->file_path, $proposal->file_name);
    }
}
