<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Compétitions</h1>
        <a href="{{ route('competitions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Ajouter une compétition</a>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Organisateur club</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Organisateur personne</th>
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
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->lieu->adresse ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->organisateur_club->nom ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->organisateur_personne->nom ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->duree }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->niveau }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $competition->discipline->nom ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('competitions.show', $competition) }}" class="text-blue-600 hover:underline mr-2">Voir</a>
                            <a href="{{ route('competitions.edit', $competition) }}" class="text-yellow-600 hover:underline mr-2">Modifier</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $competitions->links() }}
        </div>
    </div>
</div>
