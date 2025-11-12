<td>
    <div class="flex flex-row gap-2 justify-center">
    <x-buttons.button as="a" :href="route($routes['show'], $entity)" variant="link-primary">Voir</x-buttons.button>
    <x-buttons.button as="a" :href="route($routes['edit'], $entity)" variant="link-orange">Modifier</x-buttons.button>
    <x-buttons.button as="a" href="#" variant="link-danger" onclick="window.dispatchEvent(new CustomEvent('open-delete-modal', {detail: {entityId: {{ $entity->id }}, entityName: '{{ addslashes($entity->nom) }}'}}))">Supprimer</x-buttons.button>
    </div>
</td>
