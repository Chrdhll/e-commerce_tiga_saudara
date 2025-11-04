@extends('layouts.app')

{{-- 
  Judul halamannya sekarang juga dinamis.
  Kita pakai '??' sebagai fallback jika datanya kosong.
--}}
@section('title', $settings['about_header_title']->value ?? 'Tentang Kami')

@section('content')
    
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    {{-- DINAMIS --}}
                    <h1 class="display-4 mb-4">{{ $settings['about_header_title']->value ?? 'Tentang 3 Saudara' }}</h1>
                    <p class="fs-5 text-white-50 mb-4">
                        {{-- DINAMIS --}}
                        {{ $settings['about_header_subtitle']->value ?? 'Deskripsi header...' }}
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="bg-white bg-opacity-25 p-3 rounded-3">
                            {{-- DINAMIS --}}
                            <h4 class="display-6 text-white mb-0">{{ $settings['about_stat_1_num']->value ?? '0+' }}</h4>
                            <p class="text-white-50 mb-0">{{ $settings['about_stat_1_text']->value ?? 'Stat 1' }}</p>
                        </div>
                        <div class="bg-white bg-opacity-25 p-3 rounded-3">
                            {{-- DINAMIS --}}
                            <h4 class="display-6 text-white mb-0">{{ $settings['about_stat_2_num']->value ?? '0+' }}</h4>
                            <p class="text-white-50 mb-0">{{ $settings['about_stat_2_text']->value ?? 'Stat 2' }}</p>
                        </div>
                        <div class="bg-white bg-opacity-25 p-3 rounded-3">
                            {{-- DINAMIS --}}
                            <h4 class="display-6 text-white mb-0">{{ $settings['about_stat_3_num']->value ?? '0+' }}</h4>
                            <p class="text-white-50 mb-0">{{ $settings['about_stat_3_text']->value ?? 'Stat 3' }}</p>
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
                    {{-- DINAMIS --}}
                    <h2 class="display-5 text-primary mb-3">{{ $settings['about_story_title']->value ?? 'Cerita Kami' }}</h2>
                    
                    {{-- 
                      Kita pakai {!! nl2br(e(...)) !!}
                      Ini aman dan akan me-render line break (Enter) dari Textarea
                    --}}
                    <p class="text-muted">{!! nl2br(e($settings['about_story_p1']->value ?? 'Paragraf 1...')) !!}</p>
                    <p class="text-muted">{!! nl2br(e($settings['about_story_p2']->value ?? 'Paragraf 2...')) !!}</p>
                    <p class="text-muted">{!! nl2br(e($settings['about_story_p3']->value ?? 'Paragraf 3...')) !!}</p>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                <div class="position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-secondary-danger rounded-4"
                        style="transform: rotate(6deg); z-index: 1;">
                    </div>
                    
                    {{-- DINAMIS (Mengambil gambar dari Storage) --}}
                    <img src="{{ Storage::url($settings['about_story_image']->value ?? 'images/about-default.jpg') }}"
                        alt="Cerita 3 Saudara" class="img-fluid rounded-4 shadow-xl position-relative"
                        style="z-index: 2;"> 
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                {{-- DINAMIS --}}
                <h2 class="display-5 text-primary">{{ $settings['about_vm_title']->value ?? 'Visi & Misi Kami' }}</h2>
                <p class="fs-5 text-muted">{{ $settings['about_vm_subtitle']->value ?? 'Subjudul Visi Misi...' }}</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-5">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3" style="width: 64px; height: 64px;">
                                <i class="bi bi-bullseye fs-2"></i>
                            </div>
                            {{-- DINAMIS --}}
                            <h3 class="text-primary">{{ $settings['about_visi_title']->value ?? 'Visi' }}</h3>
                            <p class="text-muted">{{ $settings['about_visi_text']->value ?? 'Isi visi...' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="card-body">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded-circle mb-3" style="width: 64px; height: 64px;">
                                <i class="bi bi-heart-fill fs-2"></i>
                            </div>
                            {{-- DINAMIS --}}
                            <h3 class="text-secondary">{{ $settings['about_misi_title']->value ?? 'Misi' }}</h3>
                            <ul class="list-unstyled text-muted d-flex flex-column gap-2">
                                {{-- DINAMIS --}}
                                <li class="d-flex"><i class="bi bi-check-circle-fill text-secondary me-2 mt-1"></i><span>{{ $settings['about_misi_li1']->value ?? 'Misi 1...' }}</span></li>
                                <li class="d-flex"><i class="bi bi-check-circle-fill text-secondary me-2 mt-1"></i><span>{{ $settings['about_misi_li2']->value ?? 'Misi 2...' }}</span></li>
                                <li class="d-flex"><i class="bi bi-check-circle-fill text-secondary me-2 mt-1"></i><span>{{ $settings['about_misi_li3']->value ?? 'Misi 3...' }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection