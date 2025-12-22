<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TranskipNilaiController;
use App\Http\Controllers\GoogleController;
// PASTIKAN ANDA MENGGUNAKAN JALUR YANG BENAR SESUAI NAMESPACE
use App\Http\Controllers\BimbinganController;

Route::get('/', function () {
    return redirect('/home');
});

// Authentication routes
Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'loginMahasiswa'])->name('login.submit');
Route::post('/login/mahasiswa', [App\Http\Controllers\LoginController::class, 'loginMahasiswa'])->name('login.mahasiswa');
Route::post('/login/kaprodi', [App\Http\Controllers\LoginController::class, 'loginKaprodi'])->name('login.kaprodi');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\LoginController::class, 'register'])->name('register.submit');

Route::middleware(['web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/home/store', [App\Http\Controllers\HomeController::class, 'store'])->name('home.store');
});


Route::get('/perusahaan', function () {
    $mitras = \App\Models\Mitra::all();
    return view('perusahaan', compact('mitras'));
})->name('perusahaan.index');



// All routes that handle POST requests need web middleware for CSRF protection
Route::middleware(['web'])->group(function () {
    Route::resource('bimbingan', BimbinganController::class);
    Route::post('bimbingan/{bimbingan}/validate', [BimbinganController::class, 'validateBimbingan'])->name('bimbingan.validate');
    Route::resource('seminar', App\Http\Controllers\SeminarController::class);
    Route::post('seminar/{seminar}/validate', [App\Http\Controllers\SeminarController::class, 'validateSeminar'])->name('seminar.validate');
    Route::resource('prodi', App\Http\Controllers\ProdiController::class);
    Route::resource('mahasiswa', App\Http\Controllers\MahasiswaController::class);
    Route::post('mahasiswa/{mahasiswa}/validate', [App\Http\Controllers\MahasiswaController::class, 'validateMahasiswa'])->name('mahasiswa.validate');
    Route::resource('mitra', App\Http\Controllers\MitraController::class);
    Route::get('mitra/{mitra}/mahasiswa', [App\Http\Controllers\MitraController::class, 'mahasiswa'])->name('mitra.mahasiswa');
    Route::resource('dosen', App\Http\Controllers\DosenController::class);
    // Enable full CRUD for nilai (add, edit, delete, view)
    Route::resource('nilai', App\Http\Controllers\NilaiController::class);
});
// File upload routes - ensure web middleware is applied for CSRF protection
Route::middleware(['web'])->group(function () {
    Route::resource('proposal', App\Http\Controllers\ProposalController::class);
    Route::get('proposal/{id}/download', [App\Http\Controllers\ProposalController::class, 'download'])->name('proposal.download');
});


// Dashboard routes
Route::get('/dashboard/admin', [App\Http\Controllers\DashAdminController::class, 'index'])->name('dashboard.admin');
Route::get('/dashadmin', [App\Http\Controllers\DashAdminController::class, 'index'])->name('dashadmin');
Route::get('/dashboard/dosen', [App\Http\Controllers\DashDosenController::class, 'index'])->name('dashboard.dosen');
Route::get('/dashdosen', [App\Http\Controllers\DashDosenController::class, 'index'])->name('dashdosen');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/kaprodi', function () {
        return view('dashkaprodi');
    })->name('dashboard.kaprodi');
});
Route::get('/dashkaprodi', function () {
    return view('dashkaprodi');
})->name('dashkaprodi');
// Tambahkan middleware 'auth' atau middleware session Anda di sini
Route::middleware(['CekStatusLogin'])->group(function () {
    // Ganti dengan Controller Dashboard yang sebenarnya jika Anda punya
    Route::get('/dashboard', function () {
        // Ganti ini dengan pemanggilan Controller DashboardMhs Anda
        return view('dashboardmhs');
    })->name('dashboardmhs'); 
});

Route::get('/dashmhs', function () {
    $mahasiswa = null;
    $bimbingans = collect();
    if (Auth::guard('mahasiswa')->check()) {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $bimbingans = $mahasiswa->bimbingans()->with('dosen')->get();
    }
    return view('dashmhs', compact('mahasiswa', 'bimbingans'));
})->name('dashmhs');
Route::get('/dashboard/perusahaan', [App\Http\Controllers\DashPerusahaanController::class, 'index'])->name('dashboard.perusahaan');
Route::get('/dashperusahaan', [App\Http\Controllers\DashPerusahaanController::class, 'index'])->name('dashperusahaan');

