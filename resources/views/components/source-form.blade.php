<div>
    <form wire:submit.prevent="{{ $mode === 'create' ? 'save' : 'update' }}">
        <x-form-input name="titre" label="Titre" wire:model="titre" required />
        <x-form-input name="auteur" label="Auteur" wire:model="auteur" />
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-input name="annee_reference" label="Année de référence" wire:model="annee_reference" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
            <x-form-input name="type" label="Type" wire:model="type" />
        </x-form-group>
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-input name="cote" label="Cote" wire:model="cote" />
            <x-form-input name="url" label="URL" wire:model="url" />
        </x-form-group>
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-form-group>
                <x-label>Lieu d'édition</x-label>
                <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" display-field="nom" id-field="lieu_id" multi=false :search-fields="['nom','adresse','commune','departement','pays','code_postal']" wire:model="lieu_edition_id" wire:key="search-bar-lieu-edition-source-{{ $mode }}" class="w-full" />
            </x-form-group>
            <x-form-group>
                <x-label>Lieu de conservation</x-label>
                <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" display-field="nom" id-field="lieu_id" multi=false :search-fields="['nom','adresse','commune','departement','pays','code_postal']" wire:model="lieu_conservation_id" wire:key="search-bar-lieu-conservation-source-{{ $mode }}" class="w-full" />
            </x-form-group>
            <x-form-group>
                <x-label>Lieu de couverture</x-label>
                <livewire:search-bar entity-class="App\\Models\\Lieu" :display-fields="['nom','adresse','commune','code_postal']" display-field="nom" id-field="lieu_id" multi=false :search-fields="['nom','adresse','commune','departement','pays','code_postal']" wire:model="lieu_couverture_id" wire:key="search-bar-lieu-couverture-source-{{ $mode }}" class="w-full" />
            </x-form-group>
        </x-form-group>
        <div class="flex justify-end gap-2">
            <x-button type="submit" variant="primary">
                {{ $mode === 'create' ? 'Enregistrer' : 'Mettre à jour' }}
            </x-button>
            <x-button type="button" variant="success" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-button>
        </div>
    </form>
    <livewire:lieu-modal />
    <livewire:discipline-modal />
    <livewire:source-modal />
</div>
