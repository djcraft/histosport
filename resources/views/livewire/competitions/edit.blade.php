<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier la compétition</h2>
        <form wire:submit.prevent="update">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Nom</label>
                <input type="text" wire:model.defer="nom" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" required>
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Date</label>
                    <input type="text" wire:model.defer="date" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu principal</label>
                    <div class="flex w-full">
                        <livewire:search-bar
                            entity-class="App\\Models\\Lieu"
                            :display-fields="['nom','adresse','commune','departement','pays']"
                            id-field="lieu_id"
                            multi=false
                            :search-fields="['nom','adresse','commune','departement','pays']"
                            wire:model="lieu_id"
                            wire:key="search-bar-lieu-competition-edit"
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
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Sites de la compétition</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Lieu"
                    :display-fields="['nom','adresse','commune','departement','pays']"
                    id-field="lieu_id"
                    multi=true
                    :search-fields="['nom','adresse','commune','departement','pays']"
                    wire:model="site_ids"
                    wire:key="search-bar-sites-competition-edit"
                    class="w-full lg:w-[700px]"
                />
            </div>
            <div class="mb-2">
                <div class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded px-3 py-2 mb-2 text-sm">
                    Un seul organisateur peut être sélectionné : soit un club, soit une personne. Si vous choisissez les deux, l’enregistrement sera refusé.
                </div>
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Organisateur (club)</label>
                    <livewire:search-bar
                        entity-class="App\\Models\\Club"
                        display-field="nom"
                        id-field="club_id"
                        multi=false
                        :search-fields="['nom','acronyme']"
                        wire:model="organisateur_club_id"
                        wire:key="'search-bar-organisateur-club-competition-edit-' . ($organisateur_personne_id ?? 'none')"
                    />
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Organisateur (personne)</label>
                    <livewire:search-bar
                        entity-class="App\\Models\\Personne"
                        display-field="nom"
                        id-field="personne_id"
                        multi=false
                        :search-fields="['nom','prenom']"
                        wire:model="organisateur_personne_id"
                        wire:key="'search-bar-organisateur-personne-competition-edit-' . ($organisateur_club_id ?? 'none')"
                    />
                </div>
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Type</label>
                    <input type="text" wire:model.defer="type" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Durée</label>
                    <input type="text" wire:model.defer="duree" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Niveau</label>
                    <input type="text" wire:model.defer="niveau" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
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
                        wire:model="discipline_ids"
                        wire:key="search-bar-disciplines-competition-edit"
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
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Participants (clubs)</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Club"
                    display-field="nom"
                    id-field="club_id"
                    multi=true
                    :search-fields="['nom','acronyme']"
                    wire:model="participant_club_ids"
                    wire:key="search-bar-participants-club-competition-edit"
                />
                <label class="block text-gray-700 dark:text-gray-300 mb-2 mt-4">Participants (personnes)</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Personne"
                    display-field="nom"
                    id-field="personne_id"
                    multi=true
                    :search-fields="['nom','prenom']"
                    wire:model="participant_personne_ids"
                    wire:key="search-bar-participants-personne-competition-edit"
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
                        wire:key="search-bar-sources-competition-edit"
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
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Enregistrer</button>
            </div>
        </form>
    </div>
<livewire:lieu-modal />
<livewire:discipline-modal />
<livewire:source-modal />
</div>

