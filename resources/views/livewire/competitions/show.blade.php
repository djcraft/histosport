

<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail de la compétition</h2>
        <x-field label="Nom" :value="$competition->nom" />
        <x-fields-group :fields="[
            ['label' => 'Date', 'value' => $competition->date],
            ['label' => 'Lieu principal', 'value' => $competition->lieu? $competition->lieu->nom : null]
        ]" />
        <div class="mb-4">
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
        @if($competition->organisateur_club)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Organisateur :</span>
                <a href="{{ route('clubs.show', $competition->organisateur_club) }}">
                    <x-badge class="mr-1">{{ $competition->organisateur_club->nom }}</x-badge>
                </a>
            </div>
        @elseif($competition->organisateur_personne)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Organisateur :</span>
                <a href="{{ route('personnes.show', $competition->organisateur_personne) }}">
                    <x-badge class="mr-1">{{ $competition->organisateur_personne->nom }} {{ $competition->organisateur_personne->prenom }}</x-badge>
                </a>
            </div>
        @else
            <x-field label="Organisateur" :value="null" />
        @endif
        <x-fields-group :fields="[
            ['label' => 'Type', 'value' => $competition->type],
            ['label' => 'Durée', 'value' => $competition->duree],
            ['label' => 'Niveau', 'value' => $competition->niveau]
        ]" />
        <x-list label="Disciplines" :items="$competition->disciplines" route="disciplines.show" />
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
        <x-list label="Sources" :items="$competition->sources" route="sources.show" />
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
