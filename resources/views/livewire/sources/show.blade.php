
<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">{{ $source->titre }}</h2>
        <x-field label="Titre" :value="$source->titre" />
        <x-field label="Auteur" :value="$source->auteur" />
        <x-fields-group :fields="[
            ['label' => 'Année de référence', 'value' => $source->annee_reference],
            ['label' => 'Type', 'value' => $source->type]
        ]" />
        <x-fields-group :fields="[
            ['label' => 'Cote', 'value' => $source->cote],
            ['label' => 'URL', 'value' => $source->url]
        ]" />
        @php
            $lieuEditionAdresse = $source->lieuEdition
                ? trim(($source->lieuEdition->adresse ?? '') . ' ' . ($source->lieuEdition->code_postal ?? '') . ' ' . ($source->lieuEdition->commune ?? ''))
                : '-';
            $lieuConservationAdresse = $source->lieuConservation
                ? trim(($source->lieuConservation->adresse ?? '') . ' ' . ($source->lieuConservation->code_postal ?? '') . ' ' . ($source->lieuConservation->commune ?? ''))
                : '-';
            $lieuCouvertureAdresse = $source->lieuCouverture
                ? trim(($source->lieuCouverture->adresse ?? '') . ' ' . ($source->lieuCouverture->code_postal ?? '') . ' ' . ($source->lieuCouverture->commune ?? ''))
                : '-';
            $fieldsLieux = [
                ['label' => "Lieu d'édition", 'value' => $lieuEditionAdresse],
                ['label' => 'Lieu de conservation', 'value' => $lieuConservationAdresse],
                ['label' => 'Lieu de couverture', 'value' => $lieuCouvertureAdresse]
            ];
        @endphp
        <x-fields-group :fields="$fieldsLieux" />
        <x-list label="Clubs associés" :items="$source->clubs" route="clubs.show" />
        <x-list label="Compétitions associées" :items="$source->competitions" route="competitions.show" />
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
            <x-button as="a" href="{{ route('sources.edit', $source) }}" variant="link-orange">Modifier</x-button>
        </div>
    </div>
</div>
