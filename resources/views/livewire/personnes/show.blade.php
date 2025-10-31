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
                        <a href="{{ route('clubs.show', $club) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $club->nom }}</a>
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
                    <a href="{{ route('lieux.show', $personne->lieu_naissance) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                        {{ $personne->lieu_naissance->nom ?? '' }}{{ $personne->lieu_naissance->nom ? ', ' : '' }}
                        {{ $personne->lieu_naissance->adresse ?? '' }}{{ $personne->lieu_naissance->adresse ? ', ' : '' }}
                        {{ $personne->lieu_naissance->code_postal ?? '' }}{{ $personne->lieu_naissance->code_postal ? ', ' : '' }}
                        {{ $personne->lieu_naissance->commune ?? '' }}{{ $personne->lieu_naissance->commune ? ', ' : '' }}
                        {{ $personne->lieu_naissance->departement ?? '' }}{{ $personne->lieu_naissance->departement ? ', ' : '' }}
                        {{ $personne->lieu_naissance->pays ?? '' }}
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
                    <a href="{{ route('lieux.show', $personne->lieu_deces) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                        {{ $personne->lieu_deces->nom ?? '' }}{{ $personne->lieu_deces->nom ? ', ' : '' }}
                        {{ $personne->lieu_deces->adresse ?? '' }}{{ $personne->lieu_deces->adresse ? ', ' : '' }}
                        {{ $personne->lieu_deces->code_postal ?? '' }}{{ $personne->lieu_deces->code_postal ? ', ' : '' }}
                        {{ $personne->lieu_deces->commune ?? '' }}{{ $personne->lieu_deces->commune ? ', ' : '' }}
                        {{ $personne->lieu_deces->departement ?? '' }}{{ $personne->lieu_deces->departement ? ', ' : '' }}
                        {{ $personne->lieu_deces->pays ?? '' }}
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
                <a href="{{ route('lieux.show', $personne->adresse) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $personne->adresse->adresse ?? '' }}{{ $personne->adresse->adresse ? ', ' : '' }}
                    {{ $personne->adresse->code_postal ?? '' }}{{ $personne->adresse->code_postal ? ', ' : '' }}
                    {{ $personne->adresse->commune ?? '' }}{{ $personne->adresse->commune ? ', ' : '' }}
                    {{ $personne->adresse->departement ?? '' }}{{ $personne->adresse->departement ? ', ' : '' }}
                    {{ $personne->adresse->pays ?? '' }}
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
                            <span class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-xs rounded px-2 py-1 mr-1 align-middle hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $mandat->club->nom ?? '' }}</span>
                        </a>
                        @if(!empty($mandat->role))
                            <span class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition font-semibold">{{ $mandat->role }}</span>
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
                    <a href="{{ route('sources.show', $source) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $source->titre }}</a>
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endforelse
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Disciplines :</span>
            @forelse($personne->disciplines as $discipline)
                <a href="{{ route('disciplines.show', $discipline) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $discipline->nom }}</a>
            @empty
                <span class="text-gray-500">Aucune</span>
            @endforelse
        </div>
        <div class="flex justify-end">
            <a href="{{ route('personnes.edit', $personne) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Modifier</a>
        </div>
    </div>
</div>
