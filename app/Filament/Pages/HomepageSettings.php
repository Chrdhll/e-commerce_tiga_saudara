<?php

namespace App\Filament\Pages;

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

class HomepageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Homepage';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.settings-form'; // Kita akan pakai 1 view
    protected static ?string $title = 'Pengaturan Homepage';

    public ?array $data = [];
    protected string $queryPrefix = 'hero_'; // Prefix untuk query DB

    public function mount(): void
    {
        $settings = Setting::where('key', 'like', $this->queryPrefix . '%')
                           ->pluck('value', 'key')
                           ->toArray();

        // Ganti 'key' agar form bisa bind. Cth: 'hero_title' -> 'title'
        $formData = [];
        foreach ($settings as $key => $value) {
            $formData[str_replace($this->queryPrefix, '', $key)] = $value;
        }

        $this->form->fill($formData);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Hero Section')
                    ->description('Atur teks dan gambar yang tampil di bagian atas homepage.')
                    ->schema([
                        FileUpload::make('image') // 'hero_image'
                            ->label('Gambar Hero')
                            ->image()->directory('setting-images')->columnSpanFull(),
                        TextInput::make('badge') // 'hero_badge'
                            ->label('Teks Badge (cth: Seafood Segar)'),
                        Textarea::make('title') // 'hero_title'
                            ->label('Judul Hero')
                            ->helperText('Gunakan tag <span class="text-secondary">...</span> untuk mewarnai teks.'),
                        Textarea::make('subtitle') // 'hero_subtitle'
                            ->label('Subjudul Hero')
                            ->rows(4)->columnSpanFull(),
                    ])->columns(2),

                Section::make('Statistik Hero')
                    ->description('Atur 3 statistik di bawah hero section.')
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
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $formData = $this->form->getState();

        // Loop data dan simpan ke DB dengan prefix
        foreach ($formData as $key => $value) {
            Setting::where('key', $this->queryPrefix . $key)->update(['value' => $value]);
        }

        Cache::forget('all_settings'); // Hapus cache global
        Notification::make()->title('Berhasil Disimpan')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')->label('Simpan Perubahan')->submit('save'),
        ];
    }
}
