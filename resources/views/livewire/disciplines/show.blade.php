
<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">{{ $discipline->nom }}</h2>
    <x-form-elements.field label="Description" :value="$discipline->description" />

    <!-- Références à personnes, sources et clubs supprimées -->
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Historisation :</span>
            <div class="mt-1">
                @foreach($discipline->historisations as $hist)
                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                        <span>{{ $hist->action }} par {{ $hist->utilisateur->name ?? 'Utilisateur inconnu' }} le {{ $hist->date }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end gap-4">
            <x-buttons.button as="a" href="{{ route('disciplines.edit', $discipline) }}" variant="link-orange">Modifier</x-buttons.button>
            <!-- Bouton supprimer retiré -->
        </div>
        <!-- Modal de confirmation suppression retiré -->
    </div>
</div>
