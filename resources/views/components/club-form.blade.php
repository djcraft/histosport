<div>
    <form wire:submit.prevent="{{ $mode === 'create' ? 'save' : 'update' }}">
        <x-form-input name="nom" label="Nom" wire:model="nom" required />
        <x-form-input name="nom_origine" label="Nom d'origine" wire:model="nom_origine" />
        <x-form-input name="surnoms" label="Surnoms" wire:model="surnoms" />
        <x-form-group class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-form-input name="date_fondation" label="Date de fondation" wire:model="date_fondation" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
            <x-form-input name="date_disparition" label="Date de disparition" wire:model="date_disparition" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
            <x-form-input name="date_declaration" label="Date de déclaration" wire:model="date_declaration" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
        </x-form-group>
        <x-form-input name="acronyme" label="Acronyme" wire:model="acronyme" />
        <x-form-input name="couleurs" label="Couleurs" wire:model="couleurs" />
        <x-form-group class="mb-4">
            <x-label>Lieu (siège)</x-label>
            <div class="flex w-full">
                <livewire:search-bar
                    entity-class="App\\Models\\Lieu"
                    :display-fields="['nom','adresse','commune','code_postal']"
                    id-field="lieu_id"
                    multi=false
                    :search-fields="['nom','adresse','commune','departement','pays']"
                    wire:model="selected_lieu_id"
                    wire:key="search-bar-lieu-{{ $mode }}"
                    class="w-full"
                />
                <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openLieuModal')">Créer un lieu</x-button>
            </div>
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Personnes associées (présence simple)</x-label>
            <livewire:search-bar
                entity-class="App\\Models\\Personne"
                display-field="nom"
                id-field="personne_id"
                multi=true
                :search-fields="['nom','prenom']"
                wire:model="selected_personne_id"
                wire:key="search-bar-personnes-{{ $mode }}"
                class="w-full"
            />
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Mandats datés</x-label>
            <div class="space-y-4">
                @foreach($clubPersonnes as $index => $clubPersonne)
                    <div class="border rounded p-3 bg-gray-50 dark:bg-gray-900">
                        <x-form-group class="mb-2">
                            <x-label value="Personne" />
                            <livewire:search-bar
                                entity-class="App\\Models\\Personne"
                                display-field="nom"
                                id-field="personne_id"
                                multi=false
                                :search-fields="['nom','prenom']"
                                wire:model="clubPersonnes.{{ $index }}.personne_id"
                                wire:key="search-bar-personne-{{ $mode }}-{{ $index }}"
                                class="w-full"
                            />
                        </x-form-group>
                        <x-form-select name="clubPersonnes.{{ $index }}.role" label="Rôle" wire:model="clubPersonnes.{{ $index }}.role">
                            <option value="">Sélectionner un rôle</option>
                            <option value="Président">Président</option>
                            <option value="Trésorier">Trésorier</option>
                            <option value="Secrétaire">Secrétaire</option>
                            <option value="Membre">Membre</option>
                            <option value="Dirigeant">Dirigeant</option>
                            <option value="Autre">Autre</option>
                        </x-form-select>
                        <x-form-group class="mb-2 grid grid-cols-2 gap-2">
                            <x-form-input name="clubPersonnes.{{ $index }}.date_debut" label="Date début" wire:model="clubPersonnes.{{ $index }}.date_debut" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
                            <x-form-input name="clubPersonnes.{{ $index }}.date_fin" label="Date fin" wire:model="clubPersonnes.{{ $index }}.date_fin" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" />
                        </x-form-group>
                        <div class="flex justify-end mt-2">
                            <x-button type="button" variant="danger" wire:click="removeClubPersonne({{ $index }})">Supprimer</x-button>
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-end">
                    <x-button type="button" variant="primary" wire:click="addClubPersonne">Ajouter une personne</x-button>
                </div>
            </div>
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Disciplines associées</x-label>
            <div class="flex w-full">
                <livewire:search-bar
                    entity-class="App\\Models\\Discipline"
                    display-field="nom"
                    id-field="discipline_id"
                    multi=true
                    :search-fields="['nom']"
                    wire:model="selected_discipline_id"
                    wire:key="search-bar-disciplines-{{ $mode }}"
                    class="w-full"
                />
                <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openDisciplineModal')">Créer une discipline</x-button>
            </div>
        </x-form-group>
        <x-form-group class="mb-4">
            <x-label>Sources</x-label>
            <div class="flex w-full">
                <livewire:search-bar
                    entity-class="App\\Models\\Source"
                    display-field="titre"
                    id-field="source_id"
                    multi=true
                    :search-fields="['titre']"
                    wire:model="selected_source_id"
                    wire:key="search-bar-sources-{{ $mode }}"
                    class="w-full"
                />
                <x-button type="button" variant="primary" class="ml-2 py-0.5 text-sm" style="align-self:flex-start;" wire:click="$dispatch('openSourceModal')">Créer une source</x-button>
            </div>
        </x-form-group>
        <x-form-textarea name="notes" label="Notes" wire:model="notes" rows="3" />
        <div class="flex justify-end">
            <x-button type="submit" variant="primary">
                {{ $mode === 'create' ? 'Enregistrer' : 'Mettre à jour' }}
            </x-button>
        </div>
    </form>
    @livewire('lieu-modal')
    @livewire('discipline-modal')
    @livewire('source-modal')
</div>
