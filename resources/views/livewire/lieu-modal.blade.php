
<div>
    <x-modal :show="$show" title="Créer un lieu">
        <form wire:submit.prevent="save">
            <x-form-input name="nom" label="Nom" wire:model.defer="nom" autofocus />
            @error('nom') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            <x-form-input name="adresse" label="Adresse" wire:model.defer="adresse" />
            @error('adresse') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-input name="code_postal" label="Code postal" wire:model.defer="code_postal" />
                @error('code_postal') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                <x-form-input name="commune" label="Commune" wire:model.defer="commune" />
                @error('commune') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </x-form-group>
            <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-input name="departement" label="Département" wire:model.defer="departement" />
                @error('departement') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                <x-form-input name="pays" label="Pays" wire:model.defer="pays" />
                @error('pays') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </x-form-group>
            <div class="mt-4 flex gap-2 justify-end">
                <x-button type="submit" variant="primary">Créer</x-button>
                <x-button type="button" variant="secondary" wire:click="$set('show', false)">Annuler</x-button>
            </div>
        </form>
    </x-modal>
</div>
