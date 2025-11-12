
<div>
    <x-modals.modal :show="$show" title="Créer une discipline">
        <form wire:submit.prevent="save">
            <x-form-elements.form-input name="nom" label="Nom" wire:model.defer="nom" autofocus />
            @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <x-form-elements.form-group class="mb-4">
                <x-form-elements.form-textarea name="description" label="Description" wire:model.defer="description" rows="3" />
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </x-form-group>
            <div class="flex justify-end gap-2 mt-4">
                <x-buttons.button type="submit" variant="primary">Créer</x-buttons.button>
                <x-buttons.button type="button" variant="secondary" wire:click="$set('show', false)">Annuler</x-buttons.button>
            </div>
        </form>
    </x-modal>
</div>
