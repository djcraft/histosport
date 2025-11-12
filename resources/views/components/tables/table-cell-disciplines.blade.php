@props(['entity'])
<td>
    @foreach($entity->disciplines as $discipline)
        <a href="{{ route('disciplines.show', $discipline) }}">
            <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $discipline->nom }}</x-badges.badge>
        </a>
    @endforeach
</td>
