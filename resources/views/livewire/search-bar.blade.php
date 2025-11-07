<div class="relative w-full">
    <!-- Input unique de recherche -->
    <input
        type="text"
        wire:model="search"
        wire:input="searchUpdated"
        placeholder="Rechercher et associer..."
        class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 mb-2"
        autocomplete="off"
    />

    <!-- Résultats dynamiques -->
    @if($search && count($results))
    <div class="absolute left-0 z-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded shadow" style="width: 100%; max-height: 200px; overflow-y: auto;">
        @if(is_iterable($results))
            @foreach($results as $item)
                <div
                    class="px-3 py-2 cursor-pointer text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-700 last:border-b-0 transition"
                    wire:click="select({{ is_array($item) ? $item[$idField] : $item->$idField }})"
                >
                    @foreach($displayFields as $field)
                        <span class="inline-block mr-2">
                            {{ is_array($item) ? ($item[$field] ?? '') : ($item->$field ?? '') }}
                        </span>
                    @endforeach
                </div>
            @endforeach
        @else
            <div
                class="px-3 py-2 cursor-pointer text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-700 last:border-b-0 transition"
                wire:click="select({{ is_array($results) ? $results[$idField] : $results->$idField }})"
            >
                {{ is_array($results) ? $results[$displayField] : $results->$displayField }}
            </div>
        @endif
    </div>
    @elseif($search && !count($results))
        <div class="text-gray-500 dark:text-gray-400 mt-2 italic">Aucun résultat</div>
    @endif

    <!-- Affichage des entités associées (badges) -->
    <div class="mt-3">
        @if(!empty($modelValue))
            <div class="flex flex-wrap gap-2 mt-2">
                @if(is_iterable($selectedItems) && count($selectedItems))
                    @foreach($selectedItems as $item)
                        <x-badge color="gray">
                            @foreach($displayFields as $field)
                                <span class="inline-block mr-2">
                                    {{ is_array($item) ? ($item[$field] ?? '') : ($item->$field ?? '') }}
                                </span>
                            @endforeach
                                <a href="#" wire:click.prevent="remove({{ is_array($item) ? $item[$idField] : $item->$idField }})" class="ml-1 text-red-500 hover:text-red-700 text-xs" style="text-decoration:none;">&times;</a>
                        </x-badge>
                    @endforeach
                @elseif(!empty($selectedItems))
                    <x-badge color="gray">
                        {{ is_array($selectedItems) ? $selectedItems[$displayField] : $selectedItems->$displayField }}
                            <a href="#" wire:click.prevent="remove({{ is_array($selectedItems) ? $selectedItems[$idField] : $selectedItems->$idField }})" class="ml-1 text-red-500 hover:text-red-700 text-xs" style="text-decoration:none;">&times;</a>
                    </x-badge>
                @endif
            </div>
    @endif
    </div>

    <!-- Champs cachés pour le formulaire -->
    @if($multi)
        @if(is_iterable($modelValue))
            @foreach($modelValue as $id)
                <input type="hidden" name="selected_{{ $idField }}[]" value="{{ $id }}">
            @endforeach
        @elseif(is_numeric($modelValue))
            <input type="hidden" name="selected_{{ $idField }}[]" value="{{ $modelValue }}">
        @endif
    @else
        <input type="hidden" name="selected_{{ $idField }}" value="{{ !empty($modelValue) ? (is_iterable($modelValue) ? ($modelValue[0] ?? '') : $modelValue) : '' }}">
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
