@extends('layouts.app')

@section('content')
<div class="container-fluid bg-gradient-primary" style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image" style="background: url('https://source.unsplash.com/600x800/?forum,discussion'); background-size: cover; background-position: center;"></div>
                        <div class="col-lg-7">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Forum Registration</h1>
                                    <p class="mb-4">Join our academic discussion forum</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('forum.register') }}" class="user" novalidate>
                                    @csrf

                                    <div class="form-group">
                                        <input id="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                               placeholder="Full Name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                               name="email" value="{{ old('email') }}" required autocomplete="email"
                                               placeholder="Email Address">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <select id="role" class="form-control form-control-user @error('role') is-invalid @enderror" name="role" required>
                                            <option value="">Select Your Role</option>
                                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="kaprodi" {{ old('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                                            <option value="perusahaan" {{ old('role') == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                        </select>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="new-password"
                                                   placeholder="Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input id="password-confirm" type="password" class="form-control form-control-user"
                                                   name="password_confirmation" required autocomplete="new-password"
                                                   placeholder="Repeat Password">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register for Forum
                                    </button>
                                </form>

                                <hr>

                                <div class="text-center">
                                    <a class="btn btn-google btn-user btn-block" href="{{ route('auth.google') }}">
                                        <i class="fab fa-google fa-fw"></i> Register with Google
                                    </a>
                                </div>

                                <div class="text-center mt-3">
                                    <a class="small" href="/login">
                                        Already have an account? Login!
                                    </a>
                                </div>
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

.btn-google {
    color: #fff;
    background-color: #ea4335;
    border-color: #ea4335;
}

.btn-google:hover {
    color: #fff;
    background-color: #d33b2c;
    border-color: #c23321;
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
