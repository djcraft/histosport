
<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier un lieu</h2>
        <form wire:submit.prevent="update">
            <x-form-input name="nom" label="Nom" wire:model="nom" required />
            <x-form-input name="adresse" label="Adresse" wire:model="adresse" />
            <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-form-input name="code_postal" label="Code postal" wire:model="code_postal" />
                <x-form-input name="commune" label="Commune" wire:model="commune" />
                <x-form-input name="departement" label="Département" wire:model="departement" />
                <x-form-input name="pays" label="Pays" wire:model="pays" />
            </x-form-group>
            <div class="flex justify-end">
                <x-button type="submit" variant="primary">Mettre à jour</x-button>
            </div>
        </form>
    </div>
</div>
