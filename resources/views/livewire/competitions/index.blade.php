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
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Compétitions</h1>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('competitions.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-button type="submit" variant="success">Importer XLSX</x-button>
            </form>
            <form method="POST" action="{{ route('competitions.export') }}" id="exportFormCompetitions">
                @csrf
                <input type="hidden" name="ids" id="selectedCompetitionsInput">
                <x-button type="submit" variant="primary">Exporter la sélection</x-button>
            </form>
            <x-button as="a" href="{{ route('competitions.create') }}" variant="primary">Ajouter une compétition</x-button>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <input type="checkbox" id="selectAllCompetitions" onclick="toggleAllCompetitions(this)">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Organisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Durée</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Niveau</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Discipline</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($competitions as $competition)
                    <tr>
                        <td class="px-4 py-4 text-center">
                            <input type="checkbox" class="competition-checkbox" value="{{ $competition->competition_id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                @if($competition->lieu)
                                        <a href="{{ route('lieux.show', $competition->lieu) }}">
                                            <x-badge>
                                                {{ $competition->lieu->nom ?? '' }}{{ $competition->lieu->nom ? ', ' : '' }}
                                                {{ $competition->lieu->adresse ?? '' }}{{ $competition->lieu->adresse ? ', ' : '' }}
                                                {{ $competition->lieu->commune ?? '' }}{{ $competition->lieu->commune ? ', ' : '' }}
                                                {{ $competition->lieu->code_postal ?? '' }}
                                            </x-badge>
                                        </a>
                                @else
                                    -
                                @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @if($competition->organisateur_club)
                                {{ $competition->organisateur_club->nom }}
                            @elseif($competition->organisateur_personne)
                                {{ $competition->organisateur_personne->nom }}
                                {{ $competition->organisateur_personne->prenom }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->duree }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->niveau }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @forelse($competition->disciplines as $discipline)
                                    <a href="{{ route('disciplines.show', $discipline) }}">
                                        <x-badge class="mr-1">{{ $discipline->nom }}</x-badge>
                                    </a>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-button as="a" href="{{ route('competitions.show', $competition) }}" variant="link-primary" class="mr-2">Voir</x-button>
                            <x-button as="a" href="{{ route('competitions.edit', $competition) }}" variant="link-orange" class="mr-2">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" class="mr-2" onclick="window.dispatchEvent(new CustomEvent('open-delete-competition-modal', {detail: {competitionId: {{ $competition->competition_id }}, competitionName: '{{ addslashes($competition->nom) }}'}}))">Supprimer</x-button>
                        </td>
                    </tr>
                @endforeach
<script>
function toggleAllCompetitions(cb) {
    document.querySelectorAll('.competition-checkbox').forEach(function(box) {
        box.checked = cb.checked;
    });
    updateSelectedCompetitions();
}
document.querySelectorAll('.competition-checkbox').forEach(function(box) {
    box.addEventListener('change', updateSelectedCompetitions);
});
function updateSelectedCompetitions() {
    const ids = Array.from(document.querySelectorAll('.competition-checkbox:checked')).map(cb => cb.value);
    document.getElementById('selectedCompetitionsInput').value = ids.join(',');
}
</script>
            </tbody>
        </table>
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
                <x-button type="button" variant="secondary" onclick="closeDeleteCompetitionModal()">Annuler</x-button>
                <form id="deleteCompetitionForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger">Confirmer</x-button>
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
