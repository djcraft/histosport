
<div>
    <x-modal :show="$show" title="Créer une discipline">
        <form wire:submit.prevent="save">
            <x-form-input name="nom" label="Nom" wire:model.defer="nom" autofocus />
            @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <x-form-group class="mb-4">
                <x-form-textarea name="description" label="Description" wire:model.defer="description" rows="3" />
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </x-form-group>
            <div class="flex justify-end gap-2 mt-4">
                <x-button type="submit" variant="primary">Créer</x-button>
                <x-button type="button" variant="secondary" wire:click="$set('show', false)">Annuler</x-button>
            </div>
        </form>
    </x-modal>
</div>
