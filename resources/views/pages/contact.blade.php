@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
    {{-- Bagian Header Hero --}}
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <h1 class="display-4">Hubungi Kami</h1>
            <p class="fs-5 text-white-50">
                Ada pertanyaan? Kami siap membantu Anda
            </p>
        </div>
    </section>

    {{-- Bagian 4 Kartu Info Atas --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                {{-- Card Alamat --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100 py-4">
                        <div class="card-body">
                            <div
                                class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3 contact-icon-circle">
                                <i class="bi bi-geo-alt fs-2 text-primary"></i>
                            </div>
                            <h5 class="text-primary">Alamat</h5>
                            <p class="text-muted small mb-0">Pagai Utara Kecamatan Sikakap, Kepulauan Mentawai, Provinsi
                                Sumatera Barat</p>
                        </div>
                    </div>
                </div>
                {{-- Card Telepon --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100 py-4">
                        <div class="card-body">
                            <div
                                class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3 contact-icon-circle">
                                <i class="bi bi-telephone fs-2 text-secondary"></i>
                            </div>
                            <h5 class="text-secondary">Telepon</h5>
                            <a href="tel:+6281234567890" class="text-muted text-decoration-none d-block small">+62
                                812-3456-7890</a>
                            <a href="tel:+622112345678" class="text-muted text-decoration-none d-block small">(021)
                                1234-5678</a>
                        </div>
                    </div>
                </div>
                {{-- Card Email --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100 py-4">
                        <div class="card-body">
                            <div
                                class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3 contact-icon-circle">
                                <i class="bi bi-envelope fs-2 text-primary"></i>
                            </div>
                            <h5 class="text-primary">Email</h5>
                            <a href="mailto:info@3saudara.com"
                                class="text-muted text-decoration-none d-block small">info@3saudara.com</a>
                            <a href="mailto:order@3saudara.com"
                                class="text-muted text-decoration-none d-block small">order@3saudara.com</a>
                        </div>
                    </div>
                </div>
                {{-- Card Jam Operasional --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100 py-4">
                        <div class="card-body">
                            <div
                                class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3 contact-icon-circle">
                                <i class="bi bi-clock fs-2 text-secondary"></i>
                            </div>
                            <h5 class="text-secondary">Jam Operasional</h5>
                            <p class="text-muted small mb-0">Senin - Sabtu: 08:00 - 20:00<br><span
                                    class="text-danger">Minggu Tutup</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Bagian Saluran Bantuan dan Peta --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-7">
                    <h2 class="display-5 text-primary mb-4">Saluran Bantuan Kami</h2>
                    <p class="text-muted mb-4 fs-5">
                        Pilih cara ternyaman untuk berbicara dengan tim kami. Kami siap membantu!
                    </p>

                    {{-- Daftar Opsi Kontak --}}
                    <div class="list-group">
                        <a href="https://wa.me/6283189865216" target="_blank" rel="noopener noreferrer"
                            class="list-group-item list-group-item-action p-4 border shadow-sm rounded-3 mb-3">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 text-success"><i class="bi bi-whatsapp me-2"></i> WhatsApp (Respon
                                        Cepat)</h5>
                                    <small class="text-muted">Rekomendasi untuk pertanyaan pesanan dan checkout.</small>
                                </div>
                                <i class="bi bi-arrow-right-circle fs-4 text-success"></i>
                            </div>
                        </a>
                        <a href="tel:+6281234567890"
                            class="list-group-item list-group-item-action p-4 border shadow-sm rounded-3 mb-3">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 text-primary"><i class="bi bi-telephone me-2"></i> Telepon</h5>
                                    <small class="text-muted">Berbicara langsung dengan tim kami di jam kerja.</small>
                                </div>
                                <i class="bi bi-arrow-right-circle fs-4 text-primary"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <h2 class="display-5 text-primary mb-4">Lokasi Kami</h2>

                    {{-- Peta Google Maps --}}
                    <div class="ratio ratio-16x9 rounded-3 shadow-sm" style="height: 400px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666667!2d106.7777777!3d-6.1666666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTAnMDAuMCJTIDEwNsKwNDYnNDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890" title="Peta Lokasi"
                            allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

