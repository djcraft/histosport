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
                <x-badge class="mr-1">
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
                <x-badge class="mr-1">
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
                <x-badge class="mr-1">
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
                <x-badge class="mr-1">{{ $club->nom }}</x-badge>
            </a>
        @endforeach
    </td>
    <x-table-cell-actions :entity="$personne" :routes="['show' => 'personnes.show', 'edit' => 'personnes.edit', 'delete' => 'personnes.destroy']"/>
</tr>
