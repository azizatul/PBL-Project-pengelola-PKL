<?php

namespace App\Http\Controllers;

use App\Models\transkip_nilai as Transkrip;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TranskripController extends Controller
{
    public function __construct()
    {
        // No middleware needed
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role === 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $transkrips = Transkrip::where('mahasiswa_id', $mahasiswa->id)->with('mahasiswa')->get();
        } elseif ($user && $user->role === 'dosen') {
            // Dosen can see transkrips of students they supervise
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen) {
                $mahasiswaIds = Nilai::where('dosen_id', $dosen->id)->pluck('mahasiswa_id')->unique();
                $transkrips = Transkrip::whereIn('mahasiswa_id', $mahasiswaIds)->with('mahasiswa')->get();
            } else {
                $transkrips = collect();
            }
        } else {
            $transkrips = Transkrip::with('mahasiswa')->get();
        }

        // Apply automatic selection logic
        foreach ($transkrips as $transkrip) {
            $transkrip->is_selected = $this->checkSelectionCriteria($transkrip->mahasiswa_id);
            $transkrip->save();
        }

        return view('transkrip.index', compact('transkrips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        return view('transkrip.create', compact('mahasiswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'file' => 'required|mimes:pdf|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Ensure the transkrips directory exists
        $directory = 'transkrips';
        if (!Storage::disk('public')->exists($directory)) {
            if (!Storage::disk('public')->makeDirectory($directory)) {
                return redirect()->back()->with('error', 'Failed to create directory');
            }
        }

        $file->storeAs($directory, $filename, 'public');

        Transkrip::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'file_path' => $directory . '/' . $filename,
            'original_filename' => $file->getClientOriginalName(),
        ]);

        return redirect()->route('transkrip.index')->with('success', 'Transkrip berhasil diupload.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transkrip = Transkrip::with('mahasiswa')->findOrFail($id);
        return view('transkrip.show', compact('transkrip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transkrip = Transkrip::findOrFail($id);
        $mahasiswas = Mahasiswa::all();
        return view('transkrip.edit', compact('transkrip', 'mahasiswas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transkrip = Transkrip::findOrFail($id);

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'file' => 'nullable|mimes:pdf|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($transkrip->file_path && Storage::disk('public')->exists($transkrip->file_path)) {
                Storage::disk('public')->delete($transkrip->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $directory = 'transkrips';
            $file->storeAs($directory, $filename, 'public');

            $transkrip->file_path = $directory . '/' . $filename;
            $transkrip->original_filename = $file->getClientOriginalName();
        }

        $transkrip->mahasiswa_id = $request->mahasiswa_id;
        $transkrip->save();

        return redirect()->route('transkrip.index')->with('success', 'Transkrip berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transkrip = Transkrip::findOrFail($id);

        // Delete file from storage
        if ($transkrip->file_path && Storage::disk('public')->exists($transkrip->file_path)) {
            Storage::disk('public')->delete($transkrip->file_path);
        }

        $transkrip->delete();

        return redirect()->route('transkrip.index')->with('success', 'Transkrip berhasil dihapus.');
    }

    /**
     * Download the file.
     */
    public function download($id)
    {
        $transkrip = Transkrip::findOrFail($id);

        // Authorization check
        $user = Auth::user();
        if ($user && $user->role === 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            if (!$mahasiswa || $transkrip->mahasiswa_id != $mahasiswa->id) {
                abort(403, 'Unauthorized');
            }
        } elseif ($user && $user->role === 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if (!$dosen || !Nilai::where('dosen_id', $dosen->id)->where('mahasiswa_id', $transkrip->mahasiswa_id)->exists()) {
                abort(403, 'Unauthorized');
            }
        } elseif ($user && !in_array($user->role, ['admin', 'kaprodi'])) {
            abort(403, 'Unauthorized');
        }

        return response()->download(storage_path('app/public/' . $transkrip->file_path), $transkrip->original_filename);
    }

    /**
     * Print the PDF file.
     */
    public function print($id)
    {
        $transkrip = Transkrip::findOrFail($id);
        return response()->file(storage_path('app/public/' . $transkrip->file_path));
    }

    /**
     * Check automatic selection criteria.
     */
    private function checkSelectionCriteria($mahasiswaId)
    {
        $nilais = Nilai::where('mahasiswa_id', $mahasiswaId)->get();

        $hasE = false;
        $dCredits = 0;

        foreach ($nilais as $nilai) {
            // Convert numeric grade to letter grade
            $letterGrade = $this->numericToLetter($nilai->nilai);

            if ($letterGrade === 'E') {
                $hasE = true;
                break;
            }

            if ($letterGrade === 'D') {
                $dCredits += $nilai->sks;
            }
        }

        // Selected if no E grades and at least 6 credits with D
        return !$hasE && $dCredits >= 6;
    }

    /**
     * Convert numeric grade to letter grade.
     */
    private function numericToLetter($numeric)
    {
        if ($numeric >= 85) return 'A';
        if ($numeric >= 75) return 'B';
        if ($numeric >= 65) return 'C';
        if ($numeric >= 55) return 'D';
        return 'E';
    }

    /**
     * Approve the transkrip.
     */
    public function approve($id)
    {
        $transkrip = Transkrip::findOrFail($id);
        $transkrip->status = 'approved';
        $transkrip->save();

        return redirect()->route('transkrip.index')->with('success', 'Transkrip berhasil disetujui.');
    }

    /**
     * Reject the transkrip.
     */
    public function reject($id)
    {
        $transkrip = Transkrip::findOrFail($id);
        $transkrip->status = 'rejected';
        $transkrip->save();

        return redirect()->route('transkrip.index')->with('success', 'Transkrip berhasil ditolak.');
    }
}
