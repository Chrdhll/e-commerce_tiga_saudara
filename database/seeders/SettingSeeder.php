<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {

        $settings = [
                    // --- PENGATURAN KONTAK & FOOTER ---
                    ['key' => 'whatsapp_number', 'value' => '6283189865216'],
                    ['key' => 'contact_phone', 'value' => '+62 812-3456-7890'],
                    ['key' => 'contact_email', 'value' => 'info@3saudara.com'],
                    ['key' => 'contact_address', 'value' => 'Pagai Utara, Kecamatan Sikakap, Kepulauan Mentawai, Provinsi Sumatera Barat'],
                    ['key' => 'social_facebook', 'value' => 'https://facebook.com/username'],
                    ['key' => 'social_instagram', 'value' => 'https://instagram.com/username'],
                    ['key' => 'social_whatsapp', 'value' => 'https://wa.me/6281234567890'],
                    ['key' => 'embed_google_maps', 'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15956.12640242137!2d100.3541708!3d-0.9272896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b92b0ee3f019%3A0x25001f11c7c10b4b!2sUniversitas%20Andalas!5e0!3m2!1sid!2sid!4v1626244485553!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'],

                    // --- PENGATURAN HOMEPAGE (HERO SECTION) ---
                    ['key' => 'hero_badge', 'value' => 'Seafood Segar & Berkualitas'],
                    ['key' => 'hero_title', 'value' => 'Selamat Datang di <span class="text-secondary">3 Saudara</span>'],
                    ['key' => 'hero_subtitle', 'value' => 'Menyediakan seafood segar langsung dari laut untuk meja makan Anda. Kualitas terjamin, harga terjangkau, dan pengiriman cepat.'],
                    ['key' => 'hero_image', 'value' => 'images/hero-default.jpg'],
                    ['key' => 'hero_stat_1_num', 'value' => '500+'],
                    ['key' => 'hero_stat_1_text', 'value' => 'Produk Tersedia'],
                    ['key' => 'hero_stat_2_num', 'value' => '10K+'],
                    ['key' => 'hero_stat_2_text', 'value' => 'Pelanggan Puas'],
                    ['key' => 'hero_stat_3_num', 'value' => '100%'],
                    ['key' => 'hero_stat_3_text', 'value' => 'Segar & Halal'],

                    // --- PENGATURAN HALAMAN TENTANG KAMI ---
                    ['key' => 'about_header_title', 'value' => 'Tentang 3 Saudara'],
                    ['key' => 'about_header_subtitle', 'value' => 'Lebih dari 20 tahun melayani keluarga Indonesia dengan seafood segar berkualitas premium'],
                    ['key' => 'about_stat_1_num', 'value' => '20+'],
                    ['key' => 'about_stat_1_text', 'value' => 'Tahun Berpengalaman'],
                    ['key' => 'about_stat_2_num', 'value' => '10K+'],
                    ['key' => 'about_stat_2_text', 'value' => 'Pelanggan Setia'],
                    ['key' => 'about_stat_3_num', 'value' => '500+'],
                    ['key' => 'about_stat_3_text', 'value' => 'Produk Tersedia'],
                    ['key' => 'about_story_title', 'value' => 'Cerita Kami'],
                    ['key' => 'about_story_p1', 'value' => '3 Saudara dimulai dari mimpi sederhana tiga bersaudara yang tumbuh di pesisir pantai. Sejak kecil, kami sudah akrab dengan kehidupan nelayan dan mengenal betul bagaimana cara mendapatkan seafood berkualitas terbaik.'],
                    ['key' => 'about_story_p2', 'value' => 'Pada tahun 2003, kami memutuskan untuk membagikan pengalaman dan pengetahuan kami kepada masyarakat luas. Dimulai dari sebuah warung kecil di pasar tradisional, kini kami telah berkembang menjadi penyedia seafood segar terpercaya.'],
                    ['key' => 'about_story_p3', 'value' => 'Komitmen kami tetap sama: menyediakan seafood segar berkualitas tinggi dengan harga yang terjangkau. Kepercayaan Anda adalah aset terbesar kami.'],
                    ['key' => 'about_story_image', 'value' => 'images/about-default.jpg'],
                    ['key' => 'about_vm_title', 'value' => 'Visi & Misi Kami'],
                    ['key' => 'about_vm_subtitle', 'value' => 'Membangun kepercayaan melalui kualitas dan pelayanan terbaik'],
                    ['key' => 'about_visi_title', 'value' => 'Visi'],
                    ['key' => 'about_visi_text', 'value' => 'Menjadi penyedia seafood segar terpercaya nomor satu di Indonesia, yang dikenal dengan kualitas premium, harga terjangkau, dan pelayanan terbaik.'],
                    ['key' => 'about_misi_title', 'value' => 'Misi'],
                    ['key' => 'about_misi_li1', 'value' => 'Menyediakan seafood segar berkualitas tinggi setiap hari.'],
                    ['key' => 'about_misi_li2', 'value' => 'Bekerja sama dengan nelayan lokal untuk keberlanjutan.'],
                    ['key' => 'about_misi_li3', 'value' => 'Memberikan harga terbaik dan terjangkau untuk semua.'],

                    // --- PENGATURAN HALAMAN KONTAK ---
                    ['key' => 'contact_header_title', 'value' => 'Hubungi Kami'],
                    ['key' => 'contact_header_subtitle', 'value' => 'Ada pertanyaan? Kami siap membantu Anda'],
                    ['key' => 'contact_phone_2', 'value' => '(021) 1234-5678'],
                    ['key' => 'contact_email_2', 'value' => 'order@3saudara.com'],
                    ['key' => 'contact_op_hours', 'value' => 'Senin - Sabtu: 08:00 - 20:00<br><span class="text-danger">Minggu Tutup</span>'],
                    ['key' => 'contact_helpline_title', 'value' => 'Saluran Bantuan Kami'],
                    ['key' => 'contact_helpline_subtitle', 'value' => 'Pilih cara ternyaman untuk berbicara dengan tim kami. Kami siap membantu!'],
                    ['key' => 'contact_wa_subtitle', 'value' => 'Rekomendasi untuk pertanyaan pesanan dan checkout.'],
                    ['key' => 'contact_phone_subtitle', 'value' => 'Berbicara langsung dengan tim kami di jam kerja.'],
                    ['key' => 'contact_map_title', 'value' => 'Lokasi Kami'],
                ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }


    }
}
