<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sources</h1>
        <div class="flex gap-2 justify-end w-full">
            <form method="POST" action="{{ route('sources.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-button type="submit" variant="success">Importer XLSX</x-button>
            </form>
            <form method="POST" action="{{ route('sources.export') }}" id="exportForm">
                @csrf
                <input type="hidden" name="ids" id="exportIds">
                <x-button type="submit" variant="primary">Exporter la sélection</x-button>
            </form>
            <x-button as="a" href="{{ route('sources.create') }}" variant="primary">Ajouter une source</x-button>
        </div>
    </div>
    @if(session('import_report'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            <strong>Rapport d'import :</strong><br>
            @foreach(session('import_report') as $key => $value)
                <div>{{ ucfirst($key) }} : {{ is_array($value) ? implode(', ', $value) : $value }}</div>
            @endforeach
        </div>
    @endif
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <input type="checkbox" id="selectAllSources" onclick="toggleAllSources(this)">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Auteur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Année référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cote</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu édition</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu conservation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu couverture</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">URL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($sources as $source)
                    <tr>
                        <td class="px-4 py-4 text-center">
                            <input type="checkbox" class="source-checkbox" value="{{ $source->source_id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $source->titre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $source->auteur }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $source->annee_reference }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $source->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $source->cote }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @if($source->lieuEdition)
                                    <a href="{{ route('lieux.show', $source->lieuEdition) }}">
                                        <x-badge class="mr-1">
                                            {{ $source->lieuEdition->nom ?? '' }} {{ $source->lieuEdition->adresse ?? '' }} {{ $source->lieuEdition->commune ?? '' }} {{ $source->lieuEdition->code_postal ?? '' }}
                                        </x-badge>
                                    </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @if($source->lieuConservation)
                                    <a href="{{ route('lieux.show', $source->lieuConservation) }}">
                                        <x-badge class="mr-1">
                                            {{ $source->lieuConservation->nom ?? '' }} {{ $source->lieuConservation->adresse ?? '' }} {{ $source->lieuConservation->commune ?? '' }} {{ $source->lieuConservation->code_postal ?? '' }}
                                        </x-badge>
                                    </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @if($source->lieuCouverture)
                                    <a href="{{ route('lieux.show', $source->lieuCouverture) }}">
                                        <x-badge class="mr-1">
                                            {{ $source->lieuCouverture->nom ?? '' }} {{ $source->lieuCouverture->adresse ?? '' }} {{ $source->lieuCouverture->commune ?? '' }} {{ $source->lieuCouverture->code_postal ?? '' }}
                                        </x-badge>
                                    </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $source->url }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-button as="a" href="{{ route('sources.show', $source) }}" variant="link-primary" class="mr-2">Voir</x-button>
                            <x-button as="a" href="{{ route('sources.edit', $source) }}" variant="link-orange" class="mr-2">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" class="mr-2" onclick="window.dispatchEvent(new CustomEvent('open-delete-source-modal', {detail: {sourceId: {{ $source->source_id }}, sourceName: '{{ addslashes($source->titre) }}'}}))">Supprimer</x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $sources->links() }}
        </div>
    </div>

    <!-- Modal de suppression -->
    <div id="deleteSourceModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-red-700">Confirmer la suppression de la source</h3>
            <div class="mb-4 text-gray-700 dark:text-gray-300">
                <span id="deleteSourceName"></span><br>
                <span class="text-sm text-red-600">Cette action supprimera également toutes les relations (clubs, disciplines, compétitions, personnes) associées à cette source.</span>
            </div>
            <div class="flex justify-end gap-2">
                <x-button type="button" variant="secondary" onclick="closeDeleteSourceModal()">Annuler</x-button>
                <form id="deleteSourceForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger">Confirmer</x-button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('open-delete-source-modal', function(e) {
    document.getElementById('deleteSourceModal').classList.remove('hidden');
    document.getElementById('deleteSourceName').textContent = 'Source : ' + e.detail.sourceName;
    document.getElementById('deleteSourceForm').action = '/sources/' + e.detail.sourceId;
});
function closeDeleteSourceModal() {
    document.getElementById('deleteSourceModal').classList.add('hidden');
}

// Sélection multiple
function toggleAllSources(source) {
    const checkboxes = document.querySelectorAll('.source-checkbox');
    checkboxes.forEach(cb => cb.checked = source.checked);
}
document.getElementById('exportForm').addEventListener('submit', function(e) {
    const selected = Array.from(document.querySelectorAll('.source-checkbox:checked')).map(cb => cb.value);
    document.getElementById('exportIds').value = selected.join(',');
});
</script>
