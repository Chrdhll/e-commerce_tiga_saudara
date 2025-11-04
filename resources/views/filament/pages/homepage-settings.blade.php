<x-filament-panels::page>
    {{-- 
      Ini akan otomatis me-render Form dan Tombol Simpan 
      yang sudah kita definisikan di HomepageSettings.php
    --}}
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament-panels::form.actions :actions="$this->getFormActions()" />
        </div>
    </form>
</x-filament-panels::page>
