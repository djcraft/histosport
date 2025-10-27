<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Disciplines</h1>
        <a href="{{ route('disciplines.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Ajouter une discipline</a>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                    
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($disciplines as $discipline)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $discipline->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $discipline->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('disciplines.show', $discipline) }}" class="text-blue-600 hover:underline mr-2 cursor-pointer">Voir</a>
                            <a href="{{ route('disciplines.edit', $discipline) }}" class="text-yellow-600 hover:underline mr-2 cursor-pointer">Modifier</a>
                            <button type="button" class="text-red-600 hover:underline mr-2 cursor-pointer" onclick="window.dispatchEvent(new CustomEvent('open-delete-discipline-modal', {detail: {disciplineId: {{ $discipline->discipline_id }}, disciplineName: '{{ addslashes($discipline->nom) }}'}}))">Supprimer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
</script>
