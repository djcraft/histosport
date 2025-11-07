<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Créer une source</h2>
        <form wire:submit.prevent="save">
            <x-form-input name="titre" label="Titre" wire:model="titre" required />
            <x-form-input name="auteur" label="Auteur" wire:model="auteur" />
            <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-input name="annee_reference" label="Année de référence" wire:model="annee_reference" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
                <x-form-input name="type" label="Type" wire:model="type" />
            </x-form-group>
            <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-input name="cote" label="Cote" wire:model="cote" />
                <x-form-input name="url" label="URL" wire:model="url" />
            </x-form-group>
            <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-form-group>
                    <x-label>Lieu d'édition</x-label>
                    <livewire:search-bar
                        entity-class="App\\Models\\Lieu"
                        :display-fields="['nom','adresse','commune','code_postal']"
                        display-field="nom"
                        id-field="lieu_id"
                        multi=false
                        :search-fields="['nom','adresse','commune','departement','pays','code_postal']"
                        wire:model="lieu_edition_id"
                        wire:key="search-bar-lieu-edition-source-create"
                        class="w-full"
                    />
                </x-form-group>
                <x-form-group>
                    <x-label>Lieu de conservation</x-label>
                    <livewire:search-bar
                        entity-class="App\\Models\\Lieu"
                        :display-fields="['nom','adresse','commune','code_postal']"
                        display-field="nom"
                        id-field="lieu_id"
                        multi=false
                        :search-fields="['nom','adresse','commune','departement','pays','code_postal']"
                        wire:model="lieu_conservation_id"
                        wire:key="search-bar-lieu-conservation-source-create"
                        class="w-full"
                    />
                </x-form-group>
                <x-form-group>
                    <x-label>Lieu de couverture</x-label>
                    <livewire:search-bar
                        entity-class="App\\Models\\Lieu"
                        :display-fields="['nom','adresse','commune','code_postal']"
                        display-field="nom"
                        id-field="lieu_id"
                        multi=false
                        :search-fields="['nom','adresse','commune','departement','pays','code_postal']"
                        wire:model="lieu_couverture_id"
                        wire:key="search-bar-lieu-couverture-source-create"
                        class="w-full"
                    />
                </x-form-group>
            </x-form-group>
            <div class="flex justify-end gap-2">
                <x-button type="submit" variant="primary">Enregistrer</x-button>
                <x-button type="button" variant="success" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-button>
            </div>
        </form>
    </div>
<livewire:lieu-modal />
<livewire:discipline-modal />
<livewire:source-modal />
</div>

