
<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">{{ $competition->nom }}</h2>
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Nom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $competition->nom }}</span>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Date :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->date }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Lieu :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->lieu->adresse ?? '-' }}</span>
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Organisateur (club) :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->organisateur_club->nom ?? '-' }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Organisateur (personne) :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->organisateur_personne->nom ?? '-' }}</span>
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Type :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->type }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Durée :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->duree }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700 dark:text-gray-300">Niveau :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $competition->niveau }}</span>
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Participants :</span>
            <div class="mt-1">
                @foreach($competition->participants as $participant)
                    <span class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1">
                        {{ $participant->club ? $participant->club->nom : $participant->personne->nom }}
                        @if($participant->resultat)
                            <span class="ml-1 text-blue-600 dark:text-blue-300">({{ $participant->resultat }})</span>
                        @endif
                    </span>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Sources :</span>
            <div class="mt-1">
                @foreach($competition->sources as $source)
                    <span class="inline-block bg-blue-200 dark:bg-blue-700 text-xs rounded px-2 py-1 mr-1">{{ $source->titre }}</span>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Historisation :</span>
            <div class="mt-1">
                @foreach($competition->historisations as $hist)
                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                        <span>{{ $hist->action }} par {{ $hist->utilisateur->name ?? 'Utilisateur inconnu' }} le {{ $hist->date }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('competitions.edit', $competition) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Modifier</a>
        </div>
    </div>
</div>
