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
                            <a href="{{ route('disciplines.show', $discipline) }}" class="text-blue-600 hover:underline mr-2">Voir</a>
                            <a href="{{ route('disciplines.edit', $discipline) }}" class="text-yellow-600 hover:underline mr-2">Modifier</a>
                            <!-- Bouton supprimer retiré -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $disciplines->links() }}
        </div>
        <!-- Modal de confirmation suppression retiré -->
    </div>
</div>
