        {{-- Entités en conflit --}}
        @php
            $conflicts = $pendingImport->entities->where('status', 'conflict');
        @endphp
        @if($conflicts->count())
            <h4 class="mt-6 text-red-700">Conflits détectés</h4>
            <table class="min-w-max divide-y divide-gray-200 dark:divide-gray-700 mb-4">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Données</th>
                        <th>Conflits</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conflicts as $entity)
                        <tr class="bg-red-50 dark:bg-red-900">
                            <td>{{ $entity->entity_type }}</td>
                            <td><pre>{{ json_encode($entity->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre></td>
                            <td>
                                @foreach((array) $entity->conflicts as $conflict)
                                    <div class="mb-2 p-2 rounded bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">
                                        <strong>ID :</strong> {{ $conflict['id'] ?? '-' }}<br>
                                        <strong>Nom :</strong> {{ $conflict['nom'] ?? '-' }}<br>
                                        <strong>Message :</strong> {{ $conflict['message'] ?? '' }}
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
<div>
    <h3>Prévisualisation Import Multi-Feuilles</h3>
    @if($pendingImport)
        <p><strong>Type :</strong> {{ $pendingImport->type }}</p>
        <p><strong>Status :</strong> {{ $pendingImport->status }}</p>


        <div class="flex gap-2 my-4">
            @if($pendingImport->status === 'pending')
                <x-buttons.button wire:click="validateImport" variant="primary">
                    <x-icons.check class="inline mr-1"/> Valider l'import
                </x-buttons.button>
                <x-buttons.button wire:click="rejectImport" variant="danger">
                    <x-icons.x class="inline mr-1"/> Rejeter l'import
                </x-buttons.button>
            @elseif($pendingImport->status === 'validated')
                <x-badges.badge variant="success">Import validé</x-badges.badge>
            @else
                <x-badges.badge variant="danger">Import supprimé ou rejeté</x-badges.badge>
            @endif
        </div>

        @if(session('notification'))
            <x-notifications.notification :type="session('notification.type')" :message="session('notification.message')" />
        @endif

        {{-- Clubs importés --}}
        @php
            $clubs = $pendingImport->entities->where('entity_type', 'club');
        @endphp
        @if($clubs->count())
            <h4>Clubs importés</h4>
            <x-tables.table :headers="['Nom', 'Nom origine', 'Surnoms', 'Date fondation', 'Date disparition', 'Date déclaration', 'Acronyme', 'Couleurs', 'Siège', 'Disciplines', 'Actions']">
                @foreach($clubs as $entity)
                    @php $club = (object) $entity->data; @endphp
                    <x-tables.club-table-row :club="$club" />
                @endforeach
            </x-tables.table>
        @endif

        {{-- Personnes importées --}}
        @php
            $personnes = $pendingImport->entities->where('entity_type', 'personne');
        @endphp
        @if($personnes->count())
            <h4>Personnes importées</h4>
            <x-tables.table :headers="['Nom', 'Prénom', 'Date naissance', 'Lieu naissance', 'Date décès', 'Lieu décès', 'Sexe', 'Titre', 'Adresse', 'Actions']">
                @foreach($personnes as $entity)
                    @php $personne = (object) $entity->data; @endphp
                    <x-tables.personne-table-row :personne="$personne" />
                @endforeach
            </x-tables.table>
        @endif

        {{-- Affichage générique pour les autres entités --}}
        @php
            $autres = $pendingImport->entities->whereNotIn('entity_type', ['club', 'personne']);
        @endphp
        @if($autres->count())
            <h4>Autres entités importées</h4>
            <table border="1" cellpadding="4">
                <thead>
                    <tr>
                        <th>Feuille</th>
                        <th>Ligne</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Hash</th>
                        <th>Données</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($autres as $entity)
                        <tr>
                            <td>{{ $entity->sheet_name }}</td>
                            <td>{{ $entity->row_number }}</td>
                            <td>{{ $entity->entity_type }}</td>
                            <td>{{ $entity->status }}</td>
                            <td>{{ $entity->hash }}</td>
                            <td><pre>{{ json_encode($entity->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        <p>Aucun import temporaire trouvé.</p>
    @endif
</div>
