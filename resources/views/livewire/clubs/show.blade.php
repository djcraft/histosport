<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail du club</h2>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Présence simple dans le club :</span>
            <div class="mt-1">
                @php
                    $personnesAvecMandat = $club->clubPersonnes->pluck('personne_id')->toArray();
                @endphp
                @forelse($club->personnes as $personne)
                    @if(!in_array($personne->personne_id, $personnesAvecMandat))
                        <a href="{{ route('personnes.show', $personne) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $personne->nom }} {{ $personne->prenom }}</a>
                    @endif
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">Aucune présence simple</span>
                @endforelse
            </div>
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->nom }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom d'origine :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->nom_origine }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Surnoms :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->surnoms }}</span>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de fondation :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $club->date_fondation }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de disparition :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $club->date_disparition }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de déclaration :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $club->date_declaration }}</span>
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Acronyme :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->acronyme }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Couleurs :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->couleurs }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu (siège) :</span>
            @if($club->siege)
                <a href="{{ route('lieux.show', $club->siege) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $club->siege->nom ?? '' }}{{ $club->siege->nom ? ', ' : '' }}
                    {{ $club->siege->adresse ?? '' }}{{ $club->siege->adresse ? ', ' : '' }}
                    {{ $club->siege->code_postal ?? '' }}{{ $club->siege->code_postal ? ', ' : '' }}
                    {{ $club->siege->commune ?? '' }}{{ $club->siege->commune ? ', ' : '' }}
                    {{ $club->siege->departement ?? '' }}{{ $club->siege->departement ? ', ' : '' }}
                    {{ $club->siege->pays ?? '' }}
                </a>
            @else
                <span class="block text-gray-900 dark:text-gray-100">-</span>
            @endif
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Disciplines :</span>
            <div class="mt-1">
                @foreach($club->disciplines as $discipline)
                    <a href="{{ route('disciplines.show', $discipline) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $discipline->nom }}</a>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Mandats dans le club :</span>
            <div class="mt-1 space-y-2">
                @forelse($club->clubPersonnes as $mandat)
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('personnes.show', $mandat->personne) }}" class="inline-block align-middle">
                            <span class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-xs rounded px-2 py-1 mr-1 align-middle hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $mandat->personne->nom ?? '' }} {{ $mandat->personne->prenom ?? '' }}</span>
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
            <!-- Seules les sources associées au club via entity_type = 'club' sont affichées ici -->
            <div class="mt-1">
                @forelse($club->sources as $source)
                    <a href="{{ route('sources.show', $source) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $source->titre }}</a>
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endforelse
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Notes :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->notes }}</span>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('clubs.edit', $club) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Modifier</a>
        </div>
    </div>
</div>
