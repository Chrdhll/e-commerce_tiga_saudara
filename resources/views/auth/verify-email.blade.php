@extends('layouts.app')

@section('content')
    <section class="py-5" style="min-height: 70vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5 text-center">

                            <i class="bi bi-envelope-check text-primary" style="font-size: 4rem;"></i>

                            <h3 class="h4 mt-3">Verifikasi Email Anda</h3>
                            <p class="text-muted mt-3">

                                {{ __('Terima kasih sudah mendaftar! Mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan.') }}
                            </p>
                            <p class="text-muted small">

                                {{ __('Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang baru.') }}
                            </p>

                            {{-- Ini adalah pesan 'Terkirim!' setelah klik tombol resend --}}
                            @if (session('status') == 'verification-link-sent')
                                <div class="alert alert-success mt-4" role="alert">

                                    {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                                </div>
                            @endif

                            {{-- Ini adalah 2 form (Kirim Ulang & Logout) --}}
                            <div
                                class="mt-4 d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Kirim Ulang Email Verifikasi') }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-muted">
                                        {{ __('Log Out') }}
                                        </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
