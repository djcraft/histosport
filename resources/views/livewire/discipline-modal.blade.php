<div>
    @if($show)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100">Créer une discipline</h3>
            <form wire:submit.prevent="save">
                <x-form-elements.form-input name="nom" label="Nom" wire:model.defer="nom" autofocus />
                @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                <x-form-elements.form-group class="mb-4">
                    <x-form-elements.form-textarea name="description" label="Description" wire:model.defer="description" rows="3" />
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </x-form-elements.form-group>
                <div class="flex justify-end gap-2 mt-4">
                    <x-buttons.button type="submit" variant="primary">Créer</x-buttons.button>
                    <x-buttons.button type="button" variant="secondary" wire:click="$set('show', false)">Annuler</x-buttons.button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
