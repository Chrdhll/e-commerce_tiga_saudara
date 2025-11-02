<?php

namespace Database\Seeders;

use App\Models\Setting; // <-- IMPORT
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Buat atau Update data setting 'whatsapp_number'
        // Isi 'value' dengan nomor WA-mu saat ini sebagai default
        Setting::updateOrCreate(
            ['key' => 'whatsapp_number'],
            ['value' => '62831822246'] 
        );
    }
}
