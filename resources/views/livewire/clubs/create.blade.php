<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Créer un club</h2>
        <form wire:submit.prevent="save">
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
                <div class="flex w-full">
                    <livewire:search-bar
                        entity-class="App\\Models\\Lieu"
                        :display-fields="['nom','adresse','commune','code_postal']"
                        id-field="lieu_id"
                        multi=false
                        :search-fields="['nom','adresse','commune','departement','pays']"
                        wire:model="selected_lieu_id"
                        wire:key="search-bar-lieu-create"
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
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Personnes associées (présence simple)</label>
                <livewire:search-bar
                    entity-class="App\\Models\\Personne"
                    display-field="nom"
                    id-field="personne_id"
                    multi=true
                    :search-fields="['nom','prenom']"
                    wire:model="selected_personne_id"
                    wire:key="search-bar-personnes-create"
                    class="w-full"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Mandats datés</label>
                <div class="space-y-4">
                    @foreach($clubPersonnes as $index => $clubPersonne)
                        <div class="border rounded p-3 bg-gray-50 dark:bg-gray-900">
                            <div class="mb-2">
                                <label class="block text-gray-700 dark:text-gray-300 mb-1">Personne</label>
                                <livewire:search-bar
                                    entity-class="App\\Models\\Personne"
                                    display-field="nom"
                                    id-field="personne_id"
                                    multi=false
                                    :search-fields="['nom','prenom']"
                                    wire:model="clubPersonnes.{{ $index }}.personne_id"
                                    wire:key="search-bar-personne-create-{{ $index }}"
                                    class="w-full"
                                />
                            </div>
                            <div class="mb-2">
                                <label class="block text-gray-700 dark:text-gray-300 mb-1">Rôle</label>
                                <select wire:model="clubPersonnes.{{ $index }}.role" class="w-full px-2 py-1 border rounded">
                                    <option value="">Sélectionner un rôle</option>
                                    <option value="Président">Président</option>
                                    <option value="Trésorier">Trésorier</option>
                                    <option value="Secrétaire">Secrétaire</option>
                                    <option value="Membre">Membre</option>
                                    <option value="Dirigeant">Dirigeant</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                            <div class="mb-2 grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Date début</label>
                                    <input type="text" wire:model="clubPersonnes.{{ $index }}.date_debut" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-2 py-1 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Date fin</label>
                                    <input type="text" wire:model="clubPersonnes.{{ $index }}.date_fin" placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ" class="w-full px-2 py-1 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="button" wire:click="removeClubPersonne({{ $index }})" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-end">
                        <button type="button" wire:click="addClubPersonne" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter une personne</button>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Disciplines associées</label>
                <div class="flex w-full">
                    <livewire:search-bar
                        entity-class="App\\Models\\Discipline"
                        display-field="nom"
                        id-field="discipline_id"
                        multi=true
                        :search-fields="['nom']"
                        wire:model="selected_discipline_id"
                        wire:key="search-bar-disciplines-create"
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
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Sources</label>
                <div class="flex w-full">
                    <livewire:search-bar
                        entity-class="App\\Models\\Source"
                        display-field="titre"
                        id-field="source_id"
                        multi=true
                        :search-fields="['titre']"
                        wire:model="selected_source_id"
                        wire:key="search-bar-sources-create"
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
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                <textarea wire:model="notes" rows="3" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Enregistrer</button>
            </div>
        </form>
    </div>
    @livewire('lieu-modal')
    @livewire('discipline-modal')
    @livewire('source-modal')
</div>
