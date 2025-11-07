<div>
    <x-notification />
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
    <div class="overflow-x-auto w-full">
        <x-table class="w-full" :headers="['', 'Nom', 'Date', 'Lieu', 'Organisateur', 'Type', 'Durée', 'Niveau', 'Discipline', 'Actions']">
            @foreach($competitions as $competition)
                <tr>
                    <td class="px-4 py-4 text-center whitespace-nowrap">
                        <input type="checkbox" class="competition-checkbox" value="{{ $competition->competition_id }}">
                    </td>
                    <td class="whitespace-nowrap text-center">{{ $competition->nom }}</td>
                    <td class="whitespace-nowrap text-center">{{ $competition->date }}</td>
                    <td class="whitespace-nowrap text-center">
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
                    <td class="whitespace-nowrap text-center">
                        @if($competition->organisateur_club)
                            {{ $competition->organisateur_club->nom }}
                        @elseif($competition->organisateur_personne)
                            {{ $competition->organisateur_personne->nom }}
                            {{ $competition->organisateur_personne->prenom }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="whitespace-nowrap text-center">{{ $competition->type }}</td>
                    <td class="whitespace-nowrap text-center">{{ $competition->duree }}</td>
                    <td class="whitespace-nowrap text-center">{{ $competition->niveau }}</td>
                    <td class="whitespace-nowrap text-center">
                        @forelse($competition->disciplines as $discipline)
                            <a href="{{ route('disciplines.show', $discipline) }}">
                                <x-badge class="mr-1">{{ $discipline->nom }}</x-badge>
                            </a>
                        @empty
                            -
                        @endforelse
                    </td>
                    <td class="whitespace-nowrap text-center">
                        <div class="flex flex-row gap-2 justify-center">
                            <x-button as="a" href="{{ route('competitions.show', $competition) }}" variant="link-primary">Voir</x-button>
                            <x-button as="a" href="{{ route('competitions.edit', $competition) }}" variant="link-orange">Modifier</x-button>
                            <x-button as="a" href="#" variant="link-danger" onclick="window.dispatchEvent(new CustomEvent('open-delete-competition-modal', {detail: {competitionId: {{ $competition->competition_id }}, competitionName: '{{ addslashes($competition->nom) }}'}}))">Supprimer</x-button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
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
