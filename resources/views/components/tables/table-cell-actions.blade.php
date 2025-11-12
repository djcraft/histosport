<td>
    <div class="flex flex-row gap-2 justify-center">
    <x-buttons.button as="a" :href="route($routes['show'], $entity)" variant="link-primary">Voir</x-buttons.button>
    <x-buttons.button as="a" :href="route($routes['edit'], $entity)" variant="link-orange">Modifier</x-buttons.button>
    @php
        $entityType = $entity::$entityType ?? null;
        $entityId = $entityType === 'competition' ? $entity->competition_id :
                    ($entityType === 'club' ? $entity->club_id :
                    ($entityType === 'discipline' ? $entity->discipline_id :
                    ($entityType === 'lieu' ? $entity->lieu_id :
                    ($entityType === 'personne' ? $entity->personne_id :
                    ($entityType === 'source' ? $entity->source_id : $entity->id)))));
        $eventName = 'open-delete-' . $entityType . '-modal';
    @endphp
    <x-buttons.button as="a" href="#" variant="link-danger" onclick="window.dispatchEvent(new CustomEvent('{{ $eventName }}', {detail: {entityId: {{ $entityId }}, entityName: '{{ addslashes($entity->nom ?? $entity->titre ?? '') }}'}}))">Supprimer</x-buttons.button>
    </div>
</td>
