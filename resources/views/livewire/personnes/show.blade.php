<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail de la personne</h2>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->nom }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Prénom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->prenom }}</span>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de naissance :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $personne->date_naissance }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de naissance :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $personne->lieu_naissance->adresse ?? '-' }}</span>
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de décès :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $personne->date_deces }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de décès :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $personne->lieu_deces->adresse ?? '-' }}</span>
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sexe :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->sexe }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Titre :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->titre }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Adresse :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $personne->adresse->adresse ?? '-' }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Clubs :</span>
            @foreach($personne->clubs as $club)
                <span class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1">{{ $club->nom }}</span>
            @endforeach
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Disciplines :</span>
            @forelse($personne->disciplines as $discipline)
                <span class="inline-block bg-blue-200 dark:bg-blue-700 text-xs rounded px-2 py-1 mr-1">{{ $discipline->nom }}</span>
            @empty
                <span class="text-gray-500">Aucune</span>
            @endforelse
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sources :</span>
            <div class="mt-1">
                @forelse($personne->sources as $source)
                    <span class="inline-block bg-green-200 dark:bg-green-700 text-xs rounded px-2 py-1 mr-1">{{ $source->titre }}</span>
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endforelse
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('personnes.edit', $personne) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Modifier</a>
        </div>
    </div>
</div>
