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
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Clubs</h1>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('clubs.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx" class="mr-2" required>
                <x-button type="submit" variant="success">Importer XLSX</x-button>
            </form>
            <form method="POST" action="{{ route('clubs.export') }}" id="exportForm">
                @csrf
                <input type="hidden" name="selected" id="selectedClubsInput">
                <x-button type="submit" variant="primary">Exporter la sélection</x-button>
            </form>
            <x-button as="a" href="{{ route('clubs.create') }}" variant="primary">Ajouter un club</x-button>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <input type="checkbox" id="selectAllClubs" onclick="toggleAllClubs(this)">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom origine</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Surnoms</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date fondation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date disparition</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date déclaration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acronyme</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Couleurs</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Siège</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Disciplines</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($clubs as $club)
                    <tr>
                        <td class="px-4 py-4 text-center">
                            <input type="checkbox" class="club-checkbox" value="{{ $club->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $club->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $club->nom_origine }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $club->surnoms }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $club->date_fondation }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $club->date_disparition }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $club->date_declaration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $club->acronyme }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $club->couleurs }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @if($club->siege)
                                    <a href="{{ route('lieux.show', $club->siege) }}">
                                        <x-badge>
                                            {{ $club->siege->nom ?? '' }}{{ $club->siege->nom ? ', ' : '' }}
                                            {{ $club->siege->adresse ?? '' }}{{ $club->siege->adresse ? ', ' : '' }}
                                            {{ $club->siege->commune ?? '' }}{{ $club->siege->commune ? ', ' : '' }}
                                            {{ $club->siege->code_postal ?? '' }}
                                        </x-badge>
                                    </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                @foreach($club->disciplines as $discipline)
                                    <a href="{{ route('disciplines.show', $discipline) }}">
                                        <x-badge class="mr-1">{{ $discipline->nom }}</x-badge>
                                    </a>
                                @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-button as="a" href="{{ route('clubs.show', $club) }}" variant="link-primary" class="mr-2">Voir</x-button>
                            <x-button as="a" href="{{ route('clubs.edit', $club) }}" variant="link-orange" class="mr-2">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" class="mr-2" onclick="window.dispatchEvent(new CustomEvent('open-delete-modal', {detail: {clubId: {{ $club->club_id }}, clubName: '{{ addslashes($club->nom) }}'}}))">Supprimer</x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $clubs->links() }}
        </div>
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
                <x-button type="button" variant="secondary" onclick="closeDeleteClubModal()">Annuler</x-button>
                <form id="deleteClubForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger">Confirmer</x-button>
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
