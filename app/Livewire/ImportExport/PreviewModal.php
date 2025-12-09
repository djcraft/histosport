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

    public function render()
    {
        return view('livewire.import-export.preview-modal', [
            'pendingImport' => $this->pendingImport,
        ]);
    }
}
