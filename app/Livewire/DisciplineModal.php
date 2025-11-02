<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Discipline;

class DisciplineModal extends Component
{
    public $nom = '';
    public $description = '';
    public $show = false;

    protected $rules = [
        'nom' => 'required|string|max:255|unique:disciplines,nom',
        'description' => 'nullable|string',
    ];

    protected $listeners = ['openDisciplineModal' => 'open'];

    public function open()
    {
        $this->reset(['nom', 'description']);
        $this->show = true;
    }

    public function save()
    {
        $this->validate();
        $discipline = Discipline::create([
            'nom' => $this->nom,
            'description' => $this->description,
        ]);
        $this->dispatch('disciplineCreated', id: $discipline->discipline_id);
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.discipline-modal');
    }
}
