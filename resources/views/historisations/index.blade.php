
<x-layouts.app :title="'Historisations'">
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Historique global des modifications</h1>
        <form method="GET" class="mb-4 flex gap-2">
            <select name="entity_type" class="border rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                <option value="" @if(request('entity_type') == '') selected @endif>Toutes les entités</option>
                <option value="personne" @if(request('entity_type') == 'personne') selected @endif>Personnes</option>
                <option value="club" @if(request('entity_type') == 'club') selected @endif>Clubs</option>
                <option value="competition" @if(request('entity_type') == 'competition') selected @endif>Compétitions</option>
                <option value="lieu" @if(request('entity_type') == 'lieu') selected @endif>Lieux</option>
                <option value="discipline" @if(request('entity_type') == 'discipline') selected @endif>Disciplines</option>
            </select>
            <input type="text" name="entity_id" placeholder="ID entité" class="border rounded px-2 py-1" value="{{ request('entity_id') }}">
            <button type="submit" class="px-4 py-1 bg-blue-600 text-white rounded">Filtrer</button>
        </form>
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
            @if($historisations->isEmpty())
                <div class="text-gray-500">Aucune modification enregistrée.</div>
            @else
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($historisations as $hist)
                        <li class="py-3 text-sm flex items-center justify-between">
                            <div>
                                <span class="font-bold">{{ ucfirst($hist->action) }}</span>
                                sur <span class="font-semibold">{{ $hist->entity_type }}</span> #{{ $hist->entity_id }}
                                par <span class="text-blue-700 dark:text-blue-300">{{ $hist->utilisateur->name ?? 'Utilisateur inconnu' }}</span>
                                le <span class="text-gray-600 dark:text-gray-400">{{ $hist->date }}</span>
                                @if($hist->action === 'updated')
                                    <details class="mt-1">
                                        <summary class="cursor-pointer text-xs text-gray-500">Voir les changements</summary>
                                        <div class="mt-1 grid grid-cols-2 gap-2">
                                            <div>
                                                <span class="font-semibold text-xs">Avant :</span>
                                                <pre class="bg-gray-100 dark:bg-gray-800 p-2 rounded text-xs">{{ json_encode(json_decode($hist->donnees_avant), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-xs">Après :</span>
                                                <pre class="bg-gray-100 dark:bg-gray-800 p-2 rounded text-xs">{{ json_encode(json_decode($hist->donnees_apres), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        </div>
                                    </details>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('historisations.restore', $hist->id) }}">
                                @csrf
                                <button type="submit" class="ml-2 px-2 py-1 bg-green-600 text-white rounded text-xs">Restaurer</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4">
                    {{ $historisations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
