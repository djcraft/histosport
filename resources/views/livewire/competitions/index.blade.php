<div>
    <x-notifications.notification />
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Compétitions</h1>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('competitions.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-buttons.button type="submit" variant="success">Importer XLSX</x-buttons.button>
            </form>
            <form method="POST" action="{{ route('competitions.export') }}" id="exportFormCompetitions">
                @csrf
                <input type="hidden" name="ids" id="selectedCompetitionsInput">
                <x-buttons.button type="submit" variant="primary">Exporter la sélection</x-buttons.button>
            </form>
            <x-buttons.button as="a" href="{{ route('competitions.create') }}" variant="primary">Ajouter une compétition</x-buttons.button>
        </div>
    </div>
    <div class="overflow-x-auto w-full">
    <x-tables.table class="w-full" :headers="['', 'Nom', 'Date', 'Lieu', 'Organisateur', 'Type', 'Durée', 'Niveau', 'Discipline', 'Actions']">
            @foreach($competitions as $competition)
                @component('components.tables.competition-table-row', ['competition' => $competition]) @endcomponent
            @endforeach
    </x-tables.table>
        <div class="p-4">
            {{ $competitions->links() }}
        </div>
    </div>

    <!-- Modal de suppression -->
    <div id="deleteCompetitionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-red-700">Confirmer la suppression de la compétition</h3>
            <div class="mb-4 text-gray-700 dark:text-gray-300">
                <span id="deleteCompetitionName"></span><br>
                <span class="text-sm text-red-600">Cette action supprimera également toutes les relations (disciplines, clubs, personnes, sources) associées à cette compétition.</span>
            </div>
            <div class="flex justify-end gap-2">
                <x-buttons.button type="button" variant="secondary" onclick="closeDeleteCompetitionModal()">Annuler</x-buttons.button>
                <form id="deleteCompetitionForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-buttons.button type="submit" variant="danger">Confirmer</x-buttons.button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('open-delete-competition-modal', function(e) {
    document.getElementById('deleteCompetitionModal').classList.remove('hidden');
    document.getElementById('deleteCompetitionName').textContent = 'Compétition : ' + e.detail.competitionName;
    document.getElementById('deleteCompetitionForm').action = '/competitions/' + e.detail.competitionId;
});
function closeDeleteCompetitionModal() {
    document.getElementById('deleteCompetitionModal').classList.add('hidden');
}
</script>
