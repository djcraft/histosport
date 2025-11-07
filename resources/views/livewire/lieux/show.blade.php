<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail du lieu</h2>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $lieu->nom }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Adresse :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $lieu->adresse }}</span>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Code postal :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $lieu->code_postal }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Commune :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $lieu->commune }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Département :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $lieu->departement }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Pays :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $lieu->pays }}</span>
            </div>
        </div>
        <div class="flex justify-end">
            <x-button as="a" href="{{ route('lieux.edit', $lieu) }}" variant="link-orange">Modifier</x-button>
        </div>
    </div>
</div>
