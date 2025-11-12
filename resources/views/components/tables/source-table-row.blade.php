@props(['source'])
<tr>
    <td class="px-4 py-4 text-center whitespace-nowrap">
        <input type="checkbox" class="source-checkbox" value="{{ $source->source_id }}">
    </td>
    <td class="whitespace-nowrap text-center">{{ $source->titre }}</td>
    <td class="whitespace-nowrap text-center">{{ $source->auteur }}</td>
    <td class="whitespace-nowrap text-center">{{ $source->annee_reference }}</td>
    <td class="whitespace-nowrap text-center">{{ $source->type }}</td>
    <td class="whitespace-nowrap text-center">{{ $source->cote }}</td>
    <td class="whitespace-nowrap text-center">
        @if($source->lieuEdition)
            <a href="{{ route('lieux.show', $source->lieuEdition) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $source->lieuEdition->nom ?? '' }} {{ $source->lieuEdition->adresse ?? '' }} {{ $source->lieuEdition->commune ?? '' }} {{ $source->lieuEdition->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">
        @if($source->lieuConservation)
            <a href="{{ route('lieux.show', $source->lieuConservation) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $source->lieuConservation->nom ?? '' }} {{ $source->lieuConservation->adresse ?? '' }} {{ $source->lieuConservation->commune ?? '' }} {{ $source->lieuConservation->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">
        @if($source->lieuCouverture)
            <a href="{{ route('lieux.show', $source->lieuCouverture) }}">
                <x-badges.badge class="inline-block bg-gray-200 dark:bg-gray-700 text-xs rounded px-2 py-1 mr-1 hover:bg-gray-300 dark:hover:bg-gray-600 transition align-middle text-gray-900 dark:text-gray-100">
                    {{ $source->lieuCouverture->nom ?? '' }} {{ $source->lieuCouverture->adresse ?? '' }} {{ $source->lieuCouverture->commune ?? '' }} {{ $source->lieuCouverture->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">{{ $source->url }}</td>
    <x-tables.table-cell-actions :entity="$source" :routes="['show' => 'sources.show', 'edit' => 'sources.edit', 'delete' => 'sources.destroy']"/>
</tr>
