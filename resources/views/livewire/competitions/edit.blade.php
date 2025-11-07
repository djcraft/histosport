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
                            :display-fields="['nom','adresse','commune','code_postal']"
                            id-field="lieu_id"
                            multi=false
                            :search-fields="['nom','adresse','commune','departement','pays']"
                            wire:model="lieu_id"
                            wire:key="search-bar-lieu-competition-edit"
                            class="w-full"
                        />
                        <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-button>
                    </div>
                </div>
            </div>
            <div>
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
                        wire:key="search-bar-disciplines-competition-edit"
                        class="w-full"
                    />
                    <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openDisciplineModal')">Créer une discipline</x-button>
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
                    :display-fields="['nom','prenom']"
                    id-field="personne_id"
                    multi=true
                    :search-fields="['nom','prenom']"
                    wire:model="participant_personne_ids"
                    wire:key="search-bar-participants-personne-competition-edit"
                />
                <!-- Boutons pour ouvrir le formulaire d'ajout de résultat -->
                <div class="space-y-2 mt-4">
                    <div class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Participants avec résultat :</div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($participants ?? [] as $index => $participant)
                                @if(!is_null($participant['resultat']))
                                    <x-badge class="inline-flex items-center px-3 py-1 text-xs shadow">
                                        @if($participant['type'] === 'club')
                                            {{ $participant['nom'] }}
                                        @else
                                            {{ $participant['nom'] }} {{ $participant['prenom'] }}
                                        @endif
                                        ({{ $participant['resultat'] }})
                                        <button type="button" wire:click="supprimerParticipant({{ $index }})" class="ml-1 text-red-500 hover:text-red-700 font-bold text-base px-2 py-0.5 rounded-full focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50" style="background:transparent;border:none;">&times;</button>
                                    </x-badge>
                                @endif
                        @endforeach
                    </div>
                </div>
                <div class="mt-4">
                    @if(!$showForm)
                        <x-button type="button" variant="primary" wire:click="ouvrirFormulaireClub">Ajouter un résultat club</x-button>
                        <x-button type="button" variant="success" class="ml-2" wire:click="ouvrirFormulairePersonne">Ajouter un résultat personne</x-button>
                    @endif
                    @if($showForm === 'club')
                        <div class="w-full max-w-xl mx-auto bg-white dark:bg-gray-800 p-4 rounded shadow flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 border border-blue-200 mt-4">
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
                            <x-button type="button" variant="primary" wire:click="addResultatClub">Valider</x-button>
                            <x-button type="button" variant="secondary" wire:click="fermerFormulaire">Annuler</x-button>
                        </div>
                    @elseif($showForm === 'personne')
                        <div class="w-full max-w-xl mx-auto bg-white dark:bg-gray-800 p-4 rounded shadow flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 border border-green-200 mt-4">
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
                            <x-button type="button" variant="success" wire:click="addResultatPersonne">Valider</x-button>
                            <x-button type="button" variant="secondary" wire:click="fermerFormulaire">Annuler</x-button>
                        </div>
                    @endif
                </div>
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
                    <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openSourceModal')">Créer une source</x-button>
                </div>
            </div>
            <div class="flex justify-end">
                <x-button type="submit" variant="primary">Enregistrer</x-button>
            </div>
        </form>
    </div>
    <livewire:lieu-modal />
    <livewire:discipline-modal />
    <livewire:source-modal />
</div>


