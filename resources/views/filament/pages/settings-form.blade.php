<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="pt-6 border-t border-gray-200 dark:border-white/10">
            <x-filament-panels::form.actions 
                :actions="$this->getFormActions()" 
            />
        </div>
        
    </form>
</x-filament-panels::page>