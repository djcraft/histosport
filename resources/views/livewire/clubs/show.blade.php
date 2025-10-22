<x-layouts.app title="Détail du club">
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail du club</h2>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->nom }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu (siège) :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->siege->nom ?? '-' }}</span>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('clubs.edit', $club) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Modifier</a>
        </div>
    </div>
</x-layouts.app>
