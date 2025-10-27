

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
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Lieu</label>
                    <select wire:model.defer="lieu_id" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un lieu</option>
                        @foreach($lieux as $lieu)
                            <option value="{{ $lieu->lieu_id }}">{{ $lieu->adresse }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-2">
                <div class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded px-3 py-2 mb-2 text-sm">
                    Un seul organisateur peut être sélectionné : soit un club, soit une personne. Si vous choisissez les deux, l’enregistrement sera refusé.
                </div>
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Organisateur (club)</label>
                    <select wire:model.defer="organisateur_club_id" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un club</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->club_id }}">{{ $club->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Organisateur (personne)</label>
                    <select wire:model.defer="organisateur_personne_id" class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner une personne</option>
                        @foreach($personnes as $personne)
                            <option value="{{ $personne->personne_id }}">{{ $personne->nom }}</option>
                        @endforeach
                    </select>
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
                <select wire:model.defer="discipline_ids" multiple class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    @foreach($allDisciplines as $discipline)
                        <option value="{{ $discipline->discipline_id }}">{{ $discipline->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Participants</label>
                <select wire:model.defer="participants" multiple class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <optgroup label="Clubs">
                        @foreach($clubs as $club)
                            <option value="{{ 'club_' . $club->club_id }}">{{ $club->nom }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Personnes">
                        @foreach($personnes as $personne)
                            <option value="{{ 'personne_' . $personne->personne_id }}">{{ $personne->nom }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Sources</label>
                <select wire:model.defer="sources" multiple class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    @foreach($allSources as $source)
                        <option value="{{ $source->source_id }}">{{ $source->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition" wire:loading.attr="disabled">
                    <span wire:loading.remove>Mettre à jour</span>
                    <span wire:loading>Enregistrement...</span>
                </button>
            </div>
        </form>
    </div>
</div>
