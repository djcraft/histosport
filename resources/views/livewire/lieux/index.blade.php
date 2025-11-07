<div>
    <x-notification />
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
    <div class="overflow-x-auto w-full">
        <x-table class="w-full" :headers="['', 'Nom', 'Adresse', 'Code postal', 'Commune', 'Département', 'Pays', 'Actions']">
            @foreach($lieux as $lieu)
                <tr>
                    <td class="px-4 py-4 text-center whitespace-nowrap">
                        <input type="checkbox" class="lieu-checkbox" value="{{ $lieu->lieu_id }}">
                    </td>
                    <td class="whitespace-nowrap text-center">{{ $lieu->nom }}</td>
                    <td class="whitespace-nowrap text-center">{{ $lieu->adresse }}</td>
                    <td class="whitespace-nowrap text-center">{{ $lieu->code_postal }}</td>
                    <td class="whitespace-nowrap text-center">{{ $lieu->commune }}</td>
                    <td class="whitespace-nowrap text-center">{{ $lieu->departement }}</td>
                    <td class="whitespace-nowrap text-center">{{ $lieu->pays }}</td>
                    <td class="whitespace-nowrap text-center">
                        <div class="flex flex-row gap-2 justify-center">
                            <x-button as="a" href="{{ route('lieux.show', $lieu) }}" variant="link-primary">Voir</x-button>
                            <x-button as="a" href="{{ route('lieux.edit', $lieu) }}" variant="link-orange">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" onclick="window.dispatchEvent(new CustomEvent('open-delete-lieu-modal', {detail: {lieuId: {{ $lieu->lieu_id }}, lieuName: '{{ addslashes($lieu->nom) }}'}}))">Supprimer</x-button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
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
