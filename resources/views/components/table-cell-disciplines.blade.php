@props(['entity'])
<td>
    @foreach($entity->disciplines as $discipline)
        <a href="{{ route('disciplines.show', $discipline) }}">
            <x-badge class="mr-1">{{ $discipline->nom }}</x-badge>
        </a>
    @endforeach
</td>
