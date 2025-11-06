<?php

namespace App\Livewire\Actions;

use Lorisleiva\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class SyncRelations extends Action
{
    /**
     * Synchronise les relations d’un modèle Eloquent.
     * @param Model $model
     * @param array $relations Tableau associatif ['relation' => [ids]]
     * @return void
     */
    public function handle(Model $model, array $relations)
    {
        foreach ($relations as $relation => $ids) {
            if (method_exists($model, $relation)) {
                // Cas spécifique pour sources (pivot entity_type)
                if ($relation === 'sources') {
                    $model->$relation()->syncWithPivotValues(
                        array_map('intval', (array) $ids),
                        ['entity_type' => $model::$entityType]
                    );
                } else {
                    $model->$relation()->sync($ids);
                }
            }
        }
    }
}
