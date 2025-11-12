<div>
    @if($show)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-xl">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Créer une source</h2>
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Titre</label>
                    <input type="text" wire:model.defer="titre" placeholder="Titre de la source" autofocus
                        class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    @error('titre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Auteur</label>
                    <input type="text" wire:model.defer="auteur" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    @error('auteur') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Année de référence</label>
                    <input type="text" wire:model.defer="annee_reference" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ"
                        class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    @error('annee_reference') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Type</label>
                        <input type="text" wire:model.defer="type" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Cote</label>
                        <input type="text" wire:model.defer="cote" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        @error('cote') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">URL</label>
                    <input type="text" wire:model.defer="url" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu d'édition</label>
                        <livewire:search-bar
                            entity-class="App\\Models\\Lieu"
                            :display-fields="['nom','adresse','commune','departement','pays']"
                            id-field="lieu_id"
                            multi=false
                            :search-fields="['nom','adresse','commune','departement','pays']"
                            wire:model="lieu_edition_id"
                            wire:key="search-bar-lieu-edition-source-modal"
                            class="w-full"
                        />
                        @error('lieu_edition_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu de conservation</label>
                        <livewire:search-bar
                            entity-class="App\\Models\\Lieu"
                            :display-fields="['nom','adresse','commune','departement','pays']"
                            id-field="lieu_id"
                            multi=false
                            :search-fields="['nom','adresse','commune','departement','pays']"
                            wire:model="lieu_conservation_id"
                            wire:key="search-bar-lieu-conservation-source-modal"
                            class="w-full"
                        />
                        @error('lieu_conservation_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu de couverture</label>
                        <livewire:search-bar
                            entity-class="App\\Models\\Lieu"
                            :display-fields="['nom','adresse','commune','departement','pays']"
                            id-field="lieu_id"
                            multi=false
                            :search-fields="['nom','adresse','commune','departement','pays']"
                            wire:model="lieu_couverture_id"
                            wire:key="search-bar-lieu-couverture-source-modal"
                            class="w-full"
                        />
                        @error('lieu_couverture_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Créer</button>
                    <button type="button" wire:click="$dispatch('openLieuModal')" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Créer un lieu</button>
                    <button type="button" wire:click="$set('show', false)" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Annuler</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
