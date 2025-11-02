@extends('layouts.app')

@section('content')
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <h1 class="display-4">Profil Saya</h1>
            <p class="fs-5 text-white-50">
                Kelola informasi akun, password, dan pengaturan Anda.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        {{-- Memuat partial untuk update profil --}}
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

            

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        {{-- Memuat partial untuk update password --}}
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm border-danger">
                         {{-- Memuat partial untuk hapus akun --}}
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection