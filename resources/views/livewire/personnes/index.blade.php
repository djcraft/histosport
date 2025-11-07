<div>
    @if(session('import_report'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            <strong>Rapport d'import :</strong><br>
            @foreach(session('import_report') as $key => $value)
                <div>{{ ucfirst($key) }} : {{ $value }}</div>
            @endforeach
        </div>
    @endif
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Personnes</h1>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('personnes.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-button type="submit" variant="success">Importer XLSX</x-button>
            </form>
            <form method="POST" action="{{ route('personnes.export') }}" id="exportFormPersonnes">
                @csrf
                <input type="hidden" name="selected" id="selectedPersonnesInput">
                <x-button type="submit" variant="primary">Exporter la sélection</x-button>
            </form>
            <x-button as="a" href="{{ route('personnes.create') }}" variant="primary">Ajouter une personne</x-button>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <input type="checkbox" id="selectAllPersonnes" onclick="toggleAllPersonnes(this)">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Prénom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date naissance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu naissance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date décès</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu décès</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sexe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Adresse</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Clubs</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($personnes as $personne)
                    <tr>
                        <td class="px-4 py-4 text-center">
                            <input type="checkbox" class="personne-checkbox" value="{{ $personne->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $personne->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $personne->prenom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $personne->date_naissance }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @if($personne->lieu_naissance)
                                    <a href="{{ route('lieux.show', $personne->lieu_naissance) }}">
                                        <x-badge class="mr-1">
                                            {{ $personne->lieu_naissance->nom ?? '' }} {{ $personne->lieu_naissance->adresse ?? '' }} {{ $personne->lieu_naissance->commune ?? '' }} {{ $personne->lieu_naissance->code_postal ?? '' }}
                                        </x-badge>
                                    </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $personne->date_deces }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @if($personne->lieu_deces)
                                    <a href="{{ route('lieux.show', $personne->lieu_deces) }}">
                                        <x-badge class="mr-1">
                                            {{ $personne->lieu_deces->nom ?? '' }} {{ $personne->lieu_deces->adresse ?? '' }} {{ $personne->lieu_deces->commune ?? '' }} {{ $personne->lieu_deces->code_postal ?? '' }}
                                        </x-badge>
                                    </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $personne->sexe }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $personne->titre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @if($personne->adresse)
                                    <a href="{{ route('lieux.show', $personne->adresse) }}">
                                        <x-badge class="mr-1">
                                            {{ $personne->adresse->nom ?? '' }} {{ $personne->adresse->adresse ?? '' }} {{ $personne->adresse->commune ?? '' }} {{ $personne->adresse->code_postal ?? '' }}
                                        </x-badge>
                                    </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @foreach($personne->clubs as $club)
                                    <a href="{{ route('clubs.show', $club) }}">
                                        <x-badge class="mr-1">{{ $club->nom }}</x-badge>
                                    </a>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-button as="a" href="{{ route('personnes.show', $personne) }}" variant="link-primary" class="mr-2">Voir</x-button>
                            <x-button as="a" href="{{ route('personnes.edit', $personne) }}" variant="link-orange" class="mr-2">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" class="mr-2" onclick="window.dispatchEvent(new CustomEvent('open-delete-personne-modal', {detail: {personneId: {{ $personne->personne_id }}, personneName: '{{ addslashes($personne->nom) }}'}}))">Supprimer</x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $personnes->links() }}
        </div>
    </div>
    <script>
    // Sélection multiple
    function toggleAllPersonnes(source) {
        const checkboxes = document.querySelectorAll('.personne-checkbox');
        checkboxes.forEach(cb => cb.checked = source.checked);
    }
    // Remplir le champ hidden avant export
    document.getElementById('exportFormPersonnes').addEventListener('submit', function(e) {
        const selected = Array.from(document.querySelectorAll('.personne-checkbox:checked')).map(cb => cb.value);
        document.getElementById('selectedPersonnesInput').value = selected.join(',');
    });
    </script>

    <!-- Modal de suppression -->
    <div id="deletePersonneModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-red-700">Confirmer la suppression de la personne</h3>
            <div class="mb-4 text-gray-700 dark:text-gray-300">
                <span id="deletePersonneName"></span><br>
                <span class="text-sm text-red-600">Cette action supprimera également toutes les relations (clubs, disciplines, compétitions, sources) associées à cette personne.</span>
            </div>
            <div class="flex justify-end gap-2">
                <x-button type="button" variant="secondary" onclick="closeDeletePersonneModal()">Annuler</x-button>
                <form id="deletePersonneForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger">Confirmer</x-button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('open-delete-personne-modal', function(e) {
    document.getElementById('deletePersonneModal').classList.remove('hidden');
    document.getElementById('deletePersonneName').textContent = 'Personne : ' + e.detail.personneName;
    document.getElementById('deletePersonneForm').action = '/personnes/' + e.detail.personneId;
});
function closeDeletePersonneModal() {
    document.getElementById('deletePersonneModal').classList.add('hidden');
}
</script>
