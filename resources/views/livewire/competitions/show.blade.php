

<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail de la compétition</h2>
    <x-form-elements.field label="Nom" :value="$competition->nom" />
    <x-form-elements.fields-group :fields="[
            ['label' => 'Date', 'value' => $competition->date],
            ['label' => 'Lieu principal', 'value' => $competition->lieu? $competition->lieu->nom : null]
        ]" />
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sites de la compétition :</span>
            <div class="mt-1 flex flex-wrap gap-3">
                @forelse($competition->sites as $site)
                    <a href="{{ route('lieux.show', $site) }}">
                        <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
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
        @if($competition->organisateur_club)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Organisateur :</span>
                <a href="{{ route('clubs.show', $competition->organisateur_club) }}">
                    <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $competition->organisateur_club->nom }}</x-badges.badge>
                </a>
            </div>
        @elseif($competition->organisateur_personne)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Organisateur :</span>
                <a href="{{ route('personnes.show', $competition->organisateur_personne) }}">
                    <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $competition->organisateur_personne->nom }} {{ $competition->organisateur_personne->prenom }}</x-badges.badge>
                </a>
            </div>
        @else
            <x-form-elements.field label="Organisateur" :value="null" />
        @endif
    <x-form-elements.fields-group :fields="[
            ['label' => 'Type', 'value' => $competition->type],
            ['label' => 'Durée', 'value' => $competition->duree],
            ['label' => 'Niveau', 'value' => $competition->niveau]
        ]" />
    <x-lists.list label="Disciplines" :items="$competition->disciplines" route="disciplines.show" />
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Participants :</span>
            <div class="mt-1">
                @foreach($competition->participants as $participant)
                    <div class="flex items-center mb-1">
                        @if($participant->club)
                            <a href="{{ route('clubs.show', $participant->club) }}">
                                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-2 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                                    {{ $participant->club->nom }}
                                </x-badges.badge>
                            </a>
                        @elseif($participant->personne)
                            <a href="{{ route('personnes.show', $participant->personne) }}">
                                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-2 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                                    {{ $participant->personne->nom }} {{ $participant->personne->prenom }}
                                </x-badges.badge>
                            </a>
                        @endif
                        @if($participant->resultat)
                            <span class="text-xs text-gray-500 dark:text-gray-400 mr-1 align-middle">résultat</span>
                            <x-badges.badge class="inline-block bg-orange-200 dark:bg-orange-700 text-xs rounded px-2 py-1 mr-1 align-middle text-orange-900 dark:text-orange-100">
                                {{ $participant->resultat }}
                            </x-badges.badge>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    <x-lists.list label="Sources" :items="$competition->sources" route="sources.show" />
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
            <x-buttons.button as="a" href="{{ route('competitions.edit', $competition) }}" variant="link-orange">Modifier</x-buttons.button>
        </div>
</div>
