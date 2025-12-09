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
        $import = PendingImport::find($id);
        if ($import) {
            $import->status = 'validated';
            $import->save();
            // À compléter : synchronisation des entités en base définitive
        }
    }

    /**
     * Liste les imports en attente.
     */
    public function listPendingImports(): iterable
    {
        return PendingImport::where('status', 'pending')->get();
    }
}
