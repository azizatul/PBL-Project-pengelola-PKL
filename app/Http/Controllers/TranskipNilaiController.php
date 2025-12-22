<?php

namespace App\Http\Controllers;

use App\Models\transkip_nilai;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TranskipNilaiController extends Controller
{
    public function __construct()
    {
        // Removed auth middleware to allow public access
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            // Public access - show all transkip nilai
            $transkipNilais = transkip_nilai::with('mahasiswa')->get();
        } elseif ($user->role === 'mahasiswa') {
            // Mahasiswa can only see their own transkip nilai
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            if ($mahasiswa) {
                $transkipNilais = transkip_nilai::where('mahasiswa_id', $mahasiswa->id)
                    ->with('mahasiswa')
                    ->get();
            } else {
                $transkipNilais = collect();
            }
        } elseif ($user->role === 'dosen') {
            // Dosen can see all transkip nilai for validation
            $transkipNilais = transkip_nilai::with('mahasiswa')->get();
        } else {
            // Admin and kaprodi can see all
            $transkipNilais = transkip_nilai::with('mahasiswa')->get();
        }

        return view('transkip-nilai.index', compact('transkipNilais'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Public access - anyone can access the create form
        return view('transkip-nilai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // User is already authenticated via middleware
        $user = Auth::user();

        // 1. Validasi Input
        $request->validate([
            'nim' => 'required', // Sesuaikan validasi NIM kamu
            'file' => 'required|mimes:pdf|max:10240', // Maksimal 10MB (10240 KB)
        ]);

        // 2. Cari Data Mahasiswa Berdasarkan user_id dari logged-in user
        $mahasiswa = \App\Models\Mahasiswa::where('user_id', $user->id)->first();

        // Jika mahasiswa tidak ditemukan, kembalikan error
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan!');
        }

        // Verify that the NIM matches the mahasiswa's NIM
        if ($mahasiswa->nim !== $request->nim) {
            return redirect()->back()->with('error', 'NIM tidak sesuai dengan data mahasiswa Anda.');
        }

        // 3. Proses Upload File
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Buat nama file unik (waktu + nama asli) agar tidak bentrok
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke folder: storage/app/public/transkrips
            $file->storeAs('public/transkrips', $filename);

            // 4. Simpan Data ke Database
            \App\Models\transkip_nilai::create([
                'mahasiswa_id' => $mahasiswa->id,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => 'transkrips/' . $filename,
                'status' => 'pending', // Default status saat pertama upload
            ]);

            return redirect()->route('transkip-nilai.index')->with('success', 'Transkrip berhasil diupload!');
        }

        return redirect()->back()->with('error', 'File gagal diupload.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $transkip = \App\Models\transkip_nilai::with('mahasiswa')->findOrFail($id);

    
    return view('transkip-nilai.show', compact('transkip'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transkipNilai = transkip_nilai::findOrFail($id);

        // Check if user is mahasiswa and owns this transkip
        $user = Auth::user();
        if (!$user || $user->role !== 'mahasiswa') {
            abort(403, 'Unauthorized');
        }

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa || $transkipNilai->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized');
        }

        return view('transkip-nilai.edit', compact('transkipNilai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transkipNilai = transkip_nilai::findOrFail($id);

        // Check if user is mahasiswa and owns this transkip
        $user = Auth::user();
        if (!$user || $user->role !== 'mahasiswa') {
            abort(403, 'Unauthorized');
        }

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa || $transkipNilai->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'file' => 'nullable|mimes:pdf|max:10240', // 10MB max
            'nim' => 'required|string', // Require NIM for identification
        ]);

        // Verify NIM matches the transkip nilai owner
        $mahasiswaFromDB = Mahasiswa::where('nim', $request->nim)->first();
        if (!$mahasiswaFromDB || $transkipNilai->mahasiswa_id != $mahasiswaFromDB->id) {
            return redirect()->back()->with('error', 'NIM tidak sesuai dengan pemilik transkip nilai.');
        }

        if ($request->hasFile('file')) {
            // Delete old file
            if ($transkipNilai->file_path && Storage::disk('public')->exists($transkipNilai->file_path)) {
                Storage::disk('public')->delete($transkipNilai->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/transkrips', $filename);

            $transkipNilai->file_path = 'transkrips/' . $filename;
            $transkipNilai->original_filename = $file->getClientOriginalName();
            $transkipNilai->status = 'pending'; // Reset status when file is updated
        }

        $transkipNilai->save();

        return redirect()->route('transkip-nilai.index')->with('success', 'Transkip nilai berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $transkipNilai = transkip_nilai::findOrFail($id);
        $user = Auth::user();

        // For mahasiswa: check ownership
        if ($user && $user->role === 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            if (!$mahasiswa || $transkipNilai->mahasiswa_id != $mahasiswa->id) {
                return redirect()->back()->with('error', 'Anda hanya dapat menghapus transkip nilai sendiri.');
            }
        }
        // For other users (kaprodi, dosen, admin): check their role
        elseif ($user && in_array($user->role, ['kaprodi', 'dosen', 'admin'])) {
            // Allow deletion for these roles
        }
        // For other cases: deny deletion
        else {
            return redirect()->back()->with('error', 'Tidak memiliki izin untuk menghapus transkip nilai.');
        }

        // Delete file from storage
        if ($transkipNilai->file_path && Storage::disk('public')->exists($transkipNilai->file_path)) {
            Storage::disk('public')->delete($transkipNilai->file_path);
        }

        $transkipNilai->delete();

        return redirect()->route('transkip-nilai.index')->with('success', 'Transkip nilai berhasil dihapus.');
    }

    /**
     * Download the file.
     */
    public function download($id)
    {
        $transkipNilai = transkip_nilai::findOrFail($id);

        // Public access - anyone can download transkip nilai files
        return response()->download(storage_path('app/public/' . $transkipNilai->file_path), $transkipNilai->original_filename);
    }

    /**
     * Update status (for dosen and kaprodi validation).
     */
    public function updateStatus(Request $request, $id)
    {
        $transkipNilai = transkip_nilai::findOrFail($id);

        $user = Auth::user();

        // Only kaprodi can update status
        if ($user->role !== 'kaprodi') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $transkipNilai->status = $request->status;
        $transkipNilai->save();

        $message = $request->status === 'approved' ? 'Transkip nilai berhasil divalidasi.' : 'Transkip nilai berhasil ditolak.';

        return redirect()->route('transkip-nilai.index')->with('success', $message);
    }
    public function viewPdf($id)
{
    $transkip = \App\Models\transkip_nilai::findOrFail($id);

    // Tentukan lokasi file asli
    // Pastikan path ini sesuai dengan tempat kamu menyimpan file (public/transkrips)
    $path = storage_path('app/public/' . $transkip->file_path);

    // Cek apakah file ada
    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan di penyimpanan server.');
    }

    // Tampilkan file ke browser (inline)
    return response()->file($path);
}

}
