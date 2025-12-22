<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;

class DashPerusahaanController extends Controller
{
    public function index(Request $request)
    {
        // Get sorting parameters
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Validate sort parameters
        $allowedSorts = ['judul', 'created_at', 'status'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // Get all proposals as documents for perusahaan dashboard with sorting
        $documents = Proposal::with(['mahasiswa', 'dosen'])
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        // Calculate stats
        $totalDocuments = $documents->total(); // Use total() for paginated count
        $averageRating = 0; // Placeholder, can be calculated based on some criteria

        return view('dashperusahaan', compact('documents', 'totalDocuments', 'averageRating', 'sortBy', 'sortDirection'));
    }
}
