<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier une personne</h2>
        <form wire:submit.prevent="update">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Nom</label>
                <input type="text" wire:model="nom" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Prénom</label>
                <input type="text" wire:model="prenom" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Date de naissance</label>
                    <input type="text" wire:model="date_naissance" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu de naissance</label>
                    <div class="flex w-full">
                        <livewire:search-bar
                            entity-class="App\\Models\\Lieu"
                            :display-fields="['nom','adresse','commune','departement','pays']"
                            id-field="lieu_id"
                            multi=false
                            :search-fields="['nom','adresse','commune','departement','pays']"
                            wire:model="lieu_naissance_id"
                            wire:key="search-bar-lieu-naissance-personne-edit"
                            class="w-full"
                        />
                        <button type="button"
                            wire:click="$dispatch('openLieuModal')"
                            class="ml-2 px-3 py-0.5 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                            style="align-self:flex-start;"
                        >
                            Créer un lieu
                        </button>
                    </div>
                </div>
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Date de décès</label>
                    <input type="text" wire:model="date_deces" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu de décès</label>
                    <div class="flex w-full">
                        <livewire:search-bar
                            entity-class="App\\Models\\Lieu"
                            :display-fields="['nom','adresse','commune','departement','pays']"
                            id-field="lieu_id"
                            multi=false
                            :search-fields="['nom','adresse','commune','departement','pays']"
                            wire:model="lieu_deces_id"
                            wire:key="search-bar-lieu-deces-personne-edit"
                            class="w-full"
                        />
                        <button type="button"
                            wire:click="$dispatch('openLieuModal')"
                            class="ml-2 px-3 py-0.5 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                            style="align-self:flex-start;"
                        >
                            Créer un lieu
                        </button>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Sexe</label>
                <select wire:model="sexe" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">Sélectionner</option>
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                    <option value="X">Autre</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Titre</label>
                <input type="text" wire:model="titre" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Adresse</label>
                <div class="flex w-full">
                    <livewire:search-bar
                        entity-class="App\\Models\\Lieu"
                        :display-fields="['nom','adresse','commune','departement','pays']"
                        id-field="lieu_id"
                        multi=false
                        :search-fields="['adresse','commune','departement','pays']"
                        wire:model="adresse_id"
                        wire:key="search-bar-adresse-personne-edit"
                        class="w-full"
                    />
                    <button type="button"
                        wire:click="$dispatch('openLieuModal')"
                        class="ml-2 px-3 py-0.5 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        style="align-self:flex-start;"
                    >
                        Créer un lieu
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Disciplines</label>
                <div class="flex w-full">
                    <livewire:search-bar
                        entity-class="App\\Models\\Discipline"
                        display-field="nom"
                        id-field="discipline_id"
                        multi=true
                        :search-fields="['nom']"
                        wire:model="disciplines"
                        wire:key="search-bar-disciplines-personne-edit"
                        class="w-full"
                    />
                    <button type="button"
                        wire:click="$dispatch('openDisciplineModal')"
                        class="ml-2 px-3 py-0.5 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        style="align-self:flex-start;"
                    >
                        Créer une discipline
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Clubs</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Club"
                    display-field="nom"
                    id-field="club_id"
                    multi=true
                    :search-fields="['nom','acronyme']"
                    wire:model="clubs"
                    wire:key="search-bar-clubs-personne-edit"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Sources</label>
                <div class="flex w-full">
                    <livewire:search-bar
                        entity-class="App\\Models\\Source"
                        display-field="titre"
                        id-field="source_id"
                        multi=true
                        :search-fields="['titre','auteur']"
                        wire:model="sources"
                        wire:key="search-bar-sources-personne-edit"
                        class="w-full"
                    />
                    <button type="button"
                        wire:click="$dispatch('openSourceModal')"
                        class="ml-2 px-3 py-0.5 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        style="align-self:flex-start;"
                    >
                        Créer une source
                    </button>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Mettre à jour</button>
            </div>
        </form>
    </div>
<livewire:lieu-modal />
<livewire:discipline-modal />
<livewire:source-modal />
</div>

