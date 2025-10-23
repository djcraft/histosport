<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HistorisationRestoreController extends Controller
{
    /**
     * Restaure l’état d’une entité à partir d’une historisation.
     * Cette action ne doit être appelée que depuis la vue historisations.index.
     */
    public function restore(Request $request, $id)
    {
        // Vérification d’origine de la requête
        if ($request->headers->get('referer') === null || !str_contains($request->headers->get('referer'), route('historisations.index'))) {
            abort(403, 'Accès interdit');
        }
        $historisation = Historisation::findOrFail($id);
        $entityType = $historisation->entity_type;
        $entityId = $historisation->entity_id;
        $donneesAvant = $historisation->donnees_avant;
        if (!$donneesAvant) {
            return Redirect::back()->with('error', 'Aucune donnée à restaurer.');
        }
        // Restauration générique
        $modelClass = $this->resolveModelClass($entityType);
        if (!$modelClass) {
            return Redirect::back()->with('error', 'Type d’entité non supporté.');
        }
        $entity = $modelClass::find($entityId);
        if (!$entity) {
            return Redirect::back()->with('error', 'Entité introuvable.');
        }
        $data = json_decode($donneesAvant, true);
        DB::beginTransaction();
        try {
            $entity->update($data);
            DB::commit();
            return Redirect::back()->with('success', 'Entité restaurée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Erreur lors de la restauration.');
        }
    }

    /**
     * Résout le nom de la classe du modèle à partir du type d’entité.
     */
    protected function resolveModelClass($entityType)
    {
        $map = [
            'personne' => \App\Models\Personne::class,
            'club' => \App\Models\Club::class,
            'competition' => \App\Models\Competition::class,
            'lieu' => \App\Models\Lieu::class,
            'discipline' => \App\Models\Discipline::class,
            'source' => \App\Models\Source::class,
        ];
        return $map[$entityType] ?? null;
    }
}
