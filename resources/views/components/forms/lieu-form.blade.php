<div>
    <form wire:submit.prevent="{{ $mode === 'create' ? 'save' : 'update' }}">
    <x-form-elements.form-input name="nom" label="Nom" wire:model="nom" />
    <x-form-elements.form-input name="adresse" label="Adresse" wire:model="adresse" />
    <x-form-elements.form-group class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-form-elements.form-input name="code_postal" label="Code postal" wire:model="code_postal" />
        <x-form-elements.form-input name="commune" label="Commune" wire:model="commune" />
        <x-form-elements.form-input name="departement" label="Département" wire:model="departement" />
        <x-form-elements.form-input name="pays" label="Pays" wire:model="pays" />
        </x-form-group>
        <div class="flex justify-end">
            <x-buttons.button type="submit" variant="primary">
                {{ $mode === 'create' ? 'Enregistrer' : 'Mettre à jour' }}
            </x-button>
        </div>
    </form>
</div>
