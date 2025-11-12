@props(['personne'])
<tr>
    <td class="px-4 py-4 text-center whitespace-nowrap">
        <input type="checkbox" class="personne-checkbox" value="{{ $personne->id }}">
    </td>
    <td class="whitespace-nowrap text-center">{{ $personne->nom }}</td>
    <td class="whitespace-nowrap text-center">{{ $personne->prenom }}</td>
    <td class="whitespace-nowrap text-center">{{ $personne->date_naissance }}</td>
    <td class="whitespace-nowrap text-center">
        @if($personne->lieu_naissance)
            <a href="{{ route('lieux.show', $personne->lieu_naissance) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $personne->lieu_naissance->nom ?? '' }} {{ $personne->lieu_naissance->adresse ?? '' }} {{ $personne->lieu_naissance->commune ?? '' }} {{ $personne->lieu_naissance->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">{{ $personne->date_deces }}</td>
    <td class="whitespace-nowrap text-center">
        @if($personne->lieu_deces)
            <a href="{{ route('lieux.show', $personne->lieu_deces) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $personne->lieu_deces->nom ?? '' }} {{ $personne->lieu_deces->adresse ?? '' }} {{ $personne->lieu_deces->commune ?? '' }} {{ $personne->lieu_deces->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">{{ $personne->sexe }}</td>
    <td class="whitespace-nowrap text-center">{{ $personne->titre }}</td>
    <td class="whitespace-nowrap text-center">
        @if($personne->adresse)
            <a href="{{ route('lieux.show', $personne->adresse) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $personne->adresse->nom ?? '' }} {{ $personne->adresse->adresse ?? '' }} {{ $personne->adresse->commune ?? '' }} {{ $personne->adresse->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">
        @foreach($personne->clubs as $club)
            <a href="{{ route('clubs.show', $club) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">{{ $club->nom }}</x-badges.badge>
            </a>
        @endforeach
    </td>
    <x-tables.table-cell-actions :entity="$personne" :routes="['show' => 'personnes.show', 'edit' => 'personnes.edit', 'delete' => 'personnes.destroy']"/>
</tr>
