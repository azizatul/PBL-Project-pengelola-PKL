<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class BimbinganController extends Controller
{
    /**
     * Display a listing of bimbingans.
     */
    public function index(Request $request)
    {
       
        $sortBy = $request->get('sort_by', 'tanggal');
        $sortDirection = $request->get('sort_direction', 'desc');

        
        $allowedSorts = ['tanggal', 'waktu_mulai', 'waktu_selesai', 'mahasiswa.nama_mahasiswa', 'dosen.nama_dosen', 'topik', 'catatan', 'status'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'tanggal';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $user = Auth::user();

        if ($user && $user->role === 'mahasiswa' && $user->mahasiswa) {
            $query = $user->mahasiswa->bimbingans()->with('dosen');
        } elseif ($user && $user->role === 'dosen' && $user->dosen) {
            $query = Bimbingan::where('dosen_id', $user->dosen->id)->with('mahasiswa');
        } else {
            $query = Bimbingan::with(['mahasiswa', 'dosen']);
        }

       
        if (strpos($sortBy, '.') !== false) {
            // Handle relationship sorting
            list($relation, $column) = explode('.', $sortBy);
            $query->join($relation . 's', 'bimbingans.' . $relation . '_id', '=', $relation . 's.id')
                  ->orderBy($relation . 's.' . $column, $sortDirection)
                  ->select('bimbingans.*');
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $bimbingans = $query->paginate(10);

        return view('bimbingan.index', compact('bimbingans', 'sortBy', 'sortDirection'));
    }

   
    public function create()
    {
        $mahasiswas = null;
        $dosens = null;

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'mahasiswa' && $user->mahasiswa) {
                $mahasiswas = collect([$user->mahasiswa]);
            } else {
                $mahasiswas = Mahasiswa::orderBy('nama_mahasiswa')->get();
            }

            $dosens = Dosen::orderBy('nama_dosen')->get();
        } else {
            $mahasiswas = Mahasiswa::orderBy('nama_mahasiswa')->get();
            $dosens = Dosen::orderBy('nama_dosen')->get();
        }

        return view('bimbingan.create', compact('mahasiswas', 'dosens'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'dosen_id' => 'nullable|exists:dosens,id',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'topik' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->only(['mahasiswa_id', 'dosen_id', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'topik', 'catatan']);
        $data['status'] = 'pending';

        try {
            Bimbingan::create($data);
        } catch (QueryException $e) {
            Log::error('Failed to create Bimbingan: ' . $e->getMessage(), ['payload' => $data]);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan bimbingan. Periksa log untuk detail.');
        }

        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil ditambahkan.');
    }

    public function destroy(Bimbingan $bimbingan)
    {
        if (!Auth::check()) {
            abort(403, 'Anda harus login untuk menghapus bimbingan.');
        }

        $user = Auth::user();

        if ($user->role === 'mahasiswa') {
            if ($bimbingan->mahasiswa_id != optional($user->mahasiswa)->id) {
                abort(403, 'Anda hanya dapat menghapus bimbingan Anda sendiri.');
            }
        } elseif ($user->role === 'dosen') {
            if ($bimbingan->dosen_id != optional($user->dosen)->id) {
                abort(403, 'Anda hanya dapat menghapus bimbingan Anda sendiri.');
            }
        } else {
            abort(403, 'Anda tidak memiliki izin untuk menghapus bimbingan.');
        }

        $bimbingan->delete();

        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil dihapus.');
    }

    
   
    public function validateBimbingan(Request $request, Bimbingan $bimbingan)
    {
        if (!Auth::check()) {
            abort(403, 'Anda harus login untuk memvalidasi bimbingan.');
        }

        $user = Auth::user();
        if ($user->role !== 'dosen') {
            abort(403, 'Hanya dosen yang dapat memvalidasi bimbingan.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $bimbingan->update(['status' => $request->status]);

        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil divalidasi.');
    }
}
