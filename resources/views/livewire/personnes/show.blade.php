<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail de la personne</h2>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Présence dans les clubs :</span>
            <div class="mt-1">
                @php
                    $clubsAvecMandat = $personne->clubPersonnes->pluck('club_id')->toArray();
                @endphp
                @forelse($personne->clubs as $club)
                        @if(!in_array($club->club_id, $clubsAvecMandat))
                            <a href="{{ route('clubs.show', $club) }}">
                                <x-badge class="mr-1">{{ $club->nom }}</x-badge>
                            </a>
                        @endif
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">Aucune présence simple</span>
                @endforelse
            </div>
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->nom }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Prénom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->prenom }}</span>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de naissance :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $personne->date_naissance }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de naissance :</span>
                @if($personne->lieu_naissance)
                        <a href="{{ route('lieux.show', $personne->lieu_naissance) }}">
                            <x-badge>
                                {{ $personne->lieu_naissance->nom ?? '' }}{{ $personne->lieu_naissance->nom ? ', ' : '' }}
                                {{ $personne->lieu_naissance->adresse ?? '' }}{{ $personne->lieu_naissance->adresse ? ', ' : '' }}
                                {{ $personne->lieu_naissance->commune ?? '' }}{{ $personne->lieu_naissance->commune ? ', ' : '' }}
                                {{ $personne->lieu_naissance->code_postal ?? '' }}
                            </x-badge>
                        </a>
                @else
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endif
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de décès :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $personne->date_deces }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de décès :</span>
                @if($personne->lieu_deces)
                        <a href="{{ route('lieux.show', $personne->lieu_deces) }}">
                            <x-badge>
                                {{ $personne->lieu_deces->nom ?? '' }}{{ $personne->lieu_deces->nom ? ', ' : '' }}
                                {{ $personne->lieu_deces->adresse ?? '' }}{{ $personne->lieu_deces->adresse ? ', ' : '' }}
                                {{ $personne->lieu_deces->commune ?? '' }}{{ $personne->lieu_deces->commune ? ', ' : '' }}
                                {{ $personne->lieu_deces->code_postal ?? '' }}
                            </x-badge>
                        </a>
                @else
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endif
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sexe :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->sexe }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Titre :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->titre }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Adresse :</span>
            @if($personne->adresse)
                    <a href="{{ route('lieux.show', $personne->adresse) }}">
                        <x-badge>
                            {{ $personne->adresse->nom ?? '' }}{{ $personne->adresse->nom ? ', ' : '' }}
                            {{ $personne->adresse->adresse ?? '' }}{{ $personne->adresse->adresse ? ', ' : '' }}
                            {{ $personne->adresse->commune ?? '' }}{{ $personne->adresse->commune ? ', ' : '' }}
                            {{ $personne->adresse->code_postal ?? '' }}
                        </x-badge>
                    </a>
            @else
                <span class="block text-gray-900 dark:text-gray-100">-</span>
            @endif
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Mandats dans les clubs :</span>
            <div class="mt-1 space-y-2">
                @forelse($personne->clubPersonnes as $mandat)
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('clubs.show', $mandat->club) }}" class="inline-block align-middle">
                                <x-badge class="mr-1">{{ $mandat->club->nom ?? '' }}</x-badge>
                            </a>
                            @if(!empty($mandat->role))
                                <x-badge class="mr-1 font-semibold">{{ $mandat->role }}</x-badge>
                            @endif
                            <span class="text-xs text-gray-700 dark:text-gray-300">
                                @php
                                    $precisions = ['année','year','mois','month','jour','day'];
                                    $debut = $mandat->date_debut;
                                    $debutPrecision = $mandat->date_debut_precision;
                                    $fin = $mandat->date_fin;
                                    $finPrecision = $mandat->date_fin_precision;
                                    $debutAff = ($debut && in_array($debutPrecision, $precisions)) ? formatMandatDate($debut, $debutPrecision) : ($debut ?? null);
                                    $finAff = ($fin && in_array($finPrecision, $precisions)) ? formatMandatDate($fin, $finPrecision) : ($fin ?? null);
                                @endphp
                                @if($debutAff && $finAff)
                                    {{ $debutAff }} – {{ $finAff }}
                                @elseif($debutAff)
                                    {{ $debutAff }}
                                @elseif($finAff)
                                    Jusqu'à {{ $finAff }}
                                @elseif(empty($debutAff) && empty($finAff))
                                    <span class="italic text-gray-400">Période inconnue</span>
                                @endif
                            </span>
                        </div>
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">Aucun mandat enregistré</span>
                @endforelse
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sources :</span>
            <div class="mt-1">
                @forelse($personne->sources as $source)
                        <a href="{{ route('sources.show', $source) }}">
                            <x-badge class="mr-1">{{ $source->titre }}</x-badge>
                        </a>
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endforelse
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Disciplines :</span>
            @forelse($personne->disciplines as $discipline)
                    <a href="{{ route('disciplines.show', $discipline) }}">
                        <x-badge class="mr-1">{{ $discipline->nom }}</x-badge>
                    </a>
            @empty
                <span class="text-gray-500">Aucune</span>
            @endforelse
        </div>
        <div class="flex justify-end">
            <x-button as="a" href="{{ route('personnes.edit', $personne) }}" variant="link-orange">Modifier</x-button>
        </div>
        </div>
    </div>
</div>
