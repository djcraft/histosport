

<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail de la compétition</h2>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $competition->nom }}</span>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->date }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu principal :</span>
                        @if($competition->lieu)
                            <a href="{{ route('lieux.show', $competition->lieu) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                                {{ $competition->lieu->nom ?? '' }}{{ $competition->lieu->nom ? ', ' : '' }}
                                {{ $competition->lieu->adresse ?? '' }}{{ $competition->lieu->adresse ? ', ' : '' }}
                                {{ $competition->lieu->code_postal ?? '' }}{{ $competition->lieu->code_postal ? ', ' : '' }}
                                {{ $competition->lieu->commune ?? '' }}{{ $competition->lieu->commune ? ', ' : '' }}
                                {{ $competition->lieu->departement ?? '' }}{{ $competition->lieu->departement ? ', ' : '' }}
                                {{ $competition->lieu->pays ?? '' }}
                            </a>
                        @else
                            <span class="block text-gray-900 dark:text-gray-100">-</span>
                        @endif
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sites de la compétition :</span>
                    <div class="mt-1 flex flex-wrap gap-3">
                        @forelse($competition->sites as $site)
                            <a href="{{ route('lieux.show', $site) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                                {{ $site->nom ?? '' }}{{ $site->nom ? ', ' : '' }}
                                {{ $site->adresse ?? '' }}{{ $site->adresse ? ', ' : '' }}
                                {{ $site->code_postal ?? '' }}{{ $site->code_postal ? ', ' : '' }}
                                {{ $site->commune ?? '' }}{{ $site->commune ? ', ' : '' }}
                                {{ $site->departement ?? '' }}{{ $site->departement ? ', ' : '' }}
                                {{ $site->pays ?? '' }}
                                @if($site->pivot->type)
                                    <span class="ml-1 text-blue-600 dark:text-blue-300">({{ $site->pivot->type }})</span>
                                @endif
                            </a>
                        @empty
                            <span class="block text-gray-900 dark:text-gray-100">-</span>
                        @endforelse
                    </div>
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Organisateur :</span>
            <div class="mt-1">
                @if($competition->organisateur_club)
                    <a href="{{ route('clubs.show', $competition->organisateur_club) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        {{ $competition->organisateur_club->nom }}
                    </a>
                @elseif($competition->organisateur_personne)
                    <a href="{{ route('personnes.show', $competition->organisateur_personne) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        {{ $competition->organisateur_personne->nom }}
                    </a>
                @else
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endif
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Type :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->type }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Durée :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->duree }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Niveau :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->niveau }}</span>
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Disciplines :</span>
            <div class="mt-1">
                @forelse($competition->disciplines as $discipline)
                    <a href="{{ route('disciplines.show', $discipline) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $discipline->nom }}</a>
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endforelse
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Participants :</span>
            <div class="mt-1">
                @foreach($competition->participants as $participant)
                    @if($participant->club)
                        <a href="{{ route('clubs.show', $participant->club) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            {{ $participant->club->nom }}
                            @if($participant->resultat)
                                <span class="ml-1 text-blue-600 dark:text-blue-300">({{ $participant->resultat }})</span>
                            @endif
                        </a>
                    @elseif($participant->personne)
                        <a href="{{ route('personnes.show', $participant->personne) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            {{ $participant->personne->nom }}
                            @if($participant->resultat)
                                <span class="ml-1 text-blue-600 dark:text-blue-300">({{ $participant->resultat }})</span>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sources :</span>
                <div class="mt-1">
                    @forelse($competition->sources as $source)
                        <a href="{{ route('sources.show', $source) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $source->titre }}</a>
                    @empty
                        <span class="block text-gray-900 dark:text-gray-100">-</span>
                    @endforelse
                </div>
            </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Historisation :</span>
            <div class="mt-1">
                @foreach($competition->historisations as $hist)
                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                        <span>{{ $hist->action }} par {{ $hist->utilisateur->name ?? 'Utilisateur inconnu' }} le {{ $hist->date }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('competitions.edit', $competition) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Modifier</a>
        </div>
</div>
