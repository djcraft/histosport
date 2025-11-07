<div>
    <form wire:submit.prevent="{{ $mode === 'create' ? 'save' : 'update' }}">
        <x-form-input name="nom" label="Nom" wire:model="nom" required />
        @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        <x-form-group class="mb-4">
            <x-form-textarea name="description" label="Description" wire:model="description" rows="3" />
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </x-form-group>
        <div class="flex justify-end">
            <x-button type="submit" variant="primary">
                {{ $mode === 'create' ? 'Enregistrer' : 'Mettre à jour' }}
            </x-button>
        </div>
    </form>
</div>
