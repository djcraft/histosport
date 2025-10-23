<?php

namespace App\Observers;

use App\Models\Historisation;
use Illuminate\Support\Facades\Auth;

class HistorisationPivotObserver
{
    // Utilise la propriété statique $entityType du modèle

    public function created($model)
    {
        Historisation::create([
            'entity_type'    => $model::$entityType ?? class_basename($model),
            'entity_id'      => $model->getKey(),
            'utilisateur_id' => Auth::id(),
            'action'         => 'created',
            'donnees_avant'  => null,
            'donnees_apres'  => json_encode($model->toArray()),
            'date'           => now(),
        ]);
    }

    public function updated($model)
    {
        Historisation::create([
            'entity_type'    => $model::$entityType ?? class_basename($model),
            'entity_id'      => $model->getKey(),
            'utilisateur_id' => Auth::id(),
            'action'         => 'updated',
            'donnees_avant'  => json_encode($model->getOriginal()),
            'donnees_apres'  => json_encode($model->toArray()),
            'date'           => now(),
        ]);
    }

    public function deleted($model)
    {
        Historisation::create([
            'entity_type'    => $model::$entityType ?? class_basename($model),
            'entity_id'      => $model->getKey(),
            'utilisateur_id' => Auth::id(),
            'action'         => 'deleted',
            'donnees_avant'  => json_encode($model->getOriginal()),
            'donnees_apres'  => null,
            'date'           => now(),
        ]);
    }
}
