<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier la compétition</h2>
        <form wire:submit.prevent="save">
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
                            :display-fields="['nom','adresse','commune','code_postal']"
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
                        <livewire:lieu-modal wire:key="'lieu-modal-' . $resetKeyLieu" />
                    </div>
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Sites de la compétition</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Lieu"
                    :display-fields="['nom','adresse','commune','code_postal']"
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
                        :display-fields="['nom','prenom']"
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
                        :selected-items="$selectedDisciplines"
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
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Résultats des participants</label>
                <!-- Barres de recherche multi pour ajouter des clubs/personnes sans résultat -->
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Participants (clubs)</label>
                    <div class="flex items-center space-x-2">
                        <livewire:search-bar
                            entity-class="App\\Models\\Club"
                            :display-fields="['nom']"
                            id-field="club_id"
                            multi=true
                            :search-fields="['nom','acronyme']"
                            wire:model="participant_club_ids"
                            wire:key="'search-bar-participant-club-multi'"
                            class="w-full"
                        />
                    </div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 mt-4">Participants (personnes)</label>
                    <div class="flex items-center space-x-2">
                        <livewire:search-bar
                            entity-class="App\\Models\\Personne"
                            :display-fields="['nom','prenom']"
                            id-field="personne_id"
                            multi=true
                            :search-fields="['nom','prenom']"
                            wire:model="participant_personne_ids"
                            wire:key="'search-bar-participant-personne-multi'"
                            class="w-full"
                        />
                    </div>
                </div>
                <div class="space-y-2 mt-2">
                    <div class="flex flex-wrap gap-2">
                        @foreach($participants ?? [] as $index => $participant)
                            @if(!is_null($participant['resultat']))
                                <span class="inline-flex items-center bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-full px-3 py-1 text-xs shadow">
                                    <span class="inline-block font-medium mr-2">
                                        @if($participant['type'] === 'club')
                                            {{ $participant['nom'] }}
                                        @else
                                            {{ $participant['nom'] }} {{ $participant['prenom'] }}
                                        @endif
                                    </span>
                                    <span class="inline-block font-semibold cursor-pointer mr-2 underline decoration-dotted" wire:click="modifierParticipant({{ $index }})">
                                        {{ $participant['resultat'] }}
                                    </span>
                                    <button type="button" wire:click="supprimerParticipant({{ $index }})" class="ml-1 text-red-500 hover:text-red-700 font-bold text-base px-2 py-0.5 rounded-full focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50" style="background:transparent;border:none;">&times;</button>
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="mt-4">
                    @if(!$showForm)
                        <button type="button" wire:click="ouvrirFormulaireClub" class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">Ajouter un résultat club</button>
                        <button type="button" wire:click="ouvrirFormulairePersonne" class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition ml-2">Ajouter un résultat personne</button>
                    @endif
                </div>
                @if($showForm === 'club')
                    <div class="w-full max-w-xl mx-auto bg-white dark:bg-gray-800 p-4 rounded shadow flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 border border-blue-200">
                        <livewire:search-bar
                            entity-class="App\\Models\\Club"
                            :display-fields="['nom']"
                            id-field="club_id"
                            :multi="false"
                            :search-fields="['nom','acronyme']"
                            wire:model="selectedParticipantId"
                            wire:key="'search-bar-add-resultat-club'"
                        />
                        <input type="text" wire:model.defer="resultatParticipant" placeholder="Résultat" class="px-3 py-2 border rounded text-sm w-40 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                        <button type="button" wire:click="addResultatClub" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600 transition">Valider</button>
                        <button type="button" wire:click="fermerFormulaire" class="px-4 py-2 bg-gray-300 text-gray-700 rounded shadow hover:bg-gray-400 transition">Annuler</button>
                    </div>
                @endif
                @if($showForm === 'personne')
                    <div class="w-full max-w-xl mx-auto bg-white dark:bg-gray-800 p-4 rounded shadow flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 border border-green-200">
                        <livewire:search-bar
                            entity-class="App\\Models\\Personne"
                            :display-fields="['nom','prenom']"
                            id-field="personne_id"
                            :multi="false"
                            :search-fields="['nom','prenom']"
                            wire:model="selectedParticipantId"
                            wire:key="'search-bar-add-resultat-personne'"
                        />
                        <input type="text" wire:model.defer="resultatParticipant" placeholder="Résultat" class="px-3 py-2 border rounded text-sm w-40 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                        <button type="button" wire:click="addResultatPersonne" class="px-4 py-2 bg-green-500 text-white rounded shadow hover:bg-green-600 transition">Valider</button>
                        <button type="button" wire:click="fermerFormulaire" class="px-4 py-2 bg-gray-300 text-gray-700 rounded shadow hover:bg-gray-400 transition">Annuler</button>
                    </div>
                @endif
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

