<section class="py-5 bg-gradient-primary-dark text-white" style="overflow: hidden;">
    <div class="container">
        <div class="row align-items-center g-5 py-5">
            <div class="col-lg-6">
                <span class="badge bg-white bg-opacity-25 text-white p-2 rounded-pill mb-3">
                    <i class="bi bi-award-fill text-secondary me-1"></i>
                    {{-- DINAMIS DARI SETTINGS --}}
                    {{ $settings['hero_badge']->value ?? 'Badge Teks' }}
                </span>
                <h1 class="display-3 fw-bold mb-3">
                    {{-- DINAMIS (Pakai {!! !!} agar <span> terbaca) --}}
                    {!! $settings['hero_title']->value ?? 'Judul Hero' !!}
                </h1>
                <p class="fs-5 mb-4 text-white-50">
                    {{-- DINAMIS DARI SETTINGS --}}
                    {{ $settings['hero_subtitle']->value ?? 'Subjudul Hero' }}
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg px-4 text-white">
                        Belanja Sekarang
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">
                        Pelajari Lebih Lanjut
                    </a>
                </div>

                <div class="row g-4 mt-5 pt-4 border-top border-white-50 opacity-50">
                    <div class="col-4">
                        {{-- DINAMIS DARI SETTINGS --}}
                        <h4 class="display-6 text-white mb-0">
                            {{ $settings['hero_stat_1_num']->value ?? '0+' }}</h4>
                        <p class="text-white-50">
                            {{ $settings['hero_stat_1_text']->value ?? 'Stat 1' }}</p>
                    </div>
                    <div class="col-4">
                        {{-- DINAMIS DARI SETTINGS --}}
                        <h4 class="display-6 text-white mb-0">
                            {{ $settings['hero_stat_2_num']->value ?? '0+' }}</h4>
                        <p class="text-white-50">
                            {{ $settings['hero_stat_2_text']->value ?? 'Stat 2' }}</p>
                    </div>
                    <div class="col-4">
                        {{-- DINAMIS DARI SETTINGS --}}
                        <h4 class="display-6 text-white mb-0">
                            {{ $settings['hero_stat_3_num']->value ?? '0+' }}</h4>
                        <p class="text-white-50">
                            {{ $settings['hero_stat_3_text']->value ?? 'Stat 3' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-secondary-danger rounded-4"
                        style="transform: rotate(6deg); z-index: 1;">
                    </div>

                    {{-- DINAMIS (Panggil gambar dari Storage) --}}
                    <img src="{{ Storage::url($settings['hero_image']->value ?? 'images/hero-default.jpg') }}"
                        alt="Fresh Seafood" class="img-fluid rounded-4 shadow-xl position-relative" style="z-index: 2;">
                </div>
            </div>
        </div>
    </div>
</section>
