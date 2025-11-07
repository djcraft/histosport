<div>
    <x-notification />
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Disciplines</h1>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('disciplines.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-button type="submit" variant="success">Importer XLSX</x-button>
            </form>
            <form method="POST" action="{{ route('disciplines.export') }}" id="exportFormDisciplines">
                @csrf
                <input type="hidden" name="ids" id="exportIds">
                <x-button type="submit" variant="primary">Exporter la sélection</x-button>
            </form>
            <x-button as="a" href="{{ route('disciplines.create') }}" variant="primary">Ajouter une discipline</x-button>
        </div>
    </div>
    <div class="overflow-x-auto w-full">
        <x-table class="w-full" :headers="['', 'Nom', 'Description', 'Actions']">
            @foreach($disciplines as $discipline)
                <tr>
                    <td class="px-4 py-4 text-center whitespace-nowrap"><input type="checkbox" class="discipline-checkbox" value="{{ $discipline->discipline_id }}"></td>
                    <td class="whitespace-nowrap text-center">{{ $discipline->nom }}</td>
                    <td class="whitespace-nowrap text-center">{{ $discipline->description }}</td>
                    <td class="whitespace-nowrap text-center">
                        <div class="flex flex-row gap-2 justify-center">
                            <x-button as="a" href="{{ route('disciplines.show', $discipline) }}" variant="link-primary">Voir</x-button>
                            <x-button as="a" href="{{ route('disciplines.edit', $discipline) }}" variant="link-orange">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" onclick="window.dispatchEvent(new CustomEvent('open-delete-discipline-modal', {detail: {disciplineId: {{ $discipline->discipline_id }}, disciplineName: '{{ addslashes($discipline->nom) }}'}}))">Supprimer</x-button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
        <div class="p-4">
            {{ $disciplines->links() }}
        </div>
    </div>

    <!-- Modal de suppression -->
    <div id="deleteDisciplineModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-red-700">Confirmer la suppression de la discipline</h3>
            <div class="mb-4 text-gray-700 dark:text-gray-300">
                <span id="deleteDisciplineName"></span><br>
                <span class="text-sm text-red-600">Cette action supprimera également toutes les relations (clubs, personnes, compétitions, sources) associées à cette discipline.</span>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600" onclick="closeDeleteDisciplineModal()">Annuler</button>
                <form id="deleteDisciplineForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('open-delete-discipline-modal', function(e) {
    document.getElementById('deleteDisciplineModal').classList.remove('hidden');
    document.getElementById('deleteDisciplineName').textContent = 'Discipline : ' + e.detail.disciplineName;
    document.getElementById('deleteDisciplineForm').action = '/disciplines/' + e.detail.disciplineId;
});
function closeDeleteDisciplineModal() {
    document.getElementById('deleteDisciplineModal').classList.add('hidden');
}
// Sélection export disciplines
function toggleAllDisciplines() {
    const checked = document.getElementById('selectAllDisciplines').checked;
    document.querySelectorAll('.discipline-checkbox').forEach(cb => cb.checked = checked);
    updateExportIds();
}
document.querySelectorAll('.discipline-checkbox').forEach(cb => {
    cb.addEventListener('change', updateExportIds);
});
function updateExportIds() {
    const ids = Array.from(document.querySelectorAll('.discipline-checkbox:checked')).map(cb => cb.value);
    document.getElementById('exportIds').value = ids.join(',');
}
</script>
