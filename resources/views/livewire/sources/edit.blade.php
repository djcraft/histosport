
<div>
    <form wire:submit.prevent="update" class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier la source</h2>
        <div class="mb-4">
            <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
            <input type="text" id="titre" wire:model.defer="titre" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" required>
            @error('titre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="auteur" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auteur</label>
            <input type="text" id="auteur" wire:model.defer="auteur" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            @error('auteur') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="annee_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Année de référence</label>
                <input type="text" id="annee_reference" wire:model.defer="annee_reference" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('annee_reference') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                <input type="text" id="type" wire:model.defer="type" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="cote" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cote</label>
                <input type="text" id="cote" wire:model.defer="cote" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('cote') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL</label>
                <input type="text" id="url" wire:model.defer="url" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="lieu_edition_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieu d'édition</label>
                <select id="lieu_edition_id" wire:model.defer="lieu_edition_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">-- Sélectionner --</option>
                    @foreach($lieux as $lieu)
                        <option value="{{ $lieu->lieu_id }}">{{ $lieu->adresse }}</option>
                    @endforeach
                </select>
                @error('lieu_edition_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="lieu_conservation_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieu de conservation</label>
                <select id="lieu_conservation_id" wire:model.defer="lieu_conservation_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">-- Sélectionner --</option>
                    @foreach($lieux as $lieu)
                        <option value="{{ $lieu->lieu_id }}">{{ $lieu->adresse }}</option>
                    @endforeach
                </select>
                @error('lieu_conservation_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="lieu_couverture_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieu de couverture</label>
                <select id="lieu_couverture_id" wire:model.defer="lieu_couverture_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">-- Sélectionner --</option>
                    @foreach($lieux as $lieu)
                        <option value="{{ $lieu->lieu_id }}">{{ $lieu->adresse }}</option>
                    @endforeach
                </select>
                @error('lieu_couverture_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mb-4">
            <label for="lieux" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieux associés</label>
            <select id="lieux" wire:model.defer="lieux" multiple class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @foreach($allLieux as $lieu)
                    <option value="{{ $lieu->id }}">{{ $lieu->nom }}</option>
                @endforeach
            </select>
            @error('lieux') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="clubs" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Clubs associés</label>
            <select id="clubs" wire:model.defer="clubs" multiple class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @foreach($allClubs as $club)
                    <option value="{{ $club->id }}">{{ $club->nom }}</option>
                @endforeach
            </select>
            @error('clubs') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="personnes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Personnes associées</label>
            <select id="personnes" wire:model.defer="personnes" multiple class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @foreach($allPersonnes as $personne)
                    <option value="{{ $personne->id }}">{{ $personne->nom }}</option>
                @endforeach
            </select>
            @error('personnes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="disciplines" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disciplines associées</label>
            <select id="disciplines" wire:model.defer="disciplines" multiple class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @foreach($allDisciplines as $discipline)
                    <option value="{{ $discipline->id }}">{{ $discipline->nom }}</option>
                @endforeach
            </select>
            @error('disciplines') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="competitions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Compétitions associées</label>
            <select id="competitions" wire:model.defer="competitions" multiple class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @foreach($allCompetitions as $competition)
                    <option value="{{ $competition->id }}">{{ $competition->nom }}</option>
                @endforeach
            </select>
            @error('competitions') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Mettre à jour</button>
        </div>
    </form>
</div>
