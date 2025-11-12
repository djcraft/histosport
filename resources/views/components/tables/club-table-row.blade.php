@props(['club'])
<tr>
    <td class="px-4 py-4 text-center whitespace-nowrap">
        <input type="checkbox" class="club-checkbox" value="{{ $club->id }}">
    </td>
    <td class="whitespace-nowrap text-center">{{ $club->nom }}</td>
    <td class="whitespace-nowrap text-center">{{ $club->nom_origine }}</td>
    <td class="whitespace-nowrap text-center">{{ $club->surnoms }}</td>
    <td class="whitespace-nowrap text-center">{{ $club->date_fondation }}</td>
    <td class="whitespace-nowrap text-center">{{ $club->date_disparition }}</td>
    <td class="whitespace-nowrap text-center">{{ $club->date_declaration }}</td>
    <td class="whitespace-nowrap text-center">{{ $club->acronyme }}</td>
    <td class="whitespace-nowrap text-center">{{ $club->couleurs }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100 text-center">
        @if($club->siege)
            <a href="{{ route('lieux.show', $club->siege) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $club->siege->nom ?? '' }}{{ $club->siege->nom ? ', ' : '' }}
                    {{ $club->siege->adresse ?? '' }}{{ $club->siege->adresse ? ', ' : '' }}
                    {{ $club->siege->commune ?? '' }}{{ $club->siege->commune ? ', ' : '' }}
                    {{ $club->siege->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">
        @foreach($club->disciplines as $discipline)
            <a href="{{ route('disciplines.show', $discipline) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $discipline->nom }}</x-badges.badge>
            </a>
        @endforeach
    </td>
    <x-tables.table-cell-actions :entity="$club" :routes="['show' => 'clubs.show', 'edit' => 'clubs.edit', 'delete' => 'clubs.destroy']"/>
</tr>
