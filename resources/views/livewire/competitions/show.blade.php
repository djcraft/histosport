

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
                                <a href="{{ route('lieux.show', $competition->lieu) }}">
                                    <x-badge>
                                        {{ $competition->lieu->nom ?? '' }}{{ $competition->lieu->nom ? ', ' : '' }}
                                        {{ $competition->lieu->adresse ?? '' }}{{ $competition->lieu->adresse ? ', ' : '' }}
                                        {{ $competition->lieu->commune ?? '' }}{{ $competition->lieu->commune ? ', ' : '' }}
                                        {{ $competition->lieu->code_postal ?? '' }}
                                    </x-badge>
                                </a>
                        @else
                            <span class="block text-gray-900 dark:text-gray-100">-</span>
                        @endif
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sites de la compétition :</span>
                    <div class="mt-1 flex flex-wrap gap-3">
                        @forelse($competition->sites as $site)
                                <a href="{{ route('lieux.show', $site) }}">
                                    <x-badge>
                                        {{ $site->nom ?? '' }}{{ $site->nom ? ', ' : '' }}
                                        {{ $site->adresse ?? '' }}{{ $site->adresse ? ', ' : '' }}
                                        {{ $site->commune ?? '' }}{{ $site->commune ? ', ' : '' }}
                                        {{ $site->code_postal ?? '' }}
                                    </x-badge>
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
                        <a href="{{ route('clubs.show', $competition->organisateur_club) }}">
                            <x-badge class="mr-1">{{ $competition->organisateur_club->nom }}</x-badge>
                        </a>
                @elseif($competition->organisateur_personne)
                        <a href="{{ route('personnes.show', $competition->organisateur_personne) }}">
                            <x-badge class="mr-1">{{ $competition->organisateur_personne->nom }} {{ $competition->organisateur_personne->prenom }}</x-badge>
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
                        <a href="{{ route('disciplines.show', $discipline) }}">
                            <x-badge class="mr-1">{{ $discipline->nom }}</x-badge>
                        </a>
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
                                <a href="{{ route('clubs.show', $participant->club) }}">
                                    <x-badge class="mr-1">
                                        {{ $participant->club->nom }}@if($participant->resultat) ({{ $participant->resultat }})@endif
                                    </x-badge>
                                </a>
                    @elseif($participant->personne)
                                <a href="{{ route('personnes.show', $participant->personne) }}">
                                    <x-badge class="mr-1">
                                        {{ $participant->personne->nom }} {{ $participant->personne->prenom }}@if($participant->resultat) ({{ $participant->resultat }})@endif
                                    </x-badge>
                                </a>
                    @endif
                @endforeach
            </div>
        </div>
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sources :</span>
                <div class="mt-1">
                    @forelse($competition->sources as $source)
                            <a href="{{ route('sources.show', $source) }}">
                                <x-badge class="mr-1">{{ $source->titre }}</x-badge>
                            </a>
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
            <x-button as="a" href="{{ route('competitions.edit', $competition) }}" variant="link-orange">Modifier</x-button>
        </div>
</div>
