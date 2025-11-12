<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail de la personne</h2>
        @php
            $clubsAvecMandat = $personne->clubPersonnes->pluck('club_id')->toArray();
            $clubsSimples = $personne->clubs->filter(fn($c) => !in_array($c->club_id, $clubsAvecMandat));
        @endphp
    <x-lists.list label="Présence dans les clubs" :items="$clubsSimples" route="clubs.show" />
    <x-form-elements.field label="Nom" :value="$personne->nom" />
    <x-form-elements.field label="Prénom" :value="$personne->prenom" />
    <x-form-elements.field label="Date de naissance" :value="$personne->date_naissance" />
        @if($personne->lieu_naissance)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de naissance :</span>
                <a href="{{ route('lieux.show', $personne->lieu_naissance) }}">
                    <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                        {{ $personne->lieu_naissance->nom ?? '' }}{{ $personne->lieu_naissance->nom ? ', ' : '' }}
                        {{ $personne->lieu_naissance->adresse ?? '' }}{{ $personne->lieu_naissance->adresse ? ', ' : '' }}
                        {{ $personne->lieu_naissance->commune ?? '' }}{{ $personne->lieu_naissance->commune ? ', ' : '' }}
                        {{ $personne->lieu_naissance->code_postal ?? '' }}
                    </x-badges.badge>
                </a>
            </div>
        @else
            <x-form-elements.field label="Lieu de naissance" :value="null" />
        @endif
    <x-form-elements.field label="Date de décès" :value="$personne->date_deces" />
        @if($personne->lieu_deces)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de décès :</span>
                <a href="{{ route('lieux.show', $personne->lieu_deces) }}">
                    <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                        {{ $personne->lieu_deces->nom ?? '' }}{{ $personne->lieu_deces->nom ? ', ' : '' }}
                        {{ $personne->lieu_deces->adresse ?? '' }}{{ $personne->lieu_deces->adresse ? ', ' : '' }}
                        {{ $personne->lieu_deces->commune ?? '' }}{{ $personne->lieu_deces->commune ? ', ' : '' }}
                        {{ $personne->lieu_deces->code_postal ?? '' }}
                    </x-badges.badge>
                </a>
            </div>
        @else
            <x-form-elements.field label="Lieu de décès" :value="null" />
        @endif
    <x-form-elements.field label="Sexe" :value="$personne->sexe" />
    <x-form-elements.field label="Titre" :value="$personne->titre" />
        @if($personne->adresse)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Adresse :</span>
                <a href="{{ route('lieux.show', $personne->adresse) }}">
                    <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                        {{ $personne->adresse->nom ?? '' }}{{ $personne->adresse->nom ? ', ' : '' }}
                        {{ $personne->adresse->adresse ?? '' }}{{ $personne->adresse->adresse ? ', ' : '' }}
                        {{ $personne->adresse->commune ?? '' }}{{ $personne->adresse->commune ? ', ' : '' }}
                        {{ $personne->adresse->code_postal ?? '' }}
                    </x-badges.badge>
                </a>
            </div>
        @else
            <x-form-elements.field label="Adresse" :value="null" />
        @endif
    <x-lists.list-mandats label="Mandats dans les clubs" :mandats="$personne->clubPersonnes" type="personne" />

    <div class="mb-4">
        <span class="block text-gray-700 dark:text-gray-300 font-semibold">Compétitions auxquelles la personne a participé</span>
        <div class="mt-1">
            @forelse($personne->competitionParticipants ?? [] as $cp)
                @if($cp->competition)
                    <div class="flex items-center mb-1">
                        <a href="{{ route('competitions.show', $cp->competition) }}">
                            <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-2 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                                {{ $cp->competition->nom ?? 'Compétition' }}
                            </x-badges.badge>
                        </a>
                        @if($cp->resultat)
                            <span class="text-xs text-gray-500 dark:text-gray-400 mr-1 align-middle">résultat</span>
                            <x-badges.badge class="inline-block bg-orange-200 dark:bg-orange-700 text-xs rounded px-2 py-1 mr-1 align-middle text-orange-900 dark:text-orange-100">
                                {{ $cp->resultat }}
                            </x-badges.badge>
                        @endif
                    </div>
                @endif
            @empty
                <span class="block text-gray-900 dark:text-gray-100">-</span>
            @endforelse
        </div>
    </div>

    <x-lists.list label="Sources" :items="$personne->sources" route="sources.show" />
    <x-lists.list label="Disciplines" :items="$personne->disciplines" route="disciplines.show" />
        <div class="flex justify-end">
            <x-buttons.button as="a" href="{{ route('personnes.edit', $personne) }}" variant="link-orange">Modifier</x-buttons.button>
        </div>
        </div>
    </div>
</div>
