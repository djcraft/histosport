
<div>
    <form wire:submit.prevent="update" class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier la compétition</h2>
        <div class="mb-4">
            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
            <input type="text" id="nom" wire:model.defer="nom" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" required>
            @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                <input type="date" id="date" wire:model.defer="date" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="lieu_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieu</label>
                <select id="lieu_id" wire:model.defer="lieu_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">-- Sélectionner --</option>
                    @foreach($lieux as $lieu)
                        <option value="{{ $lieu->lieu_id }}">{{ $lieu->adresse }}</option>
                    @endforeach
                </select>
                @error('lieu_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="organisateur_club_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Organisateur (club)</label>
                <select id="organisateur_club_id" wire:model.defer="organisateur_club_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">-- Sélectionner --</option>
                    @foreach($clubs as $club)
                        <option value="{{ $club->club_id }}">{{ $club->nom }}</option>
                    @endforeach
                </select>
                @error('organisateur_club_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="organisateur_personne_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Organisateur (personne)</label>
                <select id="organisateur_personne_id" wire:model.defer="organisateur_personne_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">-- Sélectionner --</option>
                    @foreach($personnes as $personne)
                        <option value="{{ $personne->personne_id }}">{{ $personne->nom }}</option>
                    @endforeach
                </select>
                @error('organisateur_personne_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                <input type="text" id="type" wire:model.defer="type" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="duree" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Durée</label>
                <input type="text" id="duree" wire:model.defer="duree" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('duree') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="niveau" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Niveau</label>
                <input type="text" id="niveau" wire:model.defer="niveau" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('niveau') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mb-4">
            <label for="discipline_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discipline</label>
            <select id="discipline_id" wire:model.defer="discipline_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                <option value="">-- Sélectionner --</option>
                @foreach($allDisciplines as $discipline)
                    <option value="{{ $discipline->id }}">{{ $discipline->nom }}</option>
                @endforeach
            </select>
            @error('discipline_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="participants" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Participants</label>
            <select id="participants" wire:model.defer="participants" multiple class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @foreach($allParticipants as $participant)
                    <option value="{{ $participant->id }}">{{ $participant->nom }}</option>
                @endforeach
            </select>
            @error('participants') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="sources" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sources</label>
            <select id="sources" wire:model.defer="sources" multiple class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @foreach($allSources as $source)
                    <option value="{{ $source->id }}">{{ $source->titre }}</option>
                @endforeach
            </select>
            @error('sources') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Mettre à jour</button>
        </div>
    </form>
</div>
