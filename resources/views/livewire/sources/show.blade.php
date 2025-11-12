
<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">{{ $source->titre }}</h2>
    <x-form-elements.field label="Titre" :value="$source->titre" />
    <x-form-elements.field label="Auteur" :value="$source->auteur" />
    <x-form-elements.fields-group :fields="[
            ['label' => 'Année de référence', 'value' => $source->annee_reference],
            ['label' => 'Type', 'value' => $source->type]
        ]" />
    <x-form-elements.fields-group :fields="[
            ['label' => 'Cote', 'value' => $source->cote],
            ['label' => 'URL', 'value' => $source->url]
        ]" />
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieux :</span>
            <div class="mt-1 flex flex-wrap gap-3">
                @if($source->lieuEdition)
                    <a href="{{ route('lieux.show', $source->lieuEdition) }}">
                        <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                            Lieu d'édition : {{ $source->lieuEdition->nom ?? '' }}{{ $source->lieuEdition->adresse ? ', ' . $source->lieuEdition->adresse : '' }}{{ $source->lieuEdition->commune ? ', ' . $source->lieuEdition->commune : '' }}{{ $source->lieuEdition->code_postal ? ', ' . $source->lieuEdition->code_postal : '' }}
                        </x-badges.badge>
                    </a>
                @endif
                @if($source->lieuConservation)
                    <a href="{{ route('lieux.show', $source->lieuConservation) }}">
                        <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                            Lieu de conservation : {{ $source->lieuConservation->nom ?? '' }}{{ $source->lieuConservation->adresse ? ', ' . $source->lieuConservation->adresse : '' }}{{ $source->lieuConservation->commune ? ', ' . $source->lieuConservation->commune : '' }}{{ $source->lieuConservation->code_postal ? ', ' . $source->lieuConservation->code_postal : '' }}
                        </x-badges.badge>
                    </a>
                @endif
                @if($source->lieuCouverture)
                    <a href="{{ route('lieux.show', $source->lieuCouverture) }}">
                        <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                            Lieu de couverture : {{ $source->lieuCouverture->nom ?? '' }}{{ $source->lieuCouverture->adresse ? ', ' . $source->lieuCouverture->adresse : '' }}{{ $source->lieuCouverture->commune ? ', ' . $source->lieuCouverture->commune : '' }}{{ $source->lieuCouverture->code_postal ? ', ' . $source->lieuCouverture->code_postal : '' }}
                        </x-badges.badge>
                    </a>
                @endif
                @if(!$source->lieuEdition && !$source->lieuConservation && !$source->lieuCouverture)
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endif
            </div>
        </div>
    <x-lists.list label="Clubs associés" :items="$source->clubs" route="clubs.show" />
    <x-lists.list label="Compétitions associées" :items="$source->competitions" route="competitions.show" />
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Historisation :</span>
            <div class="mt-1">
                @foreach($source->historisations as $hist)
                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                        <span>{{ $hist->action }} par {{ $hist->utilisateur->name ?? 'Utilisateur inconnu' }} le {{ $hist->date }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end">
            <x-buttons.button as="a" href="{{ route('sources.edit', $source) }}" variant="link-orange">Modifier</x-buttons.button>
        </div>
    </div>
</div>
