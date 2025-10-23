<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail du club</h2>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->nom }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Nom d'origine :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->nom_origine }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Surnoms :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->surnoms }}</span>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de fondation :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $club->date_fondation }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de disparition :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $club->date_disparition }}</span>
            </div>
            <div>
                <span class="block text-gray-700 dark:text-gray-300 font-semibold">Date de déclaration :</span>
                <span class="block text-gray-900 dark:text-gray-100">{{ $club->date_declaration }}</span>
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Acronyme :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->acronyme }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Couleurs :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->couleurs }}</span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Lieu (siège) :</span>
            <span class="block text-gray-900 dark:text-gray-100">
                @if($club->siege)
                    {{ $club->siege->adresse ?? '' }}<br>
                    {{ $club->siege->code_postal ?? '' }} {{ $club->siege->commune ?? '' }}<br>
                    {{ $club->siege->departement ?? '' }}<br>
                    {{ $club->siege->pays ?? '' }}
                @else
                    -
                @endif
            </span>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Disciplines :</span>
            <div class="mt-1">
                @foreach($club->disciplines as $discipline)
                    <span class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1">{{ $discipline->nom }}</span>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Sources :</span>
            <div class="mt-1">
                @forelse($club->sources as $source)
                    <span class="inline-block bg-gray-100 dark:bg-gray-800 text-xs rounded px-2 py-1 mr-1 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $source->titre }}</span>
                @empty
                    <span class="block text-gray-900 dark:text-gray-100">-</span>
                @endforelse
            </div>
        </div>
        <div class="mb-4">
            <span class="block text-gray-700 dark:text-gray-300 font-semibold">Notes :</span>
            <span class="block text-gray-900 dark:text-gray-100">{{ $club->notes }}</span>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('clubs.edit', $club) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Modifier</a>
        </div>
    </div>
</div>
