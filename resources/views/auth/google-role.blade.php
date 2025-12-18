@extends('layouts.app')

@section('content')
<div class="container-fluid bg-gradient-primary" style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-register-image" style="background: url('https://source.unsplash.com/600x800/?student,university'); background-size: cover; background-position: center;"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Select Your Role</h1>
                                    <p class="mb-4">Welcome {{ $googleUser->name }}! Please select your role to complete registration.</p>
                                </div>

                                <form method="POST" action="{{ route('auth.google.complete') }}" class="user">
                                    @csrf
                                    <input type="hidden" name="google_id" value="{{ $googleUser->id }}">
                                    <input type="hidden" name="name" value="{{ $googleUser->name }}">
                                    <input type="hidden" name="email" value="{{ $googleUser->email }}">
                                    <input type="hidden" name="google_token" value="{{ $googleUser->token }}">
                                    <input type="hidden" name="google_refresh_token" value="{{ $googleUser->refreshToken }}">

                                    <div class="form-group">
                                        <label for="role">Select Your Role:</label>
                                        <select name="role" id="role" class="form-control form-control-user" required>
                                            <option value="">Choose a role...</option>
                                            <option value="admin">Admin</option>
                                            <option value="dosen">Dosen</option>
                                            <option value="kaprodi">Kaprodi</option>
                                            <option value="mahasiswa">Mahasiswa</option>
                                            <option value="perusahaan">Perusahaan</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Complete Registration
                                    </button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.form-control-user {
    border-radius: 10rem;
    padding: 1.5rem 1rem;
    border: 1px solid #d1d3e2;
    font-size: 0.9rem;
}

.btn-user {
    padding: 0.75rem 1rem;
    border-radius: 10rem;
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 0.1rem;
}

.bg-register-image {
    border-radius: 10px 0 0 10px;
}

.text-gray-900 {
    color: #5a5c69 !important;
}

.h4 {
    font-size: 1.5rem;
    font-weight: 400;
}
</style>
@endsection
