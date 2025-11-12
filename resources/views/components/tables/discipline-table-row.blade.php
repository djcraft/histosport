@props(['discipline'])
<tr>
    <td class="px-4 py-4 text-center whitespace-nowrap"><input type="checkbox" class="discipline-checkbox" value="{{ $discipline->discipline_id }}"></td>
    <td class="whitespace-nowrap text-center">{{ $discipline->nom }}</td>
    <td class="whitespace-nowrap text-center">{{ $discipline->description }}</td>
    <x-tables.table-cell-actions :entity="$discipline" :routes="['show' => 'disciplines.show', 'edit' => 'disciplines.edit', 'delete' => 'disciplines.destroy']"/>
</tr>
