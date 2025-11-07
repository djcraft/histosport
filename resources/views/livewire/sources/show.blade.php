
<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">{{ $source->titre }}</h2>
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Titre :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $source->titre }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Auteur :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $source->auteur }}</span>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Année de référence :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $source->annee_reference }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Type :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $source->type }}</span>
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Cote :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $source->cote }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">URL :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $source->url }}</span>
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Lieu d'édition :</span>
                <span class="block text-gray-900 dark:text-gray-100">
                    @if($source->lieuEdition)
                        {{ $source->lieuEdition->adresse ?? '' }} {{ $source->lieuEdition->code_postal ?? '' }} {{ $source->lieuEdition->commune ?? '' }}
                    @else
                        -
                    @endif
                </span>
            </div>
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Lieu de conservation :</span>
                <span class="block text-gray-900 dark:text-gray-100">
                    @if($source->lieuConservation)
                        {{ $source->lieuConservation->adresse ?? '' }} {{ $source->lieuConservation->code_postal ?? '' }} {{ $source->lieuConservation->commune ?? '' }}
                    @else
                        -
                    @endif
                </span>
            </div>
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Lieu de couverture :</span>
                <span class="block text-gray-900 dark:text-gray-100">
                    @if($source->lieuCouverture)
                        {{ $source->lieuCouverture->adresse ?? '' }} {{ $source->lieuCouverture->code_postal ?? '' }} {{ $source->lieuCouverture->commune ?? '' }}
                    @else
                        -
                    @endif
                </span>
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Clubs associés :</span>
            <div class="mt-1">
                    @forelse($source->clubs as $club)
                            <a href="{{ route('clubs.show', $club) }}">
                                <x-badge class="mr-1">{{ $club->nom }}</x-badge>
                            </a>
                    @empty
                        <span class="block text-gray-900 dark:text-gray-100">-</span>
                    @endforelse
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Compétitions associées :</span>
            <div class="mt-1">
                    @forelse($source->competitions as $competition)
                            <a href="{{ route('competitions.show', $competition) }}">
                                <x-badge class="mr-1">{{ $competition->nom }}</x-badge>
                            </a>
                    @empty
                        <span class="block text-gray-900 dark:text-gray-100">-</span>
                    @endforelse
            </div>
        </div>
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
