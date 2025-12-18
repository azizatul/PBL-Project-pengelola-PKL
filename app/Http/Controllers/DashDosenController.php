<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;

class DashDosenController extends Controller
{
    public function index()
    {
        // Fetch pending seminars for dosen to validate
        $pendingSeminars = Seminar::where('status', 'pending')->get();

        return view('dashdosen', compact('pendingSeminars'));
    }
}
