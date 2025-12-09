<?php
namespace App\Livewire\ImportExport;

use App\Livewire\BaseCrudComponent;
use App\Services\ImportExport\TransactionStorageService;

class PreviewModal extends BaseCrudComponent
{
    public int $pendingImportId;
    public $pendingImport;

    public function mount(int $pendingImportId)
    {
        $this->pendingImportId = $pendingImportId;
        $this->pendingImport = (new TransactionStorageService())->getPendingImport($pendingImportId);
    }

    public function validateImport()
    {
        (new TransactionStorageService())->validatePendingImport($this->pendingImportId);
        $this->notify('Import validé et synchronisé.', 'success');
        // Recharger l'import pour mise à jour du statut
        $this->pendingImport = (new TransactionStorageService())->getPendingImport($this->pendingImportId);
    }

    public function rejectImport()
    {
        (new TransactionStorageService())->deletePendingImport($this->pendingImportId);
        $this->notify('Import rejeté et supprimé.', 'danger');
        $this->pendingImport = null;
    }

    public function render()
    {
        return view('livewire.import-export.preview-modal', [
            'pendingImport' => $this->pendingImport,
        ]);
    }
}
