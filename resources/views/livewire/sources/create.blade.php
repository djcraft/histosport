<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Créer une source</h2>
        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Titre</label>
                <input type="text" wire:model="titre" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Auteur</label>
                <input type="text" wire:model="auteur" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Année de référence</label>
                    <input type="text" wire:model="annee_reference" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Type</label>
                    <input type="text" wire:model="type" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Cote</label>
                    <input type="text" wire:model="cote" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">URL</label>
                    <input type="text" wire:model="url" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu d'édition</label>
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
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu de conservation</label>
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
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu de couverture</label>
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
                </div>
            </div>
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

