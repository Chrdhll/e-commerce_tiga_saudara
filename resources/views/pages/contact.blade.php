@extends('layouts.app')

@section('title', $settings['contact_header_title']->value ?? 'Hubungi Kami')

@section('content')
    {{-- Bagian Header Hero --}}
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            {{-- DINAMIS --}}
            <h1 class="display-4">{{ $settings['contact_header_title']->value ?? 'Hubungi Kami' }}</h1>
            <p class="fs-5 text-white-50">
                {{-- DINAMIS --}}
                {{ $settings['contact_header_subtitle']->value ?? 'Ada pertanyaan? Kami siap membantu Anda' }}
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
                            {{-- DINAMIS (dari footer) --}}
                            <p class="text-muted small mb-0">
                                {{ $settings['contact_address']->value ?? 'Alamat belum diatur' }}</p>
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
                            {{-- DINAMIS (dari footer) --}}
                            <a href="tel:{{ $settings['contact_phone']->value ?? '' }}"
                                class="text-muted text-decoration-none d-block small">
                                {{ $settings['contact_phone']->value ?? 'Telepon 1 belum diatur' }}
                            </a>
                            {{-- DINAMIS (BARU) --}}
                            <a href="tel:{{ $settings['contact_phone_2']->value ?? '' }}"
                                class="text-muted text-decoration-none d-block small">
                                {{ $settings['contact_phone_2']->value ?? 'Telepon 2 belum diatur' }}
                            </a>
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
                            {{-- DINAMIS (dari footer) --}}
                            <a href="mailto:{{ $settings['contact_email']->value ?? '' }}"
                                class="text-muted text-decoration-none d-block small">
                                {{ $settings['contact_email']->value ?? 'Email 1 belum diatur' }}
                            </a>
                            {{-- DINAMIS (BARU) --}}
                            <a href="mailto:{{ $settings['contact_email_2']->value ?? '' }}"
                                class="text-muted text-decoration-none d-block small">
                                {{ $settings['contact_email_2']->value ?? 'Email 2 belum diatur' }}
                            </a>
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
                            {{-- DINAMIS (BARU) (Pakai {!! !!} agar <br> terbaca) --}}
                            <p class="text-muted small mb-0">{!! $settings['contact_op_hours']->value ?? 'Jam belum diatur' !!}</p>
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
                    {{-- DINAMIS --}}
                    <h2 class="display-5 text-primary mb-4">
                        {{ $settings['contact_helpline_title']->value ?? 'Saluran Bantuan' }}</h2>
                    <p class="text-muted mb-4 fs-5">
                        {{-- DINAMIS --}}
                        {{ $settings['contact_helpline_subtitle']->value ?? 'Hubungi kami...' }}
                    </p>

                    {{-- Daftar Opsi Kontak --}}
                    <div class="list-group">
                        {{-- DINAMIS (WA dari checkout) --}}
                        <a href="https://wa.me/{{ $settings['whatsapp_number']->value ?? '' }}" target="_blank"
                            rel="noopener noreferrer"
                            class="list-group-item list-group-item-action p-4 border shadow-sm rounded-3 mb-3">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 text-success"><i class="bi bi-whatsapp me-2"></i> WhatsApp (Respon
                                        Cepat)</h5>
                                    {{-- DINAMIS --}}
                                    <small
                                        class="text-muted">{{ $settings['contact_wa_subtitle']->value ?? 'Rekomendasi...' }}</small>
                                </div>
                                <i class="bi bi-arrow-right-circle fs-4 text-success"></i>
                            </div>
                        </a>
                        {{-- DINAMIS (Telepon dari footer) --}}
                        <a href="tel:{{ $settings['contact_phone']->value ?? '' }}"
                            class="list-group-item list-group-item-action p-4 border shadow-sm rounded-3 mb-3">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 text-primary"><i class="bi bi-telephone me-2"></i> Telepon</h5>
                                    {{-- DINAMIS --}}
                                    <small
                                        class="text-muted">{{ $settings['contact_phone_subtitle']->value ?? 'Berbicara langsung...' }}
                                        </small>
                                </div>
                                <i class="bi bi-arrow-right-circle fs-4 text-primary"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    {{-- DINAMIS --}}
                    <h2 class="display-5 text-primary mb-4">{{ $settings['contact_map_title']->value ?? 'Lokasi Kami' }}
                    </h2>

                    {{-- Peta Google Maps (DINAMIS) --}}
                    <div class="ratio ratio-16x9 rounded-3 shadow-sm" style="height: 400px;">
                        {{-- Pakai {!! !!} untuk me-render <iframe> --}}
                        {!! $settings['embed_google_maps']->value ?? '<p class="text-center">Peta belum diatur.</p>' !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
