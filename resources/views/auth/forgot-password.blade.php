@extends('layouts.app')

@section('content')
    <section class="py-5" style="min-height: 70vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">

                            <h3 class="h4 text-primary">Lupa Password?</h3>
                            <p class="text-muted mt-3">

                                {{ __('Tidak masalah. Cukup beritahu kami alamat email Anda dan kami akan mengirimkan link untuk mengatur ulang password Anda.') }}
                            </p>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}" class="mt-4">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror"
                                        type="email" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2 d-sm-flex justify-content-sm-between align-items-sm-center mt-4">
  
                                    <a href="/" class="btn btn-link text-muted">
                                        <i class="bi bi-arrow-left me-1"></i>
                                        Kembali ke Login
                                    </a>

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Kirim Link Reset Password') }}
                                    </button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
