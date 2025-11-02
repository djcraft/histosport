<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Lieu;

class LieuModal extends Component
{
    public $nom = '';
    public $adresse = '';
    public $code_postal = '';
    public $commune = '';
    public $departement = '';
    public $pays = '';
    public $show = false;

    protected $rules = [
        'nom' => 'nullable|string|max:255',
        'adresse' => 'nullable|string|max:255',
        'code_postal' => 'nullable|string|max:20',
        'commune' => 'nullable|string|max:100',
        'departement' => 'nullable|string|max:100',
        'pays' => 'nullable|string|max:100',
    ];

    protected $listeners = ['openLieuModal' => 'open'];

    public function open()
    {
        $this->reset(['nom', 'adresse', 'code_postal', 'commune', 'departement', 'pays']);
        $this->show = true;
    }

    public function save()
    {
        $this->validate();
        $lieu = Lieu::create([
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'code_postal' => $this->code_postal,
            'commune' => $this->commune,
            'departement' => $this->departement,
            'pays' => $this->pays,
        ]);
        $this->dispatch('lieuCreated', id: $lieu->lieu_id);
        $this->show = false;
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.lieu-modal');
    }
}
