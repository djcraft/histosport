<div>
    <x-notification />
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
    <div class="overflow-x-auto w-full">
    <x-table class="w-full" :headers="['', 'Nom', 'Nom origine', 'Surnoms', 'Date fondation', 'Date disparition', 'Date déclaration', 'Acronyme', 'Couleurs', 'Siège', 'Disciplines', 'Actions']">
            @foreach($clubs as $club)
                <tr>
                    <td class="px-4 py-4 text-center whitespace-nowrap">
                        <input type="checkbox" class="club-checkbox" value="{{ $club->id }}">
                    </td>
                    <td class="whitespace-nowrap text-center">{{ $club->nom }}</td>
                    <td class="whitespace-nowrap text-center">{{ $club->nom_origine }}</td>
                    <td class="whitespace-nowrap text-center">{{ $club->surnoms }}</td>
                    <td class="whitespace-nowrap text-center">{{ $club->date_fondation }}</td>
                    <td class="whitespace-nowrap text-center">{{ $club->date_disparition }}</td>
                    <td class="whitespace-nowrap text-center">{{ $club->date_declaration }}</td>
                    <td class="whitespace-nowrap text-center">{{ $club->acronyme }}</td>
                    <td class="whitespace-nowrap text-center">{{ $club->couleurs }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100 text-center">
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
                    <td class="whitespace-nowrap text-center">
                        @foreach($club->disciplines as $discipline)
                            <a href="{{ route('disciplines.show', $discipline) }}">
                                <x-badge class="mr-1">{{ $discipline->nom }}</x-badge>
                            </a>
                        @endforeach
                    </td>
                    <td class="whitespace-nowrap ml-4 text-center">
                        <div class="flex flex-row gap-2 justify-center">
                            <x-button as="a" href="{{ route('clubs.show', $club) }}" variant="link-primary">Voir</x-button>
                            <x-button as="a" href="{{ route('clubs.edit', $club) }}" variant="link-orange">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" onclick="window.dispatchEvent(new CustomEvent('open-delete-modal', {detail: {clubId: {{ $club->club_id }}, clubName: '{{ addslashes($club->nom) }}'}}))">Supprimer</x-button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
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
