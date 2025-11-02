@extends('layouts.app')

@section('title', 'about')

@section('content')
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 mb-4">Tentang 3 Saudara</h1>
                    <p class="fs-5 text-white-50 mb-4">
                        Lebih dari 20 tahun melayani keluarga Indonesia dengan seafood segar berkualitas premium
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="bg-white bg-opacity-25 p-3 rounded-3">
                            <h4 class="display-6 text-white mb-0">20+</h4>
                            <p class="text-white-50 mb-0">Tahun Berpengalaman</p>
                        </div>
                        <div class="bg-white bg-opacity-25 p-3 rounded-3">
                            <h4 class="display-6 text-white mb-0">10K+</h4>
                            <p class="text-white-50 mb-0">Pelanggan Setia</p>
                        </div>
                        <div class="bg-white bg-opacity-25 p-3 rounded-3">
                            <h4 class="display-6 text-white mb-0">500+</h4>
                            <p class="text-white-50 mb-0">Produk Tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-5 text-primary mb-3">Cerita Kami</h2>
                    <p class="text-muted"><span class="text-secondary fw-bold">3 Saudara</span> dimulai dari mimpi sederhana tiga bersaudara yang tumbuh di pesisir pantai. Sejak kecil, kami sudah akrab dengan kehidupan nelayan dan mengenal betul bagaimana cara mendapatkan seafood berkualitas terbaik.</p>
                    <p class="text-muted">Pada tahun 2003, kami memutuskan untuk membagikan pengalaman dan pengetahuan kami kepada masyarakat luas. Dimulai dari sebuah warung kecil di pasar tradisional, kini kami telah berkembang menjadi penyedia seafood segar terpercaya.</p>
                    <p class="text-muted">Komitmen kami tetap sama: <span class="text-primary">menyediakan seafood segar berkualitas tinggi dengan harga yang terjangkau</span>. Kepercayaan Anda adalah aset terbesar kami.</p>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1609149401081-fb5b04b8d451?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxmcmVzaCUyMHNlYWZvb2QlMjBtYXJrZXR8ZW58MXx8fHwxNzYxNzIyNTQzfDA&ixlib=rb-4.1.0&q=80&w=1080" 
                         alt="3 Saudara Story" 
                         class="img-fluid rounded-4 shadow-xl" 
                         style="transform: rotate(3deg);">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 text-primary">Visi & Misi Kami</h2>
                <p class="fs-5 text-muted">Membangun kepercayaan melalui kualitas dan pelayanan terbaik</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-5">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3" style="width: 64px; height: 64px;">
                                <i class="bi bi-bullseye fs-2"></i>
                            </div>
                            <h3 class="text-primary">Visi</h3>
                            <p class="text-muted">Menjadi penyedia seafood segar terpercaya nomor satu di Indonesia, yang dikenal dengan kualitas premium, harga terjangkau, dan pelayanan terbaik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded-circle mb-3" style="width: 64px; height: 64px;">
                                <i class="bi bi-heart-fill fs-2"></i>
                            </div>
                            <h3 class="text-secondary">Misi</h3>
                            <ul class="list-unstyled text-muted d-flex flex-column gap-2">
                                <li class="d-flex"><i class="bi bi-check-circle-fill text-secondary me-2 mt-1"></i><span>Menyediakan seafood segar berkualitas tinggi setiap hari.</span></li>
                                <li class="d-flex"><i class="bi bi-check-circle-fill text-secondary me-2 mt-1"></i><span>Bekerja sama dengan nelayan lokal untuk keberlanjutan.</span></li>
                                <li class="d-flex"><i class="bi bi-check-circle-fill text-secondary me-2 mt-1"></i><span>Memberikan harga terbaik dan terjangkau untuk semua.</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection