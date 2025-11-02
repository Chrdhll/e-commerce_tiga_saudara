@extends('layouts.app')

@section('content')
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <h1 class="display-4">Dashboard</h1>
            <p class="fs-5 text-white-50">
                Selamat datang kembali, {{ Auth::user()->name }}!
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                
                <div class="col-lg-10">
                    <div classs="card border-0 shadow-sm">
                        {{-- 
                        Kita panggil partial yang sama dari halaman profil,
                        tapi sekarang menggunakan variabel $orders dari rute dashboard
                        --}}
                        @include('profile.partials.order-history', ['orders' => $orders])
                    </div>
                </div>

                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-primary">Navigasi Cepat</h5>
                        </div>
                        <div class="card-body p-4 d-flex flex-wrap gap-3">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-fill me-2"></i>
                                Edit Profil
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="bi bi-shop me-2"></i>
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection