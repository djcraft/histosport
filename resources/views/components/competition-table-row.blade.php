@props(['competition'])
<tr>
    <td class="px-4 py-4 text-center whitespace-nowrap">
        <input type="checkbox" class="competition-checkbox" value="{{ $competition->competition_id }}">
    </td>
    <td class="whitespace-nowrap text-center">{{ $competition->nom }}</td>
    <td class="whitespace-nowrap text-center">{{ $competition->date }}</td>
    <td class="whitespace-nowrap text-center">
        @if($competition->lieu)
            <a href="{{ route('lieux.show', $competition->lieu) }}">
                <x-badge>
                    {{ $competition->lieu->nom ?? '' }}{{ $competition->lieu->nom ? ', ' : '' }}
                    {{ $competition->lieu->adresse ?? '' }}{{ $competition->lieu->adresse ? ', ' : '' }}
                    {{ $competition->lieu->commune ?? '' }}{{ $competition->lieu->commune ? ', ' : '' }}
                    {{ $competition->lieu->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">
        @if($competition->organisateur_club)
            {{ $competition->organisateur_club->nom }}
        @elseif($competition->organisateur_personne)
            {{ $competition->organisateur_personne->nom }} {{ $competition->organisateur_personne->prenom }}
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">{{ $competition->type }}</td>
    <td class="whitespace-nowrap text-center">{{ $competition->duree }}</td>
    <td class="whitespace-nowrap text-center">{{ $competition->niveau }}</td>
    <td class="whitespace-nowrap text-center">
        @forelse($competition->disciplines as $discipline)
            <a href="{{ route('disciplines.show', $discipline) }}">
                <x-badge class="mr-1">{{ $discipline->nom }}</x-badge>
            </a>
        @empty
            -
        @endforelse
    </td>
    <x-table-cell-actions :entity="$competition" :routes="['show' => 'competitions.show', 'edit' => 'competitions.edit', 'delete' => 'competitions.destroy']"/>
</tr>
