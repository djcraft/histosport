<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail du club</h2>
        @php
            $personnesAvecMandat = $club->clubPersonnes->pluck('personne_id')->toArray();
            $personnesSimples = $club->personnes->filter(fn($p) => !in_array($p->personne_id, $personnesAvecMandat));
        @endphp
        <x-list label="Présence simple dans le club" :items="$personnesSimples" route="personnes.show" />
        <x-field label="Nom" :value="$club->nom" />
        <x-field label="Nom d'origine" :value="$club->nom_origine" />
        <x-field label="Surnoms" :value="$club->surnoms" />
        <x-fields-group :fields="[
            ['label' => 'Date de fondation', 'value' => $club->date_fondation],
            ['label' => 'Date de disparition', 'value' => $club->date_disparition],
            ['label' => 'Date de déclaration', 'value' => $club->date_declaration]
        ]" />
        <x-field label="Acronyme" :value="$club->acronyme" />
        <x-field label="Couleurs" :value="$club->couleurs" />
        <x-field-if label="Lieu (siège)" :value="$club->siege? $club->siege->nom : null" :route="'lieux.show'" :routeParam="$club->siege" />
        <x-list label="Disciplines" :items="$club->disciplines" route="disciplines.show" />
        <x-list-mandats label="Mandats dans le club" :mandats="$club->clubPersonnes" />
        <x-list label="Sources" :items="$club->sources" route="sources.show" />
        <x-field label="Notes" :value="$club->notes" />
        <div class="flex justify-end">
            <x-button as="a" href="{{ route('clubs.edit', $club) }}" variant="link-orange">Modifier</x-button>
        </div>
    </div>
</div>
