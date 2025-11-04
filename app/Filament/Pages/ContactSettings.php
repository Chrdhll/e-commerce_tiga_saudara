<?php

namespace App\Filament\Pages;

// (Tambahkan 'use' statement yang sama seperti HomepageSettings)
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class ContactSettings extends Page implements HasForms
{
    use InteractsWithForms;

    // 1. Tampilan Halaman
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = 'Kontak & Footer';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.settings-form'; // Pakai view yang SAMA
    protected static ?string $title = 'Pengaturan Halaman Kontak & Footer';

    // 2. Siapkan "wadah"
    public ?array $data = [];
    // Kita tidak pakai prefix, kita akan list manual

    // 3. Method 'mount' (Load Data)
    public function mount(): void
    {
        // Ambil data kontak, footer, dan sosmed
        $settings = Setting::where('key', 'like', 'contact_%')
                           ->orWhere('key', 'like', 'social_%')
                           ->orWhere('key', 'like', 'embed_%')
                           ->orWhere('key', 'whatsapp_number')
                           ->pluck('value', 'key')
                           ->toArray();

        // Di sini kita tidak pakai prefix, jadi langsung fill
        $this->form->fill($settings);
    }

    // 4. Method 'form' (Definisi Form)
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Info Kontak Utama')
                    ->schema([
                        TextInput::make('contact_phone')->label('Telepon Utama Footer'),
                        TextInput::make('contact_email')->label('Email Utama Footer'),
                        Textarea::make('contact_address')->label('Alamat Footer')->rows(4),
                    ])->columns(2),

                Section::make('Halaman Kontak')
                    ->schema([
                        TextInput::make('contact_header_title')->label('Judul Header'),
                        TextInput::make('contact_header_subtitle')->label('Subjudul Header'),
                        TextInput::make('contact_phone_2')->label('Telepon Kedua'),
                        TextInput::make('contact_email_2')->label('Email Kedua'),
                        Textarea::make('contact_op_hours')->label('Jam Operasional')
                            ->helperText('Gunakan <br> untuk pindah baris.'),
                        TextInput::make('contact_helpline_title')->label('Judul Saluran Bantuan'),
                        Textarea::make('contact_helpline_subtitle')->label('Subjudul Saluran Bantuan')->rows(3),
                        TextInput::make('contact_wa_subtitle')->label('Subteks Bantuan WA'),
                        TextInput::make('contact_phone_subtitle')->label('Subteks Bantuan Telepon'),
                        TextInput::make('contact_map_title')->label('Judul Peta'),
                        Textarea::make('embed_google_maps')->label('Embed Google Maps')
                            ->helperText('Salin kode "Embed a map" dari Google Maps.')->rows(6),
                    ])->columns(2),

                Section::make('Checkout')
                    ->schema([
                        TextInput::make('whatsapp_number')->label('Nomor WA Checkout')
                            ->helperText('Format 62. Cth: 62812...'),
                    ]),

                Section::make('Sosial Media')
                    ->schema([
                        TextInput::make('social_facebook')->label('Link Facebook'),
                        TextInput::make('social_instagram')->label('Link Instagram'),
                        TextInput::make('social_whatsapp')->label('Link WhatsApp'),
                    ])->columns(3),
            ])
            ->statePath('data');
    }

    // 5. Method 'save' (Sama persis)
    public function save(): void
    {
        $formData = $this->form->getState();
        // Loop dan simpan (tanpa prefix)
        foreach ($formData as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        Cache::forget('all_settings');
        Notification::make()->title('Berhasil Disimpan')->success()->send();
    }

    // 6. Method 'getFormActions' (Sama persis)
    protected function getFormActions(): array
    {
        return [
            Action::make('save')->label('Simpan Perubahan')->submit('save'),
        ];
    }
}