// Profile routes - ensure web middleware is applied for CSRF protection
Route::middleware(['web'])->group(function () {
    Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil');
    Route::match(['post', 'put', 'patch'], '/profil', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil/photo', [App\Http\Controllers\ProfilController::class, 'deletePhoto'])->name('profil.delete.photo');

    Route::get('/profildosen', [App\Http\Controllers\ProfilDosenController::class, 'index'])->name('profildosen');
    Route::get('/profildosen/create', [App\Http\Controllers\ProfilDosenController::class, 'create'])->name('profildosen.create');
    Route::post('/profildosen', [App\Http\Controllers\ProfilDosenController::class, 'store'])->name('profildosen.store');
    Route::get('/profildosen/edit', [App\Http\Controllers\ProfilDosenController::class, 'edit'])->name('profildosen.edit');
    Route::put('/profildosen', [App\Http\Controllers\ProfilDosenController::class, 'update'])->name('profildosen.update');
    Route::delete('/profildosen', [App\Http\Controllers\ProfilDosenController::class, 'destroy'])->name('profildosen.destroy');
});

Route::get('/dashmahasiswa', function () {
    return view('dashmhs');
})->name('dashmahasiswa');

Route::get('/ahp', function () {
    return view('AHP'); // file resources/views/AHP.blade.php
})->name('ahp');




// Decision Making Techniques
Route::get('/decision-making', function () {
    return view('decision-making');
})->name('decision.making');

// Transkrip routes - ensure web middleware is applied for CSRF protection
Route::middleware(['web'])->group(function () {
    Route::resource('transkrip', App\Http\Controllers\TranskripController::class);
    Route::get('transkrip/{id}/download', [App\Http\Controllers\TranskripController::class, 'download'])->name('transkrip.download');
    Route::get('transkrip/{id}/print', [App\Http\Controllers\TranskripController::class, 'print'])->name('transkrip.print');
    Route::post('transkrip/{id}/approve', [App\Http\Controllers\TranskripController::class, 'approve'])->name('transkrip.approve');
    Route::post('transkrip/{id}/reject', [App\Http\Controllers\TranskripController::class, 'reject'])->name('transkrip.reject');
});

// Transkip Nilai routes - ensure web and auth middleware is applied
Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('transkip-nilai', App\Http\Controllers\TranskipNilaiController::class);
    Route::get('transkip-nilai/{id}/download', [App\Http\Controllers\TranskipNilaiController::class, 'download'])->name('transkip-nilai.download');
    Route::post('transkip-nilai/{id}/update-status', [App\Http\Controllers\TranskipNilaiController::class, 'updateStatus'])->name('transkip-nilai.update-status');
});



// Pastikan ejaannya 'transkip-nilai' (sesuai tombol di index tadi)
Route::resource('transkip-nilai', TranskipNilaiController::class);

// Route khusus download (jika belum ada)
Route::get('transkip-nilai/{id}/download', [TranskipNilaiController::class, 'download'])->name('transkip-nilai.download');
// Route untuk melihat file PDF (Preview)
Route::get('transkip-nilai/{id}/view-pdf', [App\Http\Controllers\TranskipNilaiController::class, 'viewPdf'])
    ->name('transkip-nilai.view_pdf');
// Ganti 'post' menjadi 'patch'
// Ganti 'post' menjadi 'patch'
// --- ROUTE TRANSKRIP NILAI (DENGAN AUTH) ---
// Gunakan 'auth' untuk mengizinkan kaprodi dan role lainnya
Route::middleware(['auth'])->group(function () {

    Route::resource('transkip-nilai', TranskipNilaiController::class);

    Route::get('transkip-nilai/{id}/download', [TranskipNilaiController::class, 'download'])
        ->name('transkip-nilai.download');

    Route::get('transkip-nilai/{id}/view-pdf', [TranskipNilaiController::class, 'viewPdf'])
        ->name('transkip-nilai.view_pdf');

    Route::patch('transkip-nilai/{id}/update-status', [TranskipNilaiController::class, 'updateStatus'])
        ->name('transkip-nilai.update-status');
}); // <-- Closing brace for auth middleware group

// <--- Pastikan ini ada di paling atas

// ... kode route login/register lainnya ...

// --- ROUTE TRANSKRIP NILAI (DENGAN AUTH) ---
// Gunakan 'auth' untuk mengizinkan kaprodi dan role lainnya
Route::middleware(['auth'])->group(function () {

    Route::resource('transkip-nilai', TranskipNilaiController::class);

    Route::get('transkip-nilai/{id}/download', [TranskipNilaiController::class, 'download'])
        ->name('transkip-nilai.download');

    Route::get('transkip-nilai/{id}/view-pdf', [TranskipNilaiController::class, 'viewPdf'])
        ->name('transkip-nilai.view_pdf');

    Route::patch('transkip-nilai/{id}/update-status', [TranskipNilaiController::class, 'updateStatus'])
        ->name('transkip-nilai.update-status');
}); // <-- Closing brace for auth middleware group

// --- ROUTE GOOGLE INI HARUS DI LUAR GRUP MIDDLEWARE AUTH ---
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// --- Middleware Group (JANGAN MASUKKAN ROUTE GOOGLE KE SINI) ---
Route::middleware(['auth:mahasiswa'])->group(function () {
     // Route transkrip nilai, dll
});
Route::get('auth/google/role', [GoogleController::class, 'showGoogleRoleSelection'])->name('auth.google.role');
Route::post('auth/google/complete', [GoogleController::class, 'completeGoogleRegistration'])->name('auth.google.complete');
