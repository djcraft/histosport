<?php


namespace App\Livewire;

use Livewire\Component;

class SearchBar extends Component
{
    public string $search = '';
    public array $results = [];
    #[\Livewire\Attributes\Modelable]
    public $selected = [];
    public bool $multi = true;

    // Paramètres dynamiques
    public string $entityClass = '';
    public string $displayField = '';
    public array $searchFields = [];
    public string $idField = 'id';

    public function mount()
    {
        // Les propriétés sont déjà initialisées par Livewire via les attributs du composant
        // On s'assure juste que selected est bien un tableau pour multi, ou une valeur unique pour simple
        if ($this->multi) {
            if (!is_array($this->selected)) {
                $this->selected = $this->selected ? [$this->selected] : [];
            }
        } else {
            if (is_array($this->selected)) {
                $this->selected = count($this->selected) ? $this->selected[0] : null;
            }
        }
    }

    public function searchUpdated()
    {
        $this->results = [];
        if (trim($this->search) === '') {
            return;
        }
        $model = app($this->entityClass);
        $query = $model::query();
        $query->where(function($q) {
            foreach ($this->searchFields as $field) {
                $q->orWhere($field, 'like', '%' . $this->search . '%');
            }
        });
        $query->limit(10);
        $this->results = $query->get()->toArray();
    }

    public function select($id)
    {
        if ($this->multi) {
            if (!is_array($this->selected)) {
                $this->selected = [];
            }
            if (!in_array($id, $this->selected)) {
                $this->selected[] = $id;
            }
        } else {
            $this->selected = $id;
        }
        $this->search = '';
        $this->results = [];
    }

    public function remove($id)
    {
        if ($this->multi) {
            $this->selected = array_filter((array)$this->selected, fn($itemId) => $itemId != $id);
        } else {
            $this->selected = null;
        }
    }

    public function render()
    {
        $model = app($this->entityClass);
        $ids = [];
        if (is_array($this->selected)) {
            $ids = $this->selected;
        } elseif (is_null($this->selected)) {
            $ids = [];
        } else {
            $ids = [$this->selected];
        }
        $selectedItems = $model::whereIn($this->idField, $ids)->get();
        return view('livewire.search-bar', [
            'selectedItems' => $selectedItems,
            'displayField' => $this->displayField,
            'idField' => $this->idField,
            'results' => $this->results,
            'search' => $this->search,
            'multi' => $this->multi,
        ]);
    }
}
