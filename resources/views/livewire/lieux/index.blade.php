<div>
    @if(session('import_report'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            <strong>Rapport d'import :</strong><br>
            @foreach(session('import_report') as $key => $value)
                <div>{{ ucfirst($key) }} : {{ is_array($value) ? implode(', ', $value) : $value }}</div>
            @endforeach
        </div>
    @endif
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Lieux</h1>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('lieux.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-button type="submit" variant="success">Importer XLSX</x-button>
            </form>
            <form method="POST" action="{{ route('lieux.export') }}" id="exportForm">
                @csrf
                <input type="hidden" name="ids" id="exportIds">
                <x-button type="submit" variant="primary">Exporter la sélection</x-button>
            </form>
            <x-button as="a" href="{{ route('lieux.create') }}" variant="primary">Ajouter un lieu</x-button>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <input type="checkbox" id="selectAllLieux" onclick="toggleAllLieux(this)">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Adresse</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Code postal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Commune</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Département</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pays</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($lieux as $lieu)
                    <tr>
                        <td class="px-4 py-4 text-center">
                            <input type="checkbox" class="lieu-checkbox" value="{{ $lieu->lieu_id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $lieu->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $lieu->adresse }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $lieu->code_postal }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $lieu->commune }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $lieu->departement }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $lieu->pays }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-button as="a" href="{{ route('lieux.show', $lieu) }}" variant="link-primary" class="mr-2">Voir</x-button>
                            <x-button as="a" href="{{ route('lieux.edit', $lieu) }}" variant="link-orange" class="mr-2">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" class="mr-2" onclick="window.dispatchEvent(new CustomEvent('open-delete-lieu-modal', {detail: {lieuId: {{ $lieu->lieu_id }}, lieuName: '{{ addslashes($lieu->nom) }}'}}))">Supprimer</x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $lieux->links() }}
        </div>
    </div>

    <!-- Modal de suppression -->
    <div id="deleteLieuModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-red-700">Confirmer la suppression du lieu</h3>
            <div class="mb-4 text-gray-700 dark:text-gray-300">
                <span id="deleteLieuName"></span><br>
                <span class="text-sm text-red-600">Cette action supprimera également toutes les relations (clubs, personnes, compétitions, sources) associées à ce lieu.</span>
            </div>
            <div class="flex justify-end gap-2">
                <x-button type="button" variant="secondary" onclick="closeDeleteLieuModal()">Annuler</x-button>
                <form id="deleteLieuForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger">Confirmer</x-button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('open-delete-lieu-modal', function(e) {
    document.getElementById('deleteLieuModal').classList.remove('hidden');
    document.getElementById('deleteLieuName').textContent = 'Lieu : ' + e.detail.lieuName;
    document.getElementById('deleteLieuForm').action = '/lieux/' + e.detail.lieuId;
});
function closeDeleteLieuModal() {
    document.getElementById('deleteLieuModal').classList.add('hidden');
}

// Sélection multiple
function toggleAllLieux(source) {
    const checkboxes = document.querySelectorAll('.lieu-checkbox');
    checkboxes.forEach(cb => cb.checked = source.checked);
}
document.getElementById('exportForm').addEventListener('submit', function(e) {
    const selected = Array.from(document.querySelectorAll('.lieu-checkbox:checked')).map(cb => cb.value);
    document.getElementById('exportIds').value = selected.join(',');
});
</script>
