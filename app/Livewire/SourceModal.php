<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Source;

class SourceModal extends Component
{
    public $titre = '';
    public $auteur = '';
    public $annee_reference = '';
    public $type = '';
    public $cote = '';
    public $url = '';
    public $lieu_edition_id = null;
    public $lieu_conservation_id = null;
    public $lieu_couverture_id = null;
    public $show = false;

    protected $rules = [
        'titre' => 'required|string|max:255|unique:sources,titre',
        'auteur' => 'nullable|string|max:255',
        'annee_reference' => 'nullable|string|max:255',
        'type' => 'nullable|string|max:255',
        'cote' => 'nullable|string|max:255',
        'url' => 'nullable|string|max:255',
        'lieu_edition_id' => 'nullable|integer|exists:lieu,lieu_id',
        'lieu_conservation_id' => 'nullable|integer|exists:lieu,lieu_id',
        'lieu_couverture_id' => 'nullable|integer|exists:lieu,lieu_id',
    ];

    protected $listeners = ['openSourceModal' => 'open'];

    public function open()
    {
        $this->reset([
            'titre', 'auteur', 'annee_reference', 'type', 'cote', 'url',
            'lieu_edition_id', 'lieu_conservation_id', 'lieu_couverture_id'
        ]);
        $this->show = true;
    }

    public function save()
    {
        $this->validate();
        $anneeReferencePrecision = null;
        if (preg_match('/^\d{4}$/', $this->annee_reference)) {
            $anneeReferencePrecision = 'year';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->annee_reference)) {
            $anneeReferencePrecision = 'month';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->annee_reference)) {
            $anneeReferencePrecision = 'day';
        }
        $source = Source::create([
            'titre' => $this->titre,
            'auteur' => $this->auteur,
            'annee_reference' => $this->annee_reference,
            'annee_reference_precision' => $anneeReferencePrecision,
            'type' => $this->type,
            'cote' => $this->cote,
            'url' => $this->url,
            'lieu_edition_id' => $this->lieu_edition_id,
            'lieu_conservation_id' => $this->lieu_conservation_id,
            'lieu_couverture_id' => $this->lieu_couverture_id,
        ]);
        $this->dispatch('sourceCreated', id: $source->source_id);
        $this->show = false;
    }

    public function render()
    {
        $lieux = \App\Models\Lieu::all();
        return view('livewire.source-modal', compact('lieux'));
    }
}
