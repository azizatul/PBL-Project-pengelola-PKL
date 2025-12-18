<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Bimbingan;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Display the profile page.
     */
    public function index()
    {
        $mahasiswa = null;

        // Calculate real-time statistics for display
        $statistics = [];
        if ($mahasiswa) {
            $statistics['bimbingan_count'] = Bimbingan::where('mahasiswa_id', $mahasiswa->id)->count();
            $totalSeminars = Seminar::where('mahasiswa_id', $mahasiswa->id)->count();
            $completedSeminars = Seminar::where('mahasiswa_id', $mahasiswa->id)->where('status', 'selesai')->count();
            $statistics['seminar_progress'] = $totalSeminars > 0 ? round(($completedSeminars / $totalSeminars) * 100) : 0;
            $statistics['attendance_percentage'] = $statistics['bimbingan_count'] > 0 ? 100 : 0; // Simplified attendance calculation
        }

        return view('profil', compact('mahasiswa', 'statistics'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'email' => 'required|email|unique:mahasiswas,email,' . $mahasiswa->id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'angkatan' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'bimbingan_count' => 'nullable|integer|min:0',
            'seminar_progress' => 'nullable|integer|min:0|max:100',
            'attendance_percentage' => 'nullable|integer|min:0|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_mahasiswa', 'nim', 'email', 'telepon', 'alamat', 'angkatan', 'bimbingan_count', 'seminar_progress', 'attendance_percentage']);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($mahasiswa->photo && Storage::disk('public')->exists('photos/' . $mahasiswa->photo)) {
                Storage::disk('public')->delete('photos/' . $mahasiswa->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $mahasiswa->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Delete the profile photo.
     */
    public function deletePhoto(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.']);
        }
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();

        if (!$mahasiswa) {
            return response()->json(['success' => false, 'message' => 'Data mahasiswa tidak ditemukan.']);
        }

        if ($mahasiswa->photo && Storage::disk('public')->exists('photos/' . $mahasiswa->photo)) {
            Storage::disk('public')->delete('photos/' . $mahasiswa->photo);
        }

        $mahasiswa->update(['photo' => null]);

        return response()->json(['success' => true, 'message' => 'Foto profil berhasil dihapus.']);
    }
}
