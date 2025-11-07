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
                <x-badge class="mr-1">
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
                <x-badge class="mr-1">
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
                <x-badge class="mr-1">
                    {{ $source->lieuCouverture->nom ?? '' }} {{ $source->lieuCouverture->adresse ?? '' }} {{ $source->lieuCouverture->commune ?? '' }} {{ $source->lieuCouverture->code_postal ?? '' }}
                </x-badge>
            </a>
        @else
            -
        @endif
    </td>
    <td class="whitespace-nowrap text-center">{{ $source->url }}</td>
    <x-table-cell-actions :entity="$source" :routes="['show' => 'sources.show', 'edit' => 'sources.edit', 'delete' => 'sources.destroy']"/>
</tr>
