<?php
namespace App\Services\ImportExport;

use App\Models\ImportExport\PendingImport;
use App\Models\ImportExport\PendingImportEntity;

class TransactionStorageService
{
    /**
     * Récupère un import temporaire par son ID.
     */
    public function getPendingImport(int $id): ?PendingImport
    {
        return PendingImport::with('entities')->find($id);
    }

    /**
     * Supprime un import temporaire et ses entités.
     */
    public function deletePendingImport(int $id): void
    {
        PendingImport::where('id', $id)->delete();
    }

    /**
     * Valide un import temporaire (change le statut, à compléter avec la synchronisation réelle).
     */
    public function validatePendingImport(int $id): void
    {
        $import = PendingImport::with('entities')->find($id);
        if ($import && $import->status === 'pending') {
            foreach ($import->entities as $entity) {
                switch ($entity->entity_type) {
                    case 'club':
                        $this->syncClub($entity->data);
                        break;
                    case 'personne':
                        $this->syncPersonne($entity->data);
                        break;
                    // Ajouter d'autres entités ici
                    default:
                        // Synchronisation générique ou ignorée
                        break;
                }
                $entity->status = 'validated';
                $entity->save();
            }
            $import->status = 'validated';
            $import->save();
        }
    }

    protected function syncClub(array $data): void
    {
        // Exemple de synchronisation pour un club
        // Recherche ou création selon les champs normalisés
        $club = \App\Models\Club::findNormalized($data);
        if ($club) {
            $club->update($data);
        } else {
            $club = \App\Models\Club::create($data);
        }
        // À compléter : gestion des relations (disciplines, personnes, etc.)
    }

    protected function syncPersonne(array $data): void
    {
        // Exemple de synchronisation pour une personne
        $personne = \App\Models\Personne::findNormalized($data);
        if ($personne) {
            $personne->update($data);
        } else {
            $personne = \App\Models\Personne::create($data);
        }
        // À compléter : gestion des relations
    }

    /**
     * Liste les imports en attente.
     */
    public function listPendingImports(): iterable
    {
        return PendingImport::where('status', 'pending')->get();
    }
}
