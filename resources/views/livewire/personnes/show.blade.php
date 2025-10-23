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
                <span class="block text-gray-900 dark:text-gray-100">
                    @if($personne->lieu_naissance)
                        {{ $personne->lieu_naissance->adresse ?? '' }} {{ $personne->lieu_naissance->code_postal ?? '' }} {{ $personne->lieu_naissance->commune ?? '' }}
                    @else
                        -
                    @endif
                </span>
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de décès :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $personne->date_deces }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu de décès :</span>
                <span class="block text-gray-900 dark:text-gray-100">
                    @if($personne->lieu_deces)
                        {{ $personne->lieu_deces->adresse ?? '' }} {{ $personne->lieu_deces->code_postal ?? '' }} {{ $personne->lieu_deces->commune ?? '' }}
                    @else
                        -
                    @endif
                </span>
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
            <span class="block text-gray-900 dark:text-gray-100">
                @if($personne->adresse)
                    {{ $personne->adresse->adresse ?? '' }} {{ $personne->adresse->code_postal ?? '' }} {{ $personne->adresse->commune ?? '' }}
                @else
                    -
                @endif
            </span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Clubs :</span>
            @foreach($personne->clubs as $club)
                <a href="{{ route('clubs.show', $club) }}" class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition">{{ $club->nom }}</a>
            @endforeach
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Disciplines :</span>
            @forelse($personne->disciplines as $discipline)
                <a href="{{ route('disciplines.show', $discipline) }}" class="inline-block bg-blue-200 dark:bg-blue-700 text-xs rounded px-2 py-1 mr-1 hover:bg-blue-300 dark:hover:bg-blue-600 transition">{{ $discipline->nom }}</a>
            @empty
                <span class="text-gray-500">Aucune</span>
            @endforelse
        </div>
        <div class="flex justify-end">
            <a href="{{ route('personnes.edit', $personne) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Modifier</a>
        </div>
    </div>
</div>
