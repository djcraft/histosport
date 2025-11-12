<div>
    @if($show)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100">Créer un lieu</h3>
            <form wire:submit.prevent="save">
                <x-form-elements.form-input name="nom" label="Nom" wire:model.defer="nom" autofocus />
                @error('nom') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                <x-form-elements.form-input name="adresse" label="Adresse" wire:model.defer="adresse" />
                @error('adresse') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                <x-form-elements.form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-elements.form-input name="code_postal" label="Code postal" wire:model.defer="code_postal" />
                    @error('code_postal') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    <x-form-elements.form-input name="commune" label="Commune" wire:model.defer="commune" />
                    @error('commune') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </x-form-group>
                <x-form-elements.form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-elements.form-input name="departement" label="Département" wire:model.defer="departement" />
                    @error('departement') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    <x-form-elements.form-input name="pays" label="Pays" wire:model.defer="pays" />
                    @error('pays') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </x-form-group>
                <div class="mt-4 flex gap-2 justify-end">
                    <x-buttons.button type="submit" variant="primary">Créer</x-buttons.button>
                    <x-buttons.button type="button" variant="secondary" wire:click="$set('show', false)">Annuler</x-buttons.button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
