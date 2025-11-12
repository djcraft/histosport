<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail du club</h2>
        @php
            $personnesAvecMandat = $club->clubPersonnes->pluck('personne_id')->toArray();
            $personnesSimples = $club->personnes->filter(fn($p) => !in_array($p->personne_id, $personnesAvecMandat));
        @endphp
    <x-lists.list label="Présence simple dans le club" :items="$personnesSimples" route="personnes.show" />
    <x-form-elements.field label="Nom" :value="$club->nom" />
    <x-form-elements.field label="Nom d'origine" :value="$club->nom_origine" />
    <x-form-elements.field label="Surnoms" :value="$club->surnoms" />
    <x-form-elements.fields-group :fields="[
            ['label' => 'Date de fondation', 'value' => $club->date_fondation],
            ['label' => 'Date de disparition', 'value' => $club->date_disparition],
            ['label' => 'Date de déclaration', 'value' => $club->date_declaration]
        ]" />
    <x-form-elements.field label="Acronyme" :value="$club->acronyme" />
    <x-form-elements.field label="Couleurs" :value="$club->couleurs" />
    @if($club->siege)
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu (siège) :</span>
            <a href="{{ route('lieux.show', $club->siege) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $club->siege->nom ?? '' }}{{ $club->siege->nom ? ', ' : '' }}
                    {{ $club->siege->adresse ?? '' }}{{ $club->siege->adresse ? ', ' : '' }}
                    {{ $club->siege->commune ?? '' }}{{ $club->siege->commune ? ', ' : '' }}
                    {{ $club->siege->code_postal ?? '' }}
                </x-badges.badge>
            </a>
        </div>
    @else
        <x-form-elements.field label="Lieu (siège)" :value="null" />
    @endif
    <x-lists.list label="Disciplines" :items="$club->disciplines" route="disciplines.show" />
    <x-lists.list-mandats label="Mandats dans le club" :mandats="$club->clubPersonnes" type="club" />

    <div class="mb-4">
        <span class="block text-gray-700 dark:text-gray-300 font-semibold">Compétitions auxquelles le club a participé</span>
        <div class="mt-1">
            @forelse($club->competitionParticipants as $cp)
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
    </div><x-lists.list label="Sources" :items="$club->sources" route="sources.show" />

    <x-form-elements.field label="Notes" :value="$club->notes" />
        <div class="flex justify-end">
            <x-buttons.button as="a" href="{{ route('clubs.edit', $club) }}" variant="link-orange">Modifier</x-buttons.button>
        </div>
    </div>
</div>
