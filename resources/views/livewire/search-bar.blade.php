<div class="position-relative">
    <!-- Input unique de recherche -->
    <input
        type="text"
        wire:model="search"
        wire:input="searchUpdated"
        placeholder="Rechercher et associer..."
        class="w-full max-w-md mx-auto px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 mb-2"
        autocomplete="off"
    />

    <!-- Résultats dynamiques -->
    @if($search && count($results))
        <div class="absolute w-full z-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded shadow" style="max-height: 200px; overflow-y: auto;">
            @foreach($results as $item)
                <div
                    class="px-3 py-2 cursor-pointer text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-700 last:border-b-0 transition"
                    wire:click="select({{ $item[$idField] }})"
                >
                    {{ $item[$displayField] }}
                </div>
            @endforeach
        </div>
    @elseif($search)
        <div class="text-muted mt-2">Aucun résultat</div>
    @endif

    <!-- Affichage des entités associées (badges) -->
    <div class="mt-3">
        @if(is_iterable($selectedItems))
            @foreach($selectedItems as $item)
                <span class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 align-middle text-gray-900 dark:text-gray-100">
                    {{ $item[$displayField] ?? $item->$displayField }}
                    <button type="button" wire:click="remove({{ $item[$idField] ?? $item->$idField }})" class="ml-1 text-gray-500 hover:text-red-600 focus:outline-none" style="background:transparent;border:none;font-size:1em;vertical-align:middle;">&times;</button>
                </span>
            @endforeach
        @endif
    </div>

    <!-- Champs cachés pour le formulaire -->
    @if($multi)
        @if(is_iterable($selected))
            @foreach($selected as $id)
                <input type="hidden" name="selected_{{ $idField }}[]" value="{{ $id }}">
            @endforeach
        @elseif(is_numeric($selected))
            <input type="hidden" name="selected_{{ $idField }}[]" value="{{ $selected }}">
        @endif
    @else
        <input type="hidden" name="selected_{{ $idField }}" value="{{ is_iterable($selected) ? ($selected[0] ?? '') : $selected }}">
    @endif

    <!-- Conseils UX :
        - Un seul input pour la recherche et l'association.
        - Sélection multiple possible, affichage sous forme de badges.
        - Utilisez debounce pour limiter les requêtes.
        - Liste scrollable et positionnée.
        - Bouton pour retirer chaque entité associée.
        - Champs cachés pour le backend.
    -->
</div>
