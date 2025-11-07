<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail de la personne</h2>
        @php
            $clubsAvecMandat = $personne->clubPersonnes->pluck('club_id')->toArray();
            $clubsSimples = $personne->clubs->filter(fn($c) => !in_array($c->club_id, $clubsAvecMandat));
        @endphp
        <x-list label="Présence dans les clubs" :items="$clubsSimples" route="clubs.show" />
        <x-field label="Nom" :value="$personne->nom" />
        <x-field label="Prénom" :value="$personne->prenom" />
        <x-field label="Date de naissance" :value="$personne->date_naissance" />
        @if($personne->lieu_naissance)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de naissance :</span>
                <a href="{{ route('lieux.show', $personne->lieu_naissance) }}">
                    <x-badge>
                        {{ $personne->lieu_naissance->nom ?? '' }}{{ $personne->lieu_naissance->nom ? ', ' : '' }}
                        {{ $personne->lieu_naissance->adresse ?? '' }}{{ $personne->lieu_naissance->adresse ? ', ' : '' }}
                        {{ $personne->lieu_naissance->commune ?? '' }}{{ $personne->lieu_naissance->commune ? ', ' : '' }}
                        {{ $personne->lieu_naissance->code_postal ?? '' }}
                    </x-badge>
                </a>
            </div>
        @else
            <x-field label="Lieu de naissance" :value="null" />
        @endif
        <x-field label="Date de décès" :value="$personne->date_deces" />
        @if($personne->lieu_deces)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de décès :</span>
                <a href="{{ route('lieux.show', $personne->lieu_deces) }}">
                    <x-badge>
                        {{ $personne->lieu_deces->nom ?? '' }}{{ $personne->lieu_deces->nom ? ', ' : '' }}
                        {{ $personne->lieu_deces->adresse ?? '' }}{{ $personne->lieu_deces->adresse ? ', ' : '' }}
                        {{ $personne->lieu_deces->commune ?? '' }}{{ $personne->lieu_deces->commune ? ', ' : '' }}
                        {{ $personne->lieu_deces->code_postal ?? '' }}
                    </x-badge>
                </a>
            </div>
        @else
            <x-field label="Lieu de décès" :value="null" />
        @endif
        <x-field label="Sexe" :value="$personne->sexe" />
        <x-field label="Titre" :value="$personne->titre" />
        @if($personne->adresse)
            <div class="mb-4">
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Adresse :</span>
                <a href="{{ route('lieux.show', $personne->adresse) }}">
                    <x-badge>
                        {{ $personne->adresse->nom ?? '' }}{{ $personne->adresse->nom ? ', ' : '' }}
                        {{ $personne->adresse->adresse ?? '' }}{{ $personne->adresse->adresse ? ', ' : '' }}
                        {{ $personne->adresse->commune ?? '' }}{{ $personne->adresse->commune ? ', ' : '' }}
                        {{ $personne->adresse->code_postal ?? '' }}
                    </x-badge>
                </a>
            </div>
        @else
            <x-field label="Adresse" :value="null" />
        @endif
        <x-list-mandats label="Mandats dans les clubs" :mandats="$personne->clubPersonnes" />
        <x-list label="Sources" :items="$personne->sources" route="sources.show" />
        <x-list label="Disciplines" :items="$personne->disciplines" route="disciplines.show" />
        <div class="flex justify-end">
            <x-button as="a" href="{{ route('personnes.edit', $personne) }}" variant="link-orange">Modifier</x-button>
        </div>
        </div>
    </div>
</div>
