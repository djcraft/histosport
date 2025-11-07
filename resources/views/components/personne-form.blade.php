<div>
    <form wire:submit.prevent="{{ $mode === 'create' ? 'save' : 'update' }}">
        <x-form-input name="nom" label="Nom" wire:model="nom" required />
        <x-form-input name="prenom" label="Prénom" wire:model="prenom" />
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-input name="date_naissance" label="Date de naissance" wire:model="date_naissance" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
            <x-form-group>
                <x-label>Lieu de naissance</x-label>
                <div class="flex w-full">
                    <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" id-field="lieu_id" multi=false :search-fields="['nom','adresse','commune','departement','pays']" wire:model="lieu_naissance_id" wire:key="search-bar-lieu-naissance-personne-{{ $mode }}" class="w-full" />
                    <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-button>
                </div>
            </x-form-group>
        </x-form-group>
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-input name="date_deces" label="Date de décès" wire:model="date_deces" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
            <x-form-group>
                <x-label>Lieu de décès</x-label>
                <div class="flex w-full">
                    <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" id-field="lieu_id" multi=false :search-fields="['nom','adresse','commune','departement','pays']" wire:model="lieu_deces_id" wire:key="search-bar-lieu-deces-personne-{{ $mode }}" class="w-full" />
                    <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-button>
                </div>
            </x-form-group>
        </x-form-group>
        <x-form-select name="sexe" label="Sexe" wire:model="sexe">
            <option value="">Sélectionner</option>
            <option value="M">Masculin</option>
            <option value="F">Féminin</option>
            <option value="X">Autre</option>
        </x-form-select>
        <x-form-input name="titre" label="Titre" wire:model="titre" />
        <x-form-group class="mb-4">
            <x-label>Adresse</x-label>
            <div class="flex w-full">
                <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','departement','pays']" id-field="lieu_id" multi=false :search-fields="['adresse','commune','departement','pays']" wire:model="adresse_id" wire:key="search-bar-adresse-personne-{{ $mode }}" class="w-full" />
                <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-button>
            </div>
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Disciplines</x-label>
            <div class="flex w-full">
                <livewire:search-bar entity-class="App\\Models\\Discipline" display-field="nom" id-field="discipline_id" multi=true :search-fields="['nom']" wire:model="disciplines" wire:key="search-bar-disciplines-personne-{{ $mode }}" class="w-full" />
                <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openDisciplineModal')">Créer une discipline</x-button>
            </div>
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Clubs</x-label>
            <livewire:search-bar entity-class="App\\Models\\Club" display-field="nom" id-field="club_id" multi=true :search-fields="['nom','acronyme']" wire:model="clubs" wire:key="search-bar-clubs-personne-{{ $mode }}" />
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Sources</x-label>
            <div class="flex w-full">
                <livewire:search-bar entity-class="App\\Models\\Source" display-field="titre" id-field="source_id" multi=true :search-fields="['titre','auteur']" wire:model="sources" wire:key="search-bar-sources-personne-{{ $mode }}" class="w-full" />
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
