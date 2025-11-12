<div>
    <x-notifications.notification />
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Clubs</h1>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('clubs.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-buttons.button type="submit" variant="success">Importer XLSX</x-buttons.button>
            </form>
            <form method="POST" action="{{ route('clubs.export') }}" id="exportForm">
                @csrf
                <input type="hidden" name="selected" id="selectedClubsInput">
                <x-buttons.button type="submit" variant="primary">Exporter la sélection</x-buttons.button>
            </form>
            <x-buttons.button as="a" href="{{ route('clubs.create') }}" variant="primary">Ajouter un club</x-buttons.button>
        </div>
    </div>
    <div class="overflow-x-auto w-full">
    <x-tables.table class="w-full" :headers="['', 'Nom', 'Nom origine', 'Surnoms', 'Date fondation', 'Date disparition', 'Date déclaration', 'Acronyme', 'Couleurs', 'Siège', 'Disciplines', 'Actions']">
            @foreach($clubs as $club)
                @component('components.tables.club-table-row', ['club' => $club]) @endcomponent
            @endforeach
    </x-tables.table>
    </div>
    <div class="p-4">
        {{ $clubs->links() }}
    </div>
    <script>
    // Sélection multiple
    function toggleAllClubs(source) {
        const checkboxes = document.querySelectorAll('.club-checkbox');
        checkboxes.forEach(cb => cb.checked = source.checked);
    }
    // Remplir le champ hidden avant export
    document.getElementById('exportForm').addEventListener('submit', function(e) {
        const selected = Array.from(document.querySelectorAll('.club-checkbox:checked')).map(cb => cb.value);
        document.getElementById('selectedClubsInput').value = selected.join(',');
    });
    </script>

    <!-- Modal de suppression -->
    <div id="deleteClubModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-red-700">Confirmer la suppression du club</h3>
            <div class="mb-4 text-gray-700 dark:text-gray-300">
                <span id="deleteClubName"></span><br>
                <span class="text-sm text-red-600">Cette action supprimera également toutes les relations (disciplines, personnes, compétitions, sources) associées à ce club.</span>
            </div>
            <div class="flex justify-end gap-2">
                <x-buttons.button type="button" variant="secondary" onclick="closeDeleteClubModal()">Annuler</x-buttons.button>
                <form id="deleteClubForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-buttons.button type="submit" variant="danger">Confirmer</x-buttons.button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('open-delete-modal', function(e) {
    document.getElementById('deleteClubModal').classList.remove('hidden');
    document.getElementById('deleteClubName').textContent = 'Club : ' + e.detail.clubName;
    document.getElementById('deleteClubForm').action = '/clubs/' + e.detail.clubId;
});
function closeDeleteClubModal() {
    document.getElementById('deleteClubModal').classList.add('hidden');
}
</script>
