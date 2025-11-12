<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sources</h1>
        <div class="flex gap-2 justify-end w-full">
            <form method="POST" action="{{ route('sources.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-buttons.button type="submit" variant="success">Importer XLSX</x-buttons.button>
            </form>
            <form method="POST" action="{{ route('sources.export') }}" id="exportForm">
                @csrf
                <input type="hidden" name="ids" id="exportIds">
                <x-buttons.button type="submit" variant="primary">Exporter la sélection</x-buttons.button>
            </form>
            <x-buttons.button as="a" href="{{ route('sources.create') }}" variant="primary">Ajouter une source</x-buttons.button>
        </div>
    </div>
    <x-notifications.notification />
    <div class="overflow-x-auto w-full">
    <x-tables.table class="w-full" :headers="['', 'Titre', 'Auteur', 'Année référence', 'Type', 'Cote', 'Lieu édition', 'Lieu conservation', 'Lieu couverture', 'URL', 'Actions']">
            @foreach($sources as $source)
                @component('components.tables.source-table-row', ['source' => $source]) @endcomponent
            @endforeach
    </x-tables.table>
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
                <x-buttons.button type="button" variant="secondary" onclick="closeDeleteSourceModal()">Annuler</x-buttons.button>
                <form id="deleteSourceForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-buttons.button type="submit" variant="danger">Confirmer</x-buttons.button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('open-delete-source-modal', function(e) {
    document.getElementById('deleteSourceModal').classList.remove('hidden');
    document.getElementById('deleteSourceName').textContent = 'Source : ' + e.detail.entityName;
    document.getElementById('deleteSourceForm').action = '/sources/' + e.detail.entityId;
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
