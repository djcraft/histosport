<?php
namespace App\Services\ImportExport;

use App\Models\ImportExport\PendingImport;
use App\Models\ImportExport\PendingImportEntity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MultiSheetImportService
{
    /**
     * Lance l'import multi-feuilles à partir d'un fichier Excel.
     * @param string $filePath
     * @param string $type (ex: club, competition...)
     * @param array $meta (infos utilisateur, etc.)
     * @return PendingImport
     */
    public function importFromFile(string $filePath, string $type, array $meta = []): PendingImport
    {
        // 1. Créer un enregistrement PendingImport
        $pendingImport = PendingImport::create([
            'type' => $type,
            'status' => 'pending',
            'meta' => $meta,
        ]);

        // 2. Lire le fichier Excel (toutes les feuilles)
        $sheets = Excel::toArray([], $filePath);

        // 3. Parcourir chaque feuille
        foreach ($sheets as $sheetIndex => $rows) {
            $sheetName = 'Sheet' . ($sheetIndex + 1); // À adapter si besoin
            foreach ($rows as $rowIndex => $row) {
                // 4. Normaliser les données (à adapter selon l'entité)
                $normalized = DataNormalizer::normalize($row, $type);
                // 5. Générer le hash canonique
                $hash = HashHelper::generate($normalized);
                // 6. Stocker dans PendingImportEntity
                PendingImportEntity::create([
                    'pending_import_id' => $pendingImport->id,
                    'entity_type' => $type,
                    'data' => $normalized,
                    'hash' => $hash,
                    'sheet_name' => $sheetName,
                    'row_number' => $rowIndex + 1,
                    'status' => 'pending',
                ]);
            }
        }

        return $pendingImport;
    }

    // D'autres méthodes pourront être ajoutées :
    // - analyse des conflits
    // - dry-run
    // - validation/synchronisation
}
