<div>
    <form wire:submit.prevent="{{ $mode === 'create' ? 'save' : 'update' }}">
        <x-form-input name="nom" label="Nom" wire:model.defer="nom" required />
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-input name="date" label="Date" wire:model.defer="date" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
            <x-form-group>
                <x-label>Lieu principal</x-label>
                <div class="flex w-full">
                    <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" id-field="lieu_id" multi=false :search-fields="['nom','adresse','commune','departement','pays']" wire:model="lieu_id" wire:key="search-bar-lieu-competition-{{ $mode }}" class="w-full" />
                    <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-button>
                </div>
            </x-form-group>
        </x-form-group>
        <x-form-group class="md:col-span-2">
            <x-label>Sites de la compétition</x-label>
            <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" id-field="lieu_id" multi=true :search-fields="['nom','adresse','commune','departement','pays']" wire:model="site_ids" wire:key="search-bar-sites-competition-{{ $mode }}" class="w-full lg:w-[700px]" />
        </x-form-group>
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-group>
                <x-label>Organisateur (club)</x-label>
                <livewire:search-bar entity-class="App\\Models\\Club" display-field="nom" id-field="club_id" multi=false :search-fields="['nom','acronyme']" wire:model="organisateur_club_id" wire:key="search-bar-organisateur-club-competition-{{ $mode }}" />
            </x-form-group>
            <x-form-group>
                <x-label>Organisateur (personne)</x-label>
                <livewire:search-bar entity-class="App\\Models\\Personne" :display-fields="['nom','prenom']" id-field="personne_id" multi=false :search-fields="['nom','prenom']" wire:model="organisateur_personne_id" wire:key="search-bar-organisateur-personne-competition-{{ $mode }}" />
            </x-form-group>
        </x-form-group>
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-form-input name="type" label="Type" wire:model.defer="type" />
            <x-form-input name="duree" label="Durée" wire:model.defer="duree" />
            <x-form-input name="niveau" label="Niveau" wire:model.defer="niveau" />
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Disciplines</x-label>
            <div class="flex w-full">
                <livewire:search-bar entity-class="App\\Models\\Discipline" display-field="nom" id-field="discipline_id" multi=true :search-fields="['nom']" wire:model="discipline_ids" wire:key="search-bar-disciplines-competition-{{ $mode }}" class="w-full" />
                <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openDisciplineModal')">Créer une discipline</x-button>
            </div>
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Participants (clubs)</x-label>
            <livewire:search-bar entity-class="App\\Models\\Club" display-field="nom" id-field="club_id" multi=true :search-fields="['nom','acronyme']" wire:model="participant_club_ids" wire:key="search-bar-participants-club-competition-{{ $mode }}" />
            <x-label class="mt-4">Participants (personnes)</x-label>
            <livewire:search-bar entity-class="App\\Models\\Personne" :display-fields="['nom','prenom']" id-field="personne_id" multi=true :search-fields="['nom','prenom']" wire:model="participant_personne_ids" wire:key="search-bar-participants-personne-competition-{{ $mode }}" />
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Sources</x-label>
            <div class="flex w-full">
                <livewire:search-bar entity-class="App\\Models\\Source" display-field="titre" id-field="source_id" multi=true :search-fields="['titre','auteur']" wire:model="sources" wire:key="search-bar-sources-competition-{{ $mode }}" class="w-full" />
                <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openSourceModal')">Créer une source</x-button>
            </div>
        </x-form-group>
        <div class="flex justify-end">
            <x-button type="submit" variant="primary">
                {{ $mode === 'create' ? 'Enregistrer' : 'Mettre à jour' }}
            </x-button>
        </div>
    </form>
    <livewire:lieu-modal />
    <livewire:discipline-modal />
    <livewire:source-modal />
</div>
