@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <h1 class="display-4">Hubungi Kami</h1>
            <p class="fs-5 text-white-50">
                Ada pertanyaan? Kami siap membantu Anda
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100 py-4">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                                style="width: 64px; height: 64px;">
                                <i class="bi bi-geo-alt fs-2 text-primary"></i>
                            </div>
                            <h5 class="text-primary">Alamat</h5>
                            <p class="text-muted small mb-0">Pagai Utara Kecamatan Sikakap, Kepulauan Mentawai, Provinsi Sumatera Barat</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100 py-4">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                                style="width: 64px; height: 64px;">
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
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100 py-4">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                                style="width: 64px; height: 64px;">
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
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100 py-4">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                                style="width: 64px; height: 64px;">
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

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <h2 class="display-5 text-primary mb-4">Kirim Pesan</h2>
                    <form action="https://wa.me/6283189865216" method="GET" target="_blank" x-data="{ name: '', email: '', phone: '', subject: '', message: '' }">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="contact-name" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="contact-name" x-model="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contact-email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="contact-email" x-model="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contact-phone" class="form-label">No. Telepon *</label>
                                <input type="tel" class="form-control" id="contact-phone" x-model="phone" required>
                            </div>
                            <div class="col-12">
                                <label for="contact-subject" class="form-label">Subjek *</label>
                                <input type="text" class="form-control" id="contact-subject" x-model="subject" required>
                            </div>
                            <div class="col-12">
                                <label for="contact-message" class="form-label">Pesan *</label>
                                <textarea class="form-control" id="contact-message" rows="6" x-model="message" required></textarea>
                            </div>
                            <div class="col-12">
                                <input type="hidden" name="text"
                                    :value="`Halo 3 Saudara!
                                    
                                    Nama: ${name}
                                    Email: ${email}
                                    No. Telepon: ${phone}
                                    Subjek: ${subject}
                                    
                                    Pesan:
                                    ${message}`">

                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                                    <i class="bi bi-send-fill me-2"></i>
                                    Kirim Pesan via WhatsApp
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5">
                    <h2 class="display-5 text-primary mb-4">Lokasi Kami</h2>
                    <div class="ratio ratio-16x9 rounded-3 shadow-sm mb-4" style="height: 250px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666667!2d106.7777777!3d-6.1666666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTAnMDAuMCJTIDEwNsKwNDYnNDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890"
                            allowfullscreen="" loading="lazy"></iframe>
                    </div>

                    <div class="card border-0 shadow-sm bg-light p-3">
                        <div class="card-body">
                            <h5 class="text-primary mb-3">Ikuti Kami</h5>
                            <div class="d-flex gap-3">
                                <a href="#" class="btn btn-primary rounded-circle"
                                    style="width: 44px; height: 44px;"><i class="bi bi-facebook fs-5"></i></a>
                                <a href="#" class="btn text-white rounded-circle"
                                    style="width: 44px; height: 44px; background: #003d7a; background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);"><i
                                        class="bi bi-instagram fs-5"></i></a>
                                <a href="https://wa.me/6283189865216" class="btn text-white rounded-circle" style="width: 44px; height: 44px; background-color: #003d7a;" onclick="window.open(this.href, '_blank'); return false;"><i
                                        class="bi bi-whatsapp fs-5"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
