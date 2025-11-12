@props(['lieu'])
<tr>
    <td class="px-4 py-4 text-center whitespace-nowrap">
        <input type="checkbox" class="lieu-checkbox" value="{{ $lieu->lieu_id }}">
    </td>
    <td class="whitespace-nowrap text-center">{{ $lieu->nom }}</td>
    <td class="whitespace-nowrap text-center">{{ $lieu->adresse }}</td>
    <td class="whitespace-nowrap text-center">{{ $lieu->code_postal }}</td>
    <td class="whitespace-nowrap text-center">{{ $lieu->commune }}</td>
    <td class="whitespace-nowrap text-center">{{ $lieu->departement }}</td>
    <td class="whitespace-nowrap text-center">{{ $lieu->pays }}</td>
    <x-tables.table-cell-actions :entity="$lieu" :routes="['show' => 'lieux.show', 'edit' => 'lieux.edit', 'delete' => 'lieux.destroy']"/>
</tr>
