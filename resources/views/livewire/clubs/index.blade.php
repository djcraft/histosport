<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Clubs</h1>
        <a href="{{ route('clubs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Ajouter un club</a>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
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
                                {{ $club->siege->adresse ?? '' }}{{ $club->siege->code_postal ? ', ' . $club->siege->code_postal : '' }}{{ $club->siege->commune ? ', ' . $club->siege->commune : '' }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            @foreach($club->disciplines as $discipline)
                                <a href="{{ route('disciplines.show', $discipline) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $discipline->nom }}</a>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('clubs.show', $club) }}" class="text-blue-600 hover:underline mr-2 cursor-pointer">Voir</a>
                            <a href="{{ route('clubs.edit', $club) }}" class="text-yellow-600 hover:underline mr-2 cursor-pointer">Modifier</a>
                            <button type="button" class="text-red-600 hover:underline mr-2 cursor-pointer" onclick="window.dispatchEvent(new CustomEvent('open-delete-modal', {detail: {clubId: {{ $club->club_id }}, clubName: '{{ addslashes($club->nom) }}'}}))">Supprimer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $clubs->links() }}
        </div>
    </div>

    <!-- Modal de suppression -->
    <div id="deleteClubModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-2 text-red-700">Confirmer la suppression du club</h3>
            <div class="mb-4 text-gray-700 dark:text-gray-300">
                <span id="deleteClubName"></span><br>
                <span class="text-sm text-red-600">Cette action supprimera également toutes les relations (disciplines, personnes, compétitions, sources) associées à ce club.</span>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600" onclick="closeDeleteClubModal()">Annuler</button>
                <form id="deleteClubForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirmer</button>
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
