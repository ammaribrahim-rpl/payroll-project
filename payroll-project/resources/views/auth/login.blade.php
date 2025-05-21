@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center py-5">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="bg-primary text-white p-4 text-center">
                        <h3 class="fw-bold mb-0">Sistem Payroll</h3>
                        <p class="mb-0 opacity-75 small">Silakan masuk ke akun Anda</p>
                    </div>
                    
                    <div class="p-4 p-lg-5">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show py-2 px-3" role="alert">
                                <small>{{ session('error') }}</small>
                                <button type="button" class="btn-close small p-1" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show py-2 px-3" role="alert">
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close small p-1" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="mt-3">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label small fw-medium">Alamat Email</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-envelope-fill"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                                        placeholder="Masukkan email Anda">
                                </div>
                                @error('email')
                                    <span class="text-danger small mt-1 d-block">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label small fw-medium">Password</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                        name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                                </div>
                                @error('password')
                                    <span class="text-danger small mt-1 d-block">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div> --}}

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg py-2 fw-medium">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 small text-muted">
                <p>© {{ date('Y') }} Sistem Payroll. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </div>
</div>
@endsection