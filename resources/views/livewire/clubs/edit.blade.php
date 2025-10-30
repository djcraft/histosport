<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier un club</h2>
        <form wire:submit.prevent="update">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Nom</label>
                <input type="text" wire:model="nom" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Nom d'origine</label>
                <input type="text" wire:model="nom_origine" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Surnoms</label>
                <input type="text" wire:model="surnoms" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Date de fondation</label>
                    <input type="text" wire:model="date_fondation" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Date de disparition</label>
                    <input type="text" wire:model="date_disparition" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Date de déclaration</label>
                    <input type="text" wire:model="date_declaration" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Acronyme</label>
                <input type="text" wire:model="acronyme" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Couleurs</label>
                <input type="text" wire:model="couleurs" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu (siège)</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Lieu"
                    display-field="adresse"
                    id-field="lieu_id"
                    multi=false
                    :search-fields="['adresse','commune','departement','pays']"
                    wire:model="selected_lieu_id"
                    wire:key="search-bar-lieu"
                    class="w-full"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Personnes associées</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Personne"
                    display-field="nom"
                    id-field="personne_id"
                    multi=true
                    :search-fields="['nom','prenom']"
                    wire:model="selected_personne_id"
                    wire:key="search-bar-personnes"
                    class="w-full"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Disciplines associées</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Discipline"
                    display-field="nom"
                    id-field="discipline_id"
                    multi=true
                    :search-fields="['nom']"
                    wire:model="selected_discipline_id"
                    wire:key="search-bar-disciplines"
                    class="w-full"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Sources</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Source"
                    display-field="titre"
                    id-field="source_id"
                    multi=true
                    :search-fields="['titre']"
                    wire:model="selected_source_id"
                    wire:key="search-bar-sources"
                    class="w-full"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                <textarea wire:model="notes" rows="3" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
