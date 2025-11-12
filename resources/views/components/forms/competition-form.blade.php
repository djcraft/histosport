<div>
    <form wire:submit.prevent="{{ $mode === 'create' ? 'save' : 'update' }}">
    <x-form-elements.form-input name="nom" label="Nom" wire:model.defer="nom" required />
    <x-form-elements.form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-elements.form-input name="date" label="Date" wire:model.defer="date" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
            <x-form-elements.form-group>
                <x-label>Lieu principal</x-label>
                <div class="flex w-full">
                    <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" id-field="lieu_id" multi=false :search-fields="['nom','adresse','commune','departement','pays']" wire:model="lieu_id" wire:key="search-bar-lieu-competition-{{ $mode }}" class="w-full" />
                    <x-buttons.button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-buttons.button>
                </div>
            </x-form-group>
        </x-form-group>
    <x-form-elements.form-group class="md:col-span-2">
            <x-label>Sites de la compétition</x-label>
            <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" id-field="lieu_id" multi=true :search-fields="['nom','adresse','commune','departement','pays']" wire:model="site_ids" wire:key="search-bar-sites-competition-{{ $mode }}" class="w-full lg:w-[700px]" />
        </x-form-group>
    <x-form-elements.form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-elements.form-group>
                <x-label>Organisateur (club)</x-label>
                <livewire:search-bar entity-class="App\\Models\\Club" display-field="nom" id-field="club_id" multi=false :search-fields="['nom','acronyme']" wire:model="organisateur_club_id" wire:key="search-bar-organisateur-club-competition-{{ $mode }}" />
            </x-form-group>
            <x-form-elements.form-group>
                <x-label>Organisateur (personne)</x-label>
                <livewire:search-bar entity-class="App\\Models\\Personne" :display-fields="['nom','prenom']" id-field="personne_id" multi=false :search-fields="['nom','prenom']" wire:model="organisateur_personne_id" wire:key="search-bar-organisateur-personne-competition-{{ $mode }}" />
            </x-form-group>
        </x-form-group>
    <x-form-elements.form-group class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-form-elements.form-input name="type" label="Type" wire:model.defer="type" />
            <x-form-elements.form-input name="duree" label="Durée" wire:model.defer="duree" />
            <x-form-elements.form-input name="niveau" label="Niveau" wire:model.defer="niveau" />
        </x-form-group>
    <x-form-elements.form-group class="mb-4">
            <x-label>Disciplines</x-label>
            <div class="flex w-full">
                <livewire:search-bar entity-class="App\\Models\\Discipline" display-field="nom" id-field="discipline_id" multi=true :search-fields="['nom']" wire:model="discipline_ids" wire:key="search-bar-disciplines-competition-{{ $mode }}" class="w-full" />
                <x-buttons.button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openDisciplineModal')">Créer une discipline</x-buttons.button>
            </div>
        </x-form-group>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300 mb-2">Résultats des participants</label>
        <!-- Barres de recherche multi pour ajouter des clubs/personnes sans résultat -->
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <x-label>Participants (clubs)</x-label>
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
            <x-label class="mt-4">Participants (personnes)</x-label>
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
            <x-label>Participants avec résultat</x-label>
            <div class="flex flex-wrap gap-2">
                @foreach($this->participants as $index => $participant)
                    @if(!is_null($participant['resultat']))
                        <x-badges.badge>
                            @if($participant['type'] === 'club')
                                {{ $participant['nom'] }}
                            @else
                                {{ $participant['nom'] }} {{ $participant['prenom'] }}
                            @endif
                            <span class="font-semibold cursor-pointer underline decoration-dotted ml-1" wire:click="modifierParticipant({{ $index }})">
                                {{ $participant['resultat'] }}
                            </span>
                            <button type="button" wire:click="supprimerParticipant({{ $index }})" class="ml-1 text-red-500 hover:text-red-700 font-bold text-xs px-1 py-0 rounded-full focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50" style="background:transparent;border:none;">&times;</button>
                        </x-badges.badge>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="mt-4">
            @isset($showForm)
                @if(!$showForm)
                    <button type="button" wire:click="ouvrirFormulaireClub" class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">Ajouter un résultat club</button>
                    <button type="button" wire:click="ouvrirFormulairePersonne" class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition ml-2">Ajouter un résultat personne</button>
                @endif
            @endisset
        </div>
        @isset($showForm)
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
                    <button type="button" wire:click="fermerFormulaire" class="px-4 py-2 text-base bg-red-500 text-white rounded shadow hover:bg-red-600 transition">Annuler</button>
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
                    <button type="button" wire:click="fermerFormulaire" class="px-4 py-2 text-base bg-red-500 text-white rounded shadow hover:bg-red-600 transition">Annuler</button>
                </div>
            @endif
        @endisset
    </div>
    <x-form-elements.form-group class="mb-4">
            <x-label>Sources</x-label>
            <div class="flex w-full">
                <livewire:search-bar entity-class="App\\Models\\Source" display-field="titre" id-field="source_id" multi=true :search-fields="['titre','auteur']" wire:model="sources" wire:key="search-bar-sources-competition-{{ $mode }}" class="w-full" />
                <x-buttons.button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openSourceModal')">Créer une source</x-buttons.button>
            </div>
        </x-form-group>
        <div class="flex justify-end">
            <x-buttons.button type="submit" variant="primary">
                {{ $mode === 'create' ? 'Enregistrer' : 'Mettre à jour' }}
            </x-button>
        </div>
    </form>
    <livewire:lieu-modal />
    <livewire:discipline-modal />
    <livewire:source-modal />
</div>
