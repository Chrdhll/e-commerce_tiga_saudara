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

class AboutpageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    // 1. Tampilan Halaman
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'Halaman "Tentang Kami"';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.settings-form'; // Pakai view yang SAMA
    protected static ?string $title = 'Pengaturan Halaman "Tentang Kami"';

    // 2. Siapkan "wadah"
    public ?array $data = [];
    protected string $queryPrefix = 'about_'; // Prefix 'about_'

    // 3. Method 'mount' (Load Data)
    public function mount(): void
    {
        $settings = Setting::where('key', 'like', $this->queryPrefix . '%')
                           ->pluck('value', 'key')
                           ->toArray();
        $formData = [];
        foreach ($settings as $key => $value) {
            $formData[str_replace($this->queryPrefix, '', $key)] = $value;
        }
        $this->form->fill($formData);
    }

    // 4. Method 'form' (Definisi Form)
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Header Halaman')
                    ->schema([
                        TextInput::make('header_title')->label('Judul Header'),
                        Textarea::make('header_subtitle')->label('Subjudul Header')->rows(3),
                    ]),
                Section::make('Statistik Header')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('stat_1_num')->label('Angka Statistik 1'),
                            TextInput::make('stat_1_text')->label('Teks Statistik 1'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('stat_2_num')->label('Angka Statistik 2'),
                            TextInput::make('stat_2_text')->label('Teks Statistik 2'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('stat_3_num')->label('Angka Statistik 3'),
                            TextInput::make('stat_3_text')->label('Teks Statistik 3'),
                        ]),
                    ])->columns(3),

                Section::make('Cerita Kami')
                    ->schema([
                        FileUpload::make('story_image')->label('Gambar Cerita')->image()->directory('setting-images'),
                        TextInput::make('story_title')->label('Judul Cerita'),
                        Textarea::make('story_p1')->label('Paragraf 1')->rows(4),
                        Textarea::make('story_p2')->label('Paragraf 2')->rows(4),
                        Textarea::make('story_p3')->label('Paragraf 3')->rows(4),
                    ])->columns(1),

                Section::make('Visi & Misi')
                    ->schema([
                        TextInput::make('vm_title')->label('Judul Visi Misi'),
                        TextInput::make('vm_subtitle')->label('Subjudul Visi Misi'),
                        Grid::make(2)->schema([
                            Section::make('Visi')->schema([
                                TextInput::make('visi_title')->label('Judul Visi'),
                                Textarea::make('visi_text')->label('Teks Visi')->rows(5),
                            ]),
                            Section::make('Misi')->schema([
                                TextInput::make('misi_title')->label('Judul Misi'),
                                TextInput::make('misi_li1')->label('Misi 1'),
                                TextInput::make('misi_li2')->label('Misi 2'),
                                TextInput::make('misi_li3')->label('Misi 3'),
                            ]),
                        ]),
                    ])->columns(1),

            ])
            ->statePath('data');
    }

    // 5. Method 'save' (Sama persis)
    public function save(): void
    {
        $formData = $this->form->getState();
        foreach ($formData as $key => $value) {
            Setting::where('key', $this->queryPrefix . $key)->update(['value' => $value]);
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
